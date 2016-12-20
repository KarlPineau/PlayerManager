<?php

namespace PM\ImportationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PM\ImportationBundle\Entity\Document;
use PM\ImportationBundle\Form\DocumentRegisterType;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function indexAction()
    {
        return $this->render('PMImportationBundle:Document:index.html.twig');
    }
    
    public function registerAction()
    {
        $document = new Document();
        $document->setTraitement(false);
        
        $form = $this->createForm(new DocumentRegisterType, $document);

        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($document);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Félicitations, le document a bien été créé.' );
                return $this->redirect($this->generateUrl('pm_document_administration_home'));
            }
        }
        return $this->render('PMImportationBundle:Document:register.html.twig', array(
                                'form' => $form->createView(),
                            ));
    }
    
    public function listAction()
    {
        $repository = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('PMImportationBundle:Document');
 
        $listDocuments = $repository->findAll();

        return $this->render('PMImportationBundle:Document:listDocuments.html.twig', array(
                                'listDocuments' => $listDocuments,
                            ));
    }
    
    public function processAction($document_id)
    {
        $repository = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('PMImportationBundle:Document');
        $document = $repository->findOneById($document_id);
        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($document, 'imageFile');
        
        $em = $this->getDoctrine()->getManager();
        $finder = new Finder();
        $finder->files()->in('../web/documents');
        $finder->files()->name($document->getImageName());

        $repositoryClassDnD = $this->getDoctrine()
                                   ->getManager()
                                   ->getRepository('DnDRulesClassDnDBundle:ClassDnD');
        $repositoryLevel = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('DnDRulesLevelBundle:Level');
        $repositoryDomain = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('DnDRulesSortBundle:Domain');
        $repositoryComposante = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('DnDRulesSortBundle:Composante');
        $repositorySortSchool = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('DnDRulesSortBundle:SortSchool');
        
        //Lecture des fichiers :
        foreach ($finder as $file) {
            $contents = $file->getContents();
            $dom = new Crawler($contents);

            //Lecture de OEUVRES :
            foreach ($dom as $domElement) {
            
                //Lecture des OEUVRE :
                foreach ($domElement->getElementsByTagName('sort') as $sort) {
                    foreach ($sort->getElementsByTagName('*') as $field) {
                        if($field->nodeName == "caracteristiques") 
                        {
                            foreach ($field->getElementsByTagName('*') as $caracteristique) {
                                if($caracteristique->nodeName == "ecole") 
                                {
                                    $sortSchool = $repositorySortSchool->findOneByName($caracteristique->nodeValue);
                                    if($sortSchool == NULL) {
                                        $sortSchoolAction = $this->container->get('pm_sort.sortschoolaction');
                                        $sortSchoolAction->registerSortSchool($caracteristique->nodeValue);
                                    } 
                                }
                                elseif($caracteristique->nodeName == "niveaux") 
                                {
                                    foreach ($caracteristique->getElementsByTagName('*') as $level) {
                                        if($level->nodeName == "domaine") 
                                        {
                                            $domain = $repositoryDomain->findOneByName($level->nodeValue);
                                            if($domain == NULL) {
                                                $domainAction = $this->container->get('pm_sort.domainaction');
                                                $domainAction->registerDomain($level->nodeValue);
                                            }
                                        }
                                    }
                                }
                                elseif($caracteristique->nodeName == "composantes") 
                                {
                                    foreach ($caracteristique->getElementsByTagName('*') as $composante) {
                                        if($composante->nodeName == "composante") 
                                        {
                                            $searchComposante = $repositoryComposante->findOneByName($composante->nodeValue);
                                            
                                            if($searchComposante == NULL) {
                                                $composanteAction = $this->container->get('pm_sort.composanteaction');
                                                $composanteAction->registerComposante($composante->nodeValue);
                                            } 
                                        }
                                    }
                                }
                            }
                        } 
                    }
                }
                //FIN ECRITURE DES DONNES ANNEXES
           
                //ECRITURE DES DONNES SORT :
                foreach ($domElement->getElementsByTagName('sort') as $sort) {
                    //Création de l'entité Oeuvre :
                    $entity_sort = new \PM\SortBundle\Entity\Sort;
                    $entity_sort->setCreateUser($this->getUser());

                    //Lecture des champs de Oeuvre :
                    foreach ($sort->getElementsByTagName('*') as $field) {
                        if($field->nodeName == "name") {$entity_sort->setName($field->nodeValue);}
                        elseif($field->nodeName == "description") {$entity_sort->setDescription($field->nodeValue);}
                        elseif($field->nodeName == "caracteristiques") 
                        {
                            foreach ($field->getElementsByTagName('*') as $caracteristique) {
                                if($caracteristique->nodeName == "tempsIncantation") {$entity_sort->setCastTime($caracteristique->nodeValue);}
                                elseif($caracteristique->nodeName == "portee") {$entity_sort->setScope($caracteristique->nodeValue);}
                                elseif($caracteristique->nodeName == "effet") {$entity_sort->setEffect($caracteristique->nodeValue);}
                                elseif($caracteristique->nodeName == "duree") {$entity_sort->setPeriod($caracteristique->nodeValue);}
                                elseif($caracteristique->nodeName == "jds") {$entity_sort->setJds($caracteristique->nodeValue);}
                                elseif($caracteristique->nodeName == "resistanceMagie") {$entity_sort->setMagicResistance($caracteristique->nodeValue);}
                                elseif($caracteristique->nodeName == "zoneEffet") {$entity_sort->setEffectzone($caracteristique->nodeValue);}
                                elseif($caracteristique->nodeName == "cible") {$entity_sort->setTarget($caracteristique->nodeValue);}
                                elseif($caracteristique->nodeName == "ecole") 
                                {
                                    $sortSchool = $repositorySortSchool->findOneByName($caracteristique->nodeValue);
                                    $entity_sort->setSortSchool($sortSchool);
                                    $entity_sort->setSortSchoolPlugged($caracteristique->getAttribute('plugged'));
                                    $entity_sort->setSortSchoolRegistre($caracteristique->getAttribute('registre'));
                                    
                                }
                                elseif($caracteristique->nodeName == "niveaux") 
                                {
                                    foreach ($caracteristique->getElementsByTagName('*') as $level) {
                                        if($level->nodeName == "classdnd") 
                                        {
                                            $classDnD = $repositoryClassDnD->findOneByName($level->nodeValue);
                                            $levelClass = $repositoryLevel->findOneByLevel($level->getAttribute('level'));
                                            
                                            $sortClass = new \PM\SortBundle\Entity\SortClassDnD();
                                            $sortClass->setClassdnd($classDnD);
                                            $sortClass->setMinimumLevel($levelClass);
                                            $sortClass->setSort($entity_sort);
                                            $sortClass->setCreateUser($this->getUser());
                                            $em->persist($sortClass);
                                        }
                                        elseif($level->nodeName == "domaine") 
                                        {
                                            $domain = $repositoryDomain->findOneByName($level->nodeValue);
                                            $levelClass = $repositoryLevel->findOneByLevel($level->getAttribute('level'));
                                            
                                            $sortDomain = new \PM\SortBundle\Entity\SortDomain();
                                            $sortDomain->setDomain($domain);
                                            $sortDomain->setMinimumLevel($levelClass);
                                            $sortDomain->setSort($entity_sort);
                                            $sortDomain->setCreateUser($this->getUser());
                                            $em->persist($sortDomain);
                                        }
                                    }
                                }
                                elseif($caracteristique->nodeName == "composantes") 
                                {
                                    foreach ($caracteristique->getElementsByTagName('*') as $composante) {
                                        if($composante->nodeName == "composante") 
                                        {
                                            $searchComposante = $repositoryComposante->findOneByName($composante->nodeValue);
                                            $entity_sort->addComposante($searchComposante);
                                        }
                                    }
                                }
                            }
                        } 
                    }
                    $em->persist($entity_sort);
                }
            }
        }
        $document->setTraitement(true);
        $em->persist($document);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('notice', 'Votre document a bien été traité.' );
        return $this->render('PMImportationBundle:Document:process.html.twig', array(
                                'document' => $document,
                            ));
    }
    
    public function deleteAction($id)
    {
        $repository = $this->getDoctrine()->getManager()
                           ->getRepository('PMImportationBundle:Document');
        $document = $repository->findOneById($id);
        
        if ($document === null) {
          throw $this->createNotFoundException('Document : [id='.$id.'] inexistant.');
        }
        
        $documentAction = $this->container->get('pm_importation.documentaction');
        $documentAction->deleteDocument($document);
             
        $this->get('session')->getFlashBag()->add('notice', 'Votre document a bien été supprimé.' );
        return $this->forward('PMImportationBundle:Document:list');
    }
}
