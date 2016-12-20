<?php

namespace DnDRules\SkillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\SkillBundle\Entity\Skill;
use DnDRules\SkillBundle\Form\SkillRegisterType;
use DnDRules\SkillBundle\Form\SkillEditType;

class SkillController extends Controller
{
    public function indexAction()
    {
        $listSkills = $this->getDoctrine()->getManager()->getRepository('DnDRulesSkillBundle:Skill')->findAll();
        return $this->render('DnDRulesSkillBundle:Skill:index.html.twig', array(
            'listSkills' => $listSkills,
        ));
    }
    
    public function registerAction()
    {
        $em = $this->getDoctrine()->getManager();
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Page inexistante.');}
        $skill = new Skill;

        $form = $this->createForm(new SkillRegisterType, $skill);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $skill->setCreateUser($this->getUser());
                    $em->persist($skill);
                    $em->flush();
                    // -- Gestion des CharacterSkill et des MonsterSkill
                    $skillAction = $this->container->get('dndrules_skill.skillaction');
                    $skillAction->getSkillforCharacters($skill);
                    $skillAction->getSkillforMonsters($skill);
                    // -- Affichage du nouveau Skill
                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la compétence a bien été créée.' );
                    return $this->redirect($this->generateUrl('dndrules_skill_skill_view', array('slug' => $skill->getSlug())));
                }
            }
        return $this->render('DnDRulesSkillBundle:Skill:Register/register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function viewAction($slug)
    {
        $skill = $this->getDoctrine()->getManager()->getRepository('DnDRulesSkillBundle:Skill')->findOneBySlug($slug);
        if ($skill === null) {throw $this->createNotFoundException('Compétence : [slug='.$slug.'] inexistante.');}
        
        return $this->render('DnDRulesSkillBundle:Skill:view.html.twig', array(
                                'skill' => $skill,
                            ));
    }
    
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository('DnDRulesSkillBundle:Skill')->findOneBySlug($slug);
        if($skill === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Compétence : [slug='.$slug.'] inexistante.');}

        $form = $this->createForm(new SkillEditType, $skill);
        $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                if ($form->isValid()) {
                    $skill->setUpdateUser($this->getUser());
                    $em->persist($skill);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'Félicitations, la compétence a bien été éditée.' );
                    return $this->redirect($this->generateUrl('dndrules_skill_skill_view', array('slug' => $skill->getSlug())));
                }
            }
        
        return $this->render('DnDRulesSkillBundle:Skill:Edit/edit.html.twig', array(
                                'skill' => $skill,
                                'form' => $form->createView(),
                            ));
    }
    
    public function deleteAction($slug)
    {
        $skill = $this->getDoctrine()->getManager()->getRepository('DnDRulesSkillBundle:Skill')->findOneBySlug($slug);
        if ($skill === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('Compétence : [slug='.$slug.'] inexistante.');}
        
        $skillAction = $this->container->get('dndrules_skill.skillaction');
        $skillAction->deleteSkill($skill);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre compétence a bien été supprimée.' );
        return $this->redirectToRoute('dndrules_skill_skill_home');
    }
}
