<?php

namespace CAS\UserBundle\Service;

use Doctrine\ORM\EntityManager;

class remove
{
    protected $em;
    protected $userManager;

    public function __construct(EntityManager $EntityManager, $userManager)
    {
        $this->em = $EntityManager;
        $this->userManager = $userManager;
    }

    public function remove($user)
    {
        foreach($this->em->getRepository('CASUserBundle:Log')->findBy(array('user' => $user)) as $item) {$item->setUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('CASUserBundle:Favorite')->findBy(array('user' => $user)) as $item) {$this->em->remove($item);}
        foreach($this->em->getRepository('CASUserBundle:UserPreferences')->findBy(array('user' => $user)) as $item) {$this->em->remove($item);}
        foreach($this->em->getRepository('CLICHESPersonalPlaceBundle:PrivatePlayer')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('CLICHESPersonalPlaceBundle:PrivatePlayer')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('CLICHESPersonalPlaceBundle:PrivatePlayerSession')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('CLICHESPersonalPlaceBundle:PrivatePlayerSession')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('CLICHESPlayerBundle:PlayerSession')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('CLICHESPlayerBundle:PlayerSession')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('CLICHESPlayerBundle:PlayerSuggest')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Artwork')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Artwork')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Building')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Building')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Entity')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Entity')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Pad')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Pad')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:SameAs')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:SameAs')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:SemanticEnrichment')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:SemanticEnrichment')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Source')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:Source')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:SourceClick')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:SujetAsIconography')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:SujetAsIconography')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:TimeEntity')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:TimeEntity')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:UnrelevantField')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADataBundle:UnrelevantField')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADuplicateBundle:Unmatch')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATADuplicateBundle:Unmatch')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATAImageBundle:Image')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATAImageBundle:Image')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATAImageBundle:View')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATAImageBundle:View')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATAImportBundle:EntityImportSession')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATAImportBundle:EntityImportSession')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATAPublicBundle:Reporting')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATAPublicBundle:Visit')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATASearchBundle:SearchLog')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATATeachingBundle:Teaching')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATATeachingBundle:Teaching')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATATeachingBundle:TeachingTest')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATATeachingBundle:TeachingTest')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATATeachingBundle:TeachingTestVote')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATATeachingBundle:TeachingTestVote')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATATeachingBundle:University')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('DATATeachingBundle:University')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TBModelBundle:TestedGame')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TBModelBundle:TestedGame')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TBModelBundle:TestedItem')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TBModelBundle:TestedItem')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TBModelBundle:TestedItemResult')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TBModelBundle:TestedItemResult')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TBModelBundle:TestedSession')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TBModelBundle:TestedSession')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TOOLSNerBundle:NameEntityRecognition')->findBy(array('createUser' => $user)) as $item) {$item->setCreateUser(null); $this->em->persist($item);}
        foreach($this->em->getRepository('TOOLSNerBundle:NameEntityRecognition')->findBy(array('updateUser' => $user)) as $item) {$item->setUpdateUser(null); $this->em->persist($item);}

        $this->userManager->deleteUser($user);
        $this->em->flush();
    }
}
