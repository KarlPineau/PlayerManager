<?php

namespace HDA\ClichesBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use HDA\ClichesBundle\Entity\Oeuvre;


class documentAction 
{
    protected $em;
    protected $security;

    public function __construct(EntityManager $EntityManager, SecurityContext $security_context)
    {
        $this->em = $EntityManager;
        $this->security = $security_context;
    }
    
    public function deleteDocument($document)
    {   
        $this->em->remove($document);
        $this->em->flush();
    }
    
    /*public function operationFile($document, $current_user)
    {
        $dom = new Crawler($document);
        
        $listeOeuvres = $dom->filter('OEUVRES')->children();//getElementsByTagName("OEUVRE");
        foreach($listeOeuvres as $oeuvre)
        {
            $entity_oeuvre = new Oeuvre;
            $entity_oeuvre->setCreateUser($current_user);
            
            $fields = $oeuvre->filter('OEUVRE')->children();//getElementsByTagName('*');
            foreach ($fields as $field) {
                if($field->nodeName == "NomImg") {$entity_oeuvre->setNomImg($field->nodeValue);}
                elseif($field->nodeName == "AUTEUR") {$entity_oeuvre->setAuteur($field->nodeValue);}
                elseif($field->nodeName == "SUJET") {$entity_oeuvre->setSujet($field->nodeValue);}
                elseif($field->nodeName == "SUJET_ICONO") {$entity_oeuvre->setSujetIcono($field->nodeValue);}
                elseif($field->nodeName == "EDIFICE") {$entity_oeuvre->setEdifice($field->nodeValue);}
                elseif($field->nodeName == "VUE") {$entity_oeuvre->setVue($field->nodeValue);}
                elseif($field->nodeName == "DATATION") {$entity_oeuvre->setDatation($field->nodeValue);}
                elseif($field->nodeName == "PROVENANCE") {$entity_oeuvre->setProvenance($field->nodeValue);}
                elseif($field->nodeName == "LIEU_DE_CONSERVATION") {$entity_oeuvre->setLieuDeConservation($field->nodeValue);}
                elseif($field->nodeName == "EXTENSION") {$entity_oeuvre->setExtension($field->nodeValue);}
                elseif($field->nodeName == "DIMENSIONS") {$entity_oeuvre->setDimensions($field->nodeValue);}
                elseif($field->nodeName == "MATTECH") {$entity_oeuvre->setMattech($field->nodeValue);}
                elseif($field->nodeName == "ANNEE_ECOLE") {$entity_oeuvre->setEcoleAnnee($field->nodeValue);}
                elseif($field->nodeName == "MATIERE_ECOLE") {$entity_oeuvre->setEcoleMatiere($field->nodeValue);}
                elseif($field->nodeName == "STYLE") {$entity_oeuvre->setStyle($field->nodeValue);}
                elseif($field->nodeName == "COPYRIGHT") {$entity_oeuvre->setCopyright($field->nodeValue);}
            }
            $this->em->persist($oeuvre);
        }
        
        $this->em->flush();
    }*/
}
