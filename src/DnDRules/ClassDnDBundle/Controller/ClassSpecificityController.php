<?php

namespace DnDRules\ClassDnDBundle\Controller;

use DnDRules\ClassDnDBundle\Entity\ClassDnDLevel;
use DnDRules\ClassDnDBundle\Entity\ClassSpecificities;
use DnDRules\ClassDnDBundle\Form\BAB\ClassDnDForBABType;
use DnDRules\ClassDnDBundle\Form\ClassSpecificitiesType;
use DnDRules\ClassDnDBundle\Form\Sort\ClassDnDForSortType;
use DnDRules\ClassDnDBundle\Form\ST\ClassDnDForSTType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDRules\ClassDnDBundle\Entity\ClassDnD;
use DnDRules\ClassDnDBundle\Form\ClassDnDRegisterType;
use DnDRules\ClassDnDBundle\Form\ClassDnDEditType;
use DnDRules\ClassDnDBundle\Form\ClassBABType;
use DnDRules\ClassDnDBundle\Form\ClassSTType;

class ClassSpecificityController extends Controller
{
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneById($id);
        if ($classDnD === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('ClassDnD [id='.$id.'] undefined.');}

        $classSpecificitiesInstance = new ClassSpecificities();
        foreach($em->getRepository('DnDRulesClassDnDBundle:ClassSpecificity')->findBy(array('classDnD' => $classDnD)) as $classSpecificity) {
            $classSpecificitiesInstance->addClassSpecificity($classSpecificity);
        }

        $form = $this->createForm(new ClassSpecificitiesType(), $classSpecificitiesInstance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach($classSpecificitiesInstance->getClassSpecificities() as $classSpecificityGenerated) {
                $classSpecificityGenerated->setClassDnD($classDnD);
                $em->persist($classSpecificityGenerated);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre classe a bien été éditée.' );
            return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
        }
        
        return $this->render('DnDRulesClassDnDBundle:ClassDnD:Specificity/edit.html.twig', array(
                                'classDnD' => $classDnD,
                                'form' => $form->createView(),
                            ));
    }

    public function removeAction($id_specificity, $id_classDnD)
    {
        $em = $this->getDoctrine()->getManager();
        $classDnD = $em->getRepository('DnDRulesClassDnDBundle:ClassDnD')->findOneById($id_classDnD);
        if ($classDnD === null or !$this->get('security.context')->isGranted('ROLE_ADMIN')) {throw $this->createNotFoundException('ClassDnD [id='.$id_classDnD.'] undefined.');}

        $classSpecificity = $em->getRepository('DnDRulesClassDnDBundle:ClassSpecificity')->findOneBy(array('id' => $id_specificity, 'classDnD' => $classDnD));
        if ($classSpecificity === null) {throw $this->createNotFoundException('ClassSpecificity [id='.$id_specificity.'] undefined.');}

        $em->remove($classSpecificity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, votre classe a bien été éditée.' );
        return $this->redirect($this->generateUrl('dndrules_classdnd_classdnd_view', array('slug' => $classDnD->getSlug())));
    }
}
