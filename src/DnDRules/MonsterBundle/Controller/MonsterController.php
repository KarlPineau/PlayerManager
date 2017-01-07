<?php

namespace DnDRules\MonsterBundle\Controller;

use DnDRules\MonsterBundle\Form\MonsterAbilitiesType;
use DnDRules\MonsterBundle\Form\MonsterEditFightType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\Monster;
use DnDRules\MonsterBundle\Form\MonsterRegisterType;
use DnDRules\MonsterBundle\Form\MonsterEditType;
use Symfony\Component\HttpFoundation\Request;

class MonsterController extends Controller
{
    public function indexAction()
    {
        $listMonsters = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Monster')->findAll();
        return $this->render('DnDRulesMonsterBundle:Monster:index.html.twig', array(
            'listMonsters' => $listMonsters,
        ));
    }
    
    public function viewAction($slug)
    {
        $monster = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Monster')->findOneBySlug($slug);
        if ($monster === null) {throw $this->createNotFoundException('Monster [slug='.$slug.'] undefined.');}
        
        return $this->render('DnDRulesMonsterBundle:Monster:view.html.twig', array(
                                'monster' => $monster,
                            ));
    }
    
    public function editAction($id=null, Request $request)
    {
        if(isset($_GET['context']) AND $_GET['context'] == 'register') {$context = 'register';}
        else {$context = 'edit';}

        $em = $this->getDoctrine()->getManager();
        if($id != null and $id != "null") {
            $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id);
            if($monster === null) {throw $this->createNotFoundException('Monster [id=' . $id . '] undefined.');}
        } else {
            $monster = new Monster();
            $monster->setCreateUser($this->getUser());
            $context = 'register';
        }
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page not found.');}
        
        $form = $this->createForm(new MonsterEditType(), $monster);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach($monster->getHpForm() as $HpForm) {
                $HpForm->setMonsterHpForm($monster);
                $em->persist($HpForm);

                $diceEntities = $HpForm->getDiceEntities();
                foreach ($diceEntities as $diceEntity) {
                    $diceEntity->setDiceForm($HpForm);
                    $em->persist($diceEntity);
                }

                $bonusNumbers = $HpForm->getBonusNumbers();
                foreach ($bonusNumbers as $bonusNumber) {
                    $bonusNumber->setDiceForm($HpForm);
                    $em->persist($bonusNumber);
                }
            }

            $monster->setUpdateUser($this->getUser());
            $em->persist($monster);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre monstre a bien été édité.' );
                return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
            } elseif($context == 'register') {
                return $this->redirect($this->generateUrl('dndrules_monster_monster_edit_fight', array('id' => $monster->getId(), 'context' => 'register')));
            }

        }
        
        return $this->render('DnDRulesMonsterBundle:Monster:Edit/edit.html.twig', array(
                                'monster' => $monster,
                                'form' => $form->createView(),
                                'context' => $context
                            ));
    }

    public function editFightAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id);
        if($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monster [id=' . $id . '] undefined.');}

        $form = $this->createForm(new MonsterEditFightType(), $monster);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $monster->setUpdateUser($this->getUser());
            $em->persist($monster);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre monstre a bien été édité.' );
                return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
            } elseif($context == 'register') {
                return $this->redirect($this->generateUrl('dndrules_monster_monster_edit_ability', array('id' => $monster->getId(), 'context' => $context)));
            }

        }

        return $this->render('DnDRulesMonsterBundle:Monster:EditFight/edit.html.twig', array(
            'monster' => $monster,
            'form' => $form->createView(),
            'context' => $context
        ));
    }
    
    public function deleteAction($id)
    {
        $monster = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id);
        if($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monster [id='.$id.'] undefined.');}
        
        $monsterAction = $this->container->get('dndrules_monster.monsteraction');
        $monsterAction->deleteMonster($monster);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre monstre a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_monster_monster_home');
    }

    public function deleteHpFormAction($id_monster, $id_HpForm)
    {
        $em = $this->getDoctrine()->getManager();
        $HpForm = $em->getRepository('PMHomeBundle:DiceForm')->findOneById($id_HpForm);
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id_monster);
        if($HpForm === null or $monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN') or $HpForm->getMonsterHpForm() != $monster) {throw $this->createNotFoundException('HpForm : [id='.$id_HpForm.'] undefined.');}

        $monster->removeHpForm($HpForm);
        $em->persist($monster);
        $em->remove($HpForm);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le dé de vie a bien été supprimé.');
        return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
    }
}
