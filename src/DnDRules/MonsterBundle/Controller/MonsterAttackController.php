<?php

namespace DnDRules\MonsterBundle\Controller;

use DnDRules\MonsterBundle\Form\MonsterAbilitiesType;
use DnDRules\MonsterBundle\Form\MonsterAttacksExtremeInstanceType;
use DnDRules\MonsterBundle\Form\MonsterAttacksExtremeShortType;
use DnDRules\MonsterBundle\Form\MonsterAttacksExtremeType;
use DnDRules\MonsterBundle\Form\MonsterAttacksType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\Monster;
use DnDRules\MonsterBundle\Form\MonsterRegisterType;
use DnDRules\MonsterBundle\Form\MonsterEditType;
use Symfony\Component\HttpFoundation\Request;

class MonsterAttackController extends Controller
{
    public function editAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id);
        if($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monster : [id='.$id.'] undefined.');}

        $form = $this->createForm(new MonsterAttacksType(), $monster);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $monster->setUpdateUser($this->getUser());

            foreach($monster->getAttackInstances() as $attackInstance) {
                foreach($attackInstance->getDamageForms() as $damageForm) {
                    $damageForm->setMonsterAttackDamage($attackInstance);
                    $em->persist($damageForm);

                    $diceEntities = $damageForm->getDiceEntities();
                    foreach ($diceEntities as $diceEntity) {
                        $diceEntity->setDiceForm($damageForm);
                        $em->persist($diceEntity);
                    }

                    $bonusNumbers = $damageForm->getBonusNumbers();
                    foreach ($bonusNumbers as $bonusNumber) {
                        $bonusNumber->setDiceForm($damageForm);
                        $em->persist($bonusNumber);
                    }
                }

                foreach($attackInstance->getDamageCriticForms() as $damageCriticForm) {
                    $damageCriticForm->setMonsterAttackCritic($attackInstance);
                    $em->persist($damageCriticForm);
                }

                $attackInstance->setMonsterAttackInstances($monster);
                $em->persist($attackInstance);
            }

            $em->persist($monster);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les attaques ont bien été mises à jour.' );
                return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
            } elseif($context == 'register') {
                return $this->redirect($this->generateUrl('dndrules_monster_monster_edit_attack_extreme', array('id' => $monster->getId(), 'context' => $context)));
            }
        }
        return $this->render('DnDRulesMonsterBundle:Monster:Attack/edit.html.twig', array(
            'monster' => $monster,
            'form' => $form->createView(),
            'context' => $context
        ));
    }

    public function deleteAttackInstanceAction($id_monster, $id_attack)
    {
        $em = $this->getDoctrine()->getManager();
        $monsterAttack = $em->getRepository('DnDRulesMonsterBundle:MonsterAttackInstance')->findOneById($id_attack);
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id_monster);
        if($monsterAttack === null or $monster === null or $monsterAttack->getMonsterAttackInstances() != $monster or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('MonsterInstance : [id='.$id_attack.'] undefined.');}

        $monster->removeAttackInstance($monsterAttack);
        $em->persist($monster);
        $em->remove($monsterAttack);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, l\'attaque a bien été supprimée.');
        return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
    }

    public function deleteAttackInstanceDamageFormAction($id_attackInstance, $id_damageForm)
    {
        $em = $this->getDoctrine()->getManager();
        $damageForm = $em->getRepository('PMHomeBundle:DiceForm')->findOneById($id_damageForm);
        $monsterAttack = $em->getRepository('DnDRulesMonsterBundle:MonsterAttackInstance')->findOneById($id_attackInstance);
        if($damageForm === null or $monsterAttack === null or !$this->get('security.context')->isGranted('ROLE_ADMIN') or $damageForm->getMonsterAttackDamage() != $monsterAttack) {throw $this->createNotFoundException('DamageForm : [id='.$id_damageForm.'] undefined.');}

        $monsterAttack->removeDamageForm($damageForm);
        $em->persist($monsterAttack);
        $em->remove($damageForm);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le dé de dégâts a bien été supprimée.');
        return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monsterAttack->getMonsterAttackInstances()->getSlug())));
    }

    public function deleteAttackInstanceCriticAction($id_attackInstance, $id_critic)
    {
        $em = $this->getDoctrine()->getManager();
        $critic = $em->getRepository('PMHomeBundle:Critical')->findOneById($id_critic);
        $monsterAttack = $em->getRepository('DnDRulesMonsterBundle:MonsterAttackInstance')->findOneById($id_attackInstance);
        if($critic === null or $monsterAttack === null or !$this->get('security.context')->isGranted('ROLE_ADMIN') or $critic->getMonsterAttackCritic() != $monsterAttack) {throw $this->createNotFoundException('Critical : [id='.$id_critic.'] undefined.');}

        $monsterAttack->removeDamageCriticForms($critic);
        $em->persist($monsterAttack);
        $em->remove($critic);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le coup critique a bien été supprimée.');
        return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monsterAttack->getMonsterAttackInstances()->getSlug())));
    }

    public function editExtremeAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneById($id);
        if($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monster : [id='.$id.'] undefined.');}

        $form = $this->createForm(new MonsterAttacksExtremeShortType(), $monster);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $monster->setUpdateUser($this->getUser());
            $em->persist($monster);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les attaques ont bien été mises à jour.' );
                return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
            } elseif($context == 'register') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre monstre est à présent généré.' );
                return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
            }
        }
        return $this->render('DnDRulesMonsterBundle:Monster:Attack/editExtreme.html.twig', array(
            'monster' => $monster,
            'form' => $form->createView(),
            'context' => $context
        ));
    }
}
