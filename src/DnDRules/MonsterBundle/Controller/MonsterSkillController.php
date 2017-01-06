<?php

namespace DnDRules\MonsterBundle\Controller;

use DnDRules\MonsterBundle\Form\MonsterAbilitiesType;
use DnDRules\MonsterBundle\Form\MonsterSkillsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\Monster;
use DnDRules\MonsterBundle\Form\MonsterRegisterType;
use DnDRules\MonsterBundle\Form\MonsterEditType;
use Symfony\Component\HttpFoundation\Request;

class MonsterSkillController extends Controller
{
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id);
        if($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monster : [id='.$id.'] undefined.');}

        $form = $this->createForm(new MonsterSkillsType(), $monster);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $monster->setUpdateUser($this->getUser());
            foreach($form->get('skillInstances')->getData() as $skillInstances) {
                $skillInstances->setMonsterSkillInstances($monster);
                $em->persist($skillInstances);
            }
            $em->persist($monster);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les compétences ont bien été mises à jour.' );
            return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
        }
        return $this->render('DnDRulesMonsterBundle:Monster:Skill/edit.html.twig', array(
            'monster' => $monster,
            'form' => $form->createView(),
        ));
    }

    public function deleteSkillInstanceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $monsterSkill = $em->getRepository('DnDRulesMonsterBundle:MonsterSkillInstance')->findOneById($id);
        if($monsterSkill === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterInstance : [id='.$id.'] undefined.');}
        $monster = $monsterSkill->getMonsterSkillInstances();
        $monster->removeSkillInstance($monsterSkill);
        $em->persist($monster);
        $em->remove($monsterSkill);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la compétence a bien été supprimée.');
        return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
    }
}
