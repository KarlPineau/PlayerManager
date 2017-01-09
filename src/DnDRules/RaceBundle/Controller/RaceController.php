<?php

namespace DnDRules\RaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\RaceBundle\Entity\Race;
use DnDRules\RaceBundle\Entity\RaceAbility;
use DnDRules\RaceBundle\Form\RaceRegisterType;
use DnDRules\RaceBundle\Form\RaceEditType;
use Symfony\Component\HttpFoundation\Request;

class RaceController extends Controller
{
    public function indexAction()
    {
        $listRaces = $this->getDoctrine()->getManager()->getRepository('DnDRulesRaceBundle:Race')->findAll();
        return $this->render('DnDRulesRaceBundle:Race:index.html.twig', array(
            'listRaces' => $listRaces,
        ));
    }
    
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $race = new Race;

        // -- Gestion des Modificateurs de Caractéristiques de la Race :
        $repositoryAbility = $em->getRepository('DnDRulesAbilityBundle:Ability');
        $strength = new RaceAbility;        $strength->setCreateUser($this->getUser());        $strength->setAbility($repositoryAbility->findOneByName('Force'));              $strength->setValue(0);     $strength->setRace($race);
        $dexterity = new RaceAbility;       $dexterity->setCreateUser($this->getUser());       $dexterity->setAbility($repositoryAbility->findOneByName('Dextérité'));         $dexterity->setValue(0);    $dexterity->setRace($race);
        $constitution = new RaceAbility;    $constitution->setCreateUser($this->getUser());    $constitution->setAbility($repositoryAbility->findOneByName('Constitution'));   $constitution->setValue(0); $constitution->setRace($race);
        $intelligence = new RaceAbility;    $intelligence->setCreateUser($this->getUser());    $intelligence->setAbility($repositoryAbility->findOneByName('Intelligence'));   $intelligence->setValue(0); $intelligence->setRace($race);
        $wisdom = new RaceAbility;          $wisdom->setCreateUser($this->getUser());          $wisdom->setAbility($repositoryAbility->findOneByName('Sagesse'));              $wisdom->setValue(0);       $wisdom->setRace($race);
        $charisma = new RaceAbility;        $charisma->setCreateUser($this->getUser());        $charisma->setAbility($repositoryAbility->findOneByName('Charisme'));           $charisma->setValue(0);     $charisma->setRace($race);
        
        // -- Génération du formulaire :
        $form = $this->createForm(new RaceRegisterType, $race);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $race->setCreateUser($this->getUser());
            $em->persist($race);
            $strength->setValue($form->get('strength')->getData()); $em->persist($strength);
            $dexterity->setValue($form->get('dexterity')->getData()); $em->persist($dexterity);
            $constitution->setValue($form->get('constitution')->getData()); $em->persist($constitution);
            $intelligence->setValue($form->get('intelligence')->getData()); $em->persist($intelligence);
            $wisdom->setValue($form->get('wisdom')->getData()); $em->persist($wisdom);
            $charisma->setValue($form->get('charisma')->getData()); $em->persist($charisma);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la race a bien été créée.' );
            return $this->redirect($this->generateUrl('dndrules_race_race_view', array('slug' => $race->getSlug())));
        }
        return $this->render('DnDRulesRaceBundle:Race:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $race = $this->getDoctrine()->getManager()->getRepository('DnDRulesRaceBundle:Race')->findOneBySlug($slug);
        if ($race === null) {throw $this->createNotFoundException('Race : [slug='.$slug.'] inexistante.');}
        return $this->render('DnDRulesRaceBundle:Race:view.html.twig', array(
                                'race' => $race,
                            ));
    }
    
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $race = $em->getRepository('DnDRulesRaceBundle:Race')->findOneById($id);
        if($race === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Race [id='.$id.'] undefined.');}
        
        $form = $this->createForm(new RaceEditType, $race);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $race->setUpdateUser($this->getUser());
            $em->persist($race);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre race a bien été éditée.' );
            return $this->redirect($this->generateUrl('dndrules_race_race_view', array('slug' => $race->getSlug())));
        }
        
        return $this->render('DnDRulesRaceBundle:Race:Edit/edit.html.twig', array(
                                'race' => $race,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($id)
    {
        $race = $this->getDoctrine()->getManager()->getRepository('DnDRulesRaceBundle:Race')->findOneById($id);
        if ($race === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Race [id='.$id.'] undefined.');}

        $deleteRace = $this->container->get('dndrules_character.deleterace');
        $deleteRace->deleteRace($race);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre race a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_race_race_home');
    }
}
