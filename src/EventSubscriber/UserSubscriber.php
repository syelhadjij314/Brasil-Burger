<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\Zone;
use App\Entity\Taille;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Quartier;
use Doctrine\ORM\Events;
use App\Services\MailerService;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    // private MailerService $mailerService;
    public function __construct(TokenStorageInterface $tokenStorage,mailerService $mailerService)
    {
        $this->token = $tokenStorage->getToken();
        $this->mailerService=$mailerService;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }
    private function getGestionnaire()
    {
        //dd($this->token);
        if (null === $token = $this->token) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }
        return $user;
    }
    private function getClient()
    {
        //dd($this->token);
        if (null === $token = $this->token) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }
        return $user;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof Produit ||
        $args->getObject() instanceof Zone ||
        $args->getObject() instanceof Quartier ||
        $args->getObject() instanceof Taille)
        {
            $args->getObject()->setGestionnaire($this->getGestionnaire());
            // dd($args->getObject());
        }
        if ($args->getObject() instanceof Commande) {
            $args->getObject()->setClient($this->getClient());
            // $this->mailerService->send("Confirmation de Commande",$args->getObject()->setClient($this->getClient())->getClient()->getLogin());
            
        }
    }
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }
        $data['id'] = $user->getId();
        $event->setData($data);
        // dd($event);
    }
}
