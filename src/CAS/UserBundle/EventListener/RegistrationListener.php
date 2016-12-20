<?php
namespace CAS\UserBundle\EventListener;

use CAS\UserBundle\Entity\UserPreferences;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\ORM\EntityManager;

class RegistrationListener implements EventSubscriberInterface
{
    protected $em;

    public function __construct(EntityManager $EntityManager)
    {
        $this->em = $EntityManager;
    }

    public static function getSubscribedEvents()
    {
        return [ FOSUserEvents::REGISTRATION_CONFIRMED => 'onRegistrationConfirm' ];
    }

    public function onRegistrationConfirm( UserEvent $event )
    {

    }
}