<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\CharacterUsedAddSkillType;

class CharacterSkillController extends Controller
{
    public function registerSkillsAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $current_user = $this->getUser();
        // -- Récupération du personnage et des compétences :
        $repositoryCharacterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        
        // -- Création du formulaire :
        $form = $this->createForm(new CharacterUsedAddSkillType, $characterUsed);
        
        // -- Validation du formulaire :
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    // -- Gestion de la race
                    $skills = $characterUsed->getSkills();
                    foreach ($skills as $skill) {
                        $skill->setUpdateUser($current_user);
                        $em->persist($skill);
                    }
                    $em->persist($characterUsed);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
                    //Renvoie vers la page de gestion des Caractéristiques :
                    return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
                }
            }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:skills/register_skills.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
    
    public function editSkillsAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $current_user = $this->getUser();
        // -- Récupération du personnage et des compétences :
        $repositoryCharacterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed');
        $characterUsed = $repositoryCharacterUsed->findOneBySlug($slug);
        
        // -- Création du formulaire :
        $form = $this->createForm(new CharacterUsedAddSkillType, $characterUsed);
        
        // -- Validation du formulaire :
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    // -- Gestion de la race
                    $skills = $characterUsed->getSkills();
                    foreach ($skills as $skill) {
                        $skill->setUpdateUser($current_user);
                        $em->persist($skill);
                    }
                    $em->persist($characterUsed);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
                    //Renvoie vers la page de gestion des Caractéristiques :
                    return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
                }
            }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:skills/edit_skills.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                            ));
    }
}
