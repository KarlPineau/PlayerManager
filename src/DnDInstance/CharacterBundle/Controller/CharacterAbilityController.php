<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CharacterAbilityController extends Controller
{
    public function registerAbilitiesAction($slug, Request $request)
    {
        // -- Récupération du personnage et de ses caractéristiques :
        $manager = $this->getDoctrine()
                           ->getManager();
        $repositoryCharacterUsed = $manager->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $repositoryAbility = $manager->getRepository('DnDInstanceCharacterBundle:CharacterAbility');
 
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        $abilities = $repositoryAbility->findBy(array('characterUsed' => $characterUsed),
                                                array('ability' => 'ASC'),
                                                6,
                                                0);

        // -- Génération du formulaire
        $defaultData = array('strength' => $abilities[0]->getValue(),
                             'dexterity' => $abilities[1]->getValue(),
                             'constitution' => $abilities[2]->getValue(),
                             'intelligence' => $abilities[3]->getValue(),
                             'wisdom' => $abilities[4]->getValue(),
                             'charisma' => $abilities[5]->getValue(),);
        $form = $this->createFormBuilder($defaultData)
            ->add('strength',       'integer',  array('required' => true))
            ->add('dexterity',      'integer',  array('required' => true))
            ->add('constitution',   'integer',  array('required' => true))
            ->add('intelligence',   'integer',  array('required' => true))
            ->add('wisdom',         'integer',  array('required' => true))
            ->add('charisma',       'integer',  array('required' => true))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $abilities[0]->setValue($data['strength']); $em->persist($abilities[0]);
            $abilities[1]->setValue($data['dexterity']); $em->persist($abilities[1]);
            $abilities[2]->setValue($data['constitution']); $em->persist($abilities[2]);
            $abilities[3]->setValue($data['intelligence']); $em->persist($abilities[3]);
            $abilities[4]->setValue($data['wisdom']); $em->persist($abilities[4]);
            $abilities[5]->setValue($data['charisma']); $em->persist($abilities[5]);
            $em->flush();
                    
            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les caractéristiques de votre personnage ont bien été mises à jour.' );
            //Renvoie vers la page de gestion des Caractéristiques :
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_insert_skills', array('slug' => $characterUsed->getSlug())));
        }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:abilities/register_abilities.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
    
    public function editAbilitiesAction($slug, Request $request)
    {
        // -- Récupération du personnage et de ses caractéristiques :
        $manager = $this->getDoctrine()
                        ->getManager();
        $repositoryCharacterUsed = $manager->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $repositoryAbility = $manager->getRepository('DnDInstanceCharacterBundle:CharacterAbility');
 
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        $abilities = $repositoryAbility->findBy(array('characterUsed' => $characterUsed),
                                                array('ability' => 'ASC'),
                                                6,
                                                0);

        // -- Génération du formulaire
        $defaultData = array('strength' => $abilities[0]->getValue(),
                             'dexterity' => $abilities[1]->getValue(),
                             'constitution' => $abilities[2]->getValue(),
                             'intelligence' => $abilities[3]->getValue(),
                             'wisdom' => $abilities[4]->getValue(),
                             'charisma' => $abilities[5]->getValue(),);
        $form = $this->createFormBuilder($defaultData)
            ->add('strength',       'integer',  array('required' => true))
            ->add('dexterity',      'integer',  array('required' => true))
            ->add('constitution',   'integer',  array('required' => true))
            ->add('intelligence',   'integer',  array('required' => true))
            ->add('wisdom',         'integer',  array('required' => true))
            ->add('charisma',       'integer',  array('required' => true))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $abilities[0]->setValue($data['strength']); $em->persist($abilities[0]);
            $abilities[1]->setValue($data['dexterity']); $em->persist($abilities[1]);
            $abilities[2]->setValue($data['constitution']); $em->persist($abilities[2]);
            $abilities[3]->setValue($data['intelligence']); $em->persist($abilities[3]);
            $abilities[4]->setValue($data['wisdom']); $em->persist($abilities[4]);
            $abilities[5]->setValue($data['charisma']); $em->persist($abilities[5]);
            $em->flush();
                    
            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, les caractéristiques de votre personnage ont bien été mises à jour.' );
            //Renvoie vers la page de gestion des Caractéristiques :
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:abilities/edit_abilities.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
}
