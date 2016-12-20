<?php

namespace DnDRules\MonsterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\MonsterBundle\Entity\Monster;
use DnDRules\MonsterBundle\Form\MonsterRegisterType;
use DnDRules\MonsterBundle\Form\MonsterEditType;

class MonsterController extends Controller
{
    public function indexAction()
    {
        $listMonsters = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Monster')->findAll();
        return $this->render('DnDRulesMonsterBundle:Monster:index.html.twig', array(
            'listMonsters' => $listMonsters,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $monster = new Monster;

        $form = $this->createForm(new MonsterRegisterType, $monster);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $monster->setCreateUser($this->getUser());

                    $speedSpecialInstances = $monster->getSpeedSpecialInstances();
                    foreach ($speedSpecialInstances as $speedSpecialInstance) {
                        $speedSpecialInstance->setMonster($monster);                        
                        $em->persist($speedSpecialInstance);
                    }
                    
                    $skillInstances = $monster->getSkillInstances();
                    foreach ($skillInstances as $skillInstance) {
                        $skillInstance->setMonster($monster);                        
                        $em->persist($skillInstance);
                    }
                    
                    $abilityInstances = $monster->getAbilityInstances();
                    foreach ($abilityInstances as $abilityInstance) {
                        $abilityInstance->setMonster($monster);                        
                        $em->persist($abilityInstance);
                    }
                    
                    $diceForms = $monster->getHpForm();
                    foreach ($diceForms as $diceForm) {
                        $diceForm->setMonsterHpForm($monster);                        
                        $em->persist($diceForm);

                        $diceEntities = $diceForm->getDiceEntities();
                        foreach ($diceEntities as $diceEntity) {
                            $diceEntity->setDiceForm($diceForm);                        
                            $em->persist($diceEntity);
                        }

                        $bonusNumbers = $diceForm->getBonusNumbers();
                        foreach ($bonusNumbers as $bonusNumber) {
                            $bonusNumber->setDiceForm($diceForm);                        
                            $em->persist($bonusNumber);
                        }
                    }
                    
                    $em->persist($monster);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le monstre a bien été créé.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
                }
            }
        return $this->render('DnDRulesMonsterBundle:Monster:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $monster = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Monster')->findOneBySlug($slug);
        if ($monster === null) {throw $this->createNotFoundException('Monstre : [slug='.$slug.'] inexistant.');}
        
        return $this->render('DnDRulesMonsterBundle:Monster:view.html.twig', array(
                                'monster' => $monster,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $monster = $em->getRepository('DnDRulesMonsterBundle:Monster')->findOneBySlug($slug);
        if ($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monstre : [slug='.$slug.'] inexistant.');}
        
        $form = $this->createForm(new MonsterEditType, $monster);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $monster->setUpdateUser($this->getUser());
                    $em->persist($monster);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre monstre a bien été édité.' );
                    return $this->redirect($this->generateUrl('dndrules_monster_monster_view', array('slug' => $monster->getSlug())));
                }
            }
        
        return $this->render('DnDRulesMonsterBundle:Monster:Edit/edit.html.twig', array(
                                'monster' => $monster,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $monster = $this->getDoctrine()->getManager()->getRepository('DnDRulesMonsterBundle:Monster')->findOneBySlug($slug);
        if($monster === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Monstre : [slug='.$slug.'] inexistant.');}
        
        $monsterAction = $this->container->get('dndrules_monster.monsteraction');
        $monsterAction->deleteMonster($monster);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre monstre a bien été supprimé.' );
        return $this->redirectToRoute('dndrules_monster_monster_home');
    }
}
