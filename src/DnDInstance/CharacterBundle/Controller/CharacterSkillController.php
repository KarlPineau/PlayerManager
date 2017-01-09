<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\CharacterUsedAddSkillType;
use Symfony\Component\HttpFoundation\Request;

class CharacterSkillController extends Controller
{
    public function editSkillsAction($id, $context, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $form = $this->createForm(new CharacterUsedAddSkillType, $characterUsed);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $skills = $characterUsed->getSkills();
            foreach ($skills as $skill) {
                $skill->setUpdateUser($this->getUser());
                $em->persist($skill);
            }
            $em->persist($characterUsed);
            $em->flush();

            if($context == 'edit') {
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage a bien été édité.' );
                return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
            } elseif($context == 'register') {
                return $this->redirectToRoute('dndinstance_characterused_characterused_edit_gift', array('id' => $characterUsed->getId(), 'context' => 'register'));
            } elseif($context == 'levelUp') {
                if($this->get('dndinstance_character.characterusedclassdnd')->getMainLevelInstance($characterUsed)->getGift() == true) {
                    return $this->redirectToRoute('dndinstance_characterused_characterused_edit_gift', array('id' => $characterUsed->getId(), 'context' => 'levelUp'));
                } else {
                    return $this->redirectToRoute('dndinstance_characterused_characterused_edit_hpmax', array('id' => $characterUsed->getId(), 'context' => 'levelUp'));
                }
            }
        }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:Skills/edit_skills.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                                'context' => $context
                            ));
    }
}
