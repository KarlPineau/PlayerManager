<?php

namespace DnDRules\MonsterBundle\Controller;

use DnDRules\MonsterBundle\Entity\MonsterST;
use DnDRules\MonsterBundle\Form\MonsterSTType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MonsterSTController extends Controller
{
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id);
        if($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monster : [id='.$id.'] undefined.');}

        $monsterST = $em->getRepository('DnDRulesMonsterBundle:MonsterST')->findOneByMonster($monster);
        if($monsterST === null) {
            $monsterST = new MonsterST();
            $monsterST->setMonster($monster);
            $monsterST->setCreateUser($this->getUser());
            $em->persist($monsterST);
            $em->flush();
        }

        $form = $this->createForm(new MonsterSTType(), $monsterST);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($monsterST);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les jets de sauvegarde ont bien été mises à jour.' );
            return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
        }
        return $this->render('DnDRulesMonsterBundle:Monster:ST/edit.html.twig', array(
            'monster' => $monster,
            'form' => $form->createView(),
        ));
    }
}
