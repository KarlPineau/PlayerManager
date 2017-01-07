<?php

namespace DnDRules\MonsterBundle\Controller;

use DnDRules\MonsterBundle\Form\MonsterAbilitiesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\Monster;
use DnDRules\MonsterBundle\Form\MonsterRegisterType;
use DnDRules\MonsterBundle\Form\MonsterEditType;
use Symfony\Component\HttpFoundation\Request;

class MonsterAbilityController extends Controller
{
    public function editAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id);
        if($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monster : [id='.$id.'] undefined.');}

        $form = $this->createForm(new MonsterAbilitiesType(), $monster);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $monster->setUpdateUser($this->getUser());
            foreach($form->get('abilityInstances')->getData() as $abilityInstances) {
                $abilityInstances->setMonsterAbilityInstances($monster);
                $em->persist($abilityInstances);
            }
            $em->persist($monster);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les caractéristiques ont bien été mises à jour.' );
                return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
            } elseif($context == 'register') {
                return $this->redirect($this->generateUrl('dndrules_monster_monster_edit_skill', array('id' => $monster->getId(), 'context' => $context)));
            }
        }
        return $this->render('DnDRulesMonsterBundle:Monster:Ability/edit.html.twig', array(
            'monster' => $monster,
            'form' => $form->createView(),
            'context' => $context
        ));
    }

    public function deleteAbilityInstanceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $monsterAbility = $em->getRepository('DnDRulesMonsterBundle:MonsterAbilityInstance')->findOneById($id);
        if($monsterAbility === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterInstance : [id='.$id.'] undefined.');}
        $monster = $monsterAbility->getMonsterAbilityInstances();
        $monster->removeAbilityInstance($monsterAbility);
        $em->persist($monster);
        $em->remove($monsterAbility);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la caractéristique a bien été supprimée.');
        return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
    }
}
