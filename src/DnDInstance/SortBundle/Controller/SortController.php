<?php

namespace DnDInstance\SortBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DnDInstance\SortBundle\Entity\SortInstance;
use DnDInstance\SortBundle\Form\SortInstanceType;
use Symfony\Component\HttpFoundation\Request;

class SortController extends Controller
{
    public function instanceAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id.'] undefined.');}

        $sortInstance = new SortInstance();
        $sortInstance->setCreateUser($this->getUser());
        $sortInstance->setCharacterUsed($characterUsed);

        $arraySort = [];
        foreach($characterUsed->getClassDnDInstances() as $classDnDInstance) {
            $sortsByLevel = $this->get('dndrules_classdnd.classdndaction')->getSortsForLevelMaxByLevel($classDnDInstance->getClassDnD(), $this->get('dndinstance_character.characterusedclassdnd')->getMainLevel($characterUsed));
            $arraySort = array_merge($arraySort, $sortsByLevel);
        }
        foreach($em->getRepository('DnDInstanceSortBundle:SortInstance')->findByCharacterUsed($characterUsed) as $sortOfCharacterUser) {
            foreach($arraySort as $level) {
                foreach($level as $key => &$sortAvailable) {
                    if ($sortOfCharacterUser->getSort() == $sortAvailable) {
                        unset($arraySort[$key]);
                    }
                }
            }
        }

        $form = $this->createForm(new SortInstanceType(), $sortInstance, array('attr' => array('sorts' => $arraySort)));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sortInstance);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le sort a bien été ajouté au personnage.');
            return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
        }
        return $this->render('DnDInstanceSortBundle:Sort:register_content.html.twig', array(
                                'form' => $form->createView(),
                                'characterUsed' => $characterUsed,
                            ));
    }

    public function removeAction($id_sortInstance, $id_characterUsed)
    {
        $em = $this->getDoctrine()->getManager();
        $characterUsed = $em->getRepository('DnDInstanceCharacterBundle:CharacterUsed')->findOneById($id_characterUsed);
        if($characterUsed === null or ($characterUsed->getUser() != $this->getUser() AND !$this->get('security.context')->isGranted('ROLE_ADMIN'))) {throw $this->createNotFoundException('CharacterUsed [id='.$id_characterUsed.'] undefined.');}

        $sortInstance = $em->getRepository('DnDInstanceSortBundle:SortInstance')->findOneBy(array('id' => $id_sortInstance, 'characterUsed' => $id_characterUsed));
        if($sortInstance === null) {throw $this->createNotFoundException('SortInstance [id='.$id_sortInstance.'] undefined.');}

        $em->remove($sortInstance);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le sort a bien été retiré au personnage.');
        return $this->redirect($this->generateUrl('dndinstance_characterused_characterused_view', array('slug' => $characterUsed->getSlug())));
    }
}
