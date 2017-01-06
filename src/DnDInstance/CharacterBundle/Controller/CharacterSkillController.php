<?php

namespace DnDInstance\CharacterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\CharacterBundle\Form\CharacterUsedAddSkillType;
use Symfony\Component\HttpFoundation\Request;

class CharacterSkillController extends Controller
{
    public function editSkillsAction($slug, Request $request)
    {
        if(isset($_GET['context']) and !empty($_GET['context'])) {$context = $_GET['context'];} else {$context = 'edit';}

        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneBySlug($slug);
        if($characterUsed === null) {throw $this->createNotFoundException('CharacterUsed : [slug='.$slug.'] undefined.');}
        if($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('CharacterUsed : [slug='.$slug.'] undefined.');}

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
                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre personnage est à présent créé !' );
                return $this->redirectToRoute('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug()));
            }
        }
        
        return $this->render('DnDInstanceCharacterBundle:CharacterUsed:skills/edit_skills.html.twig', array(
                                'characterUsed' => $characterUsed,
                                'form' => $form->createView(),
                                'context' => $context
                            ));
    }
}
