<?php

namespace App\EventSubscriber;

use App\Entity\Produit;
use App\Entity\Quartier;
use App\Entity\Zone;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();
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
    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof Produit ||
        $args->getObject() instanceof Zone ||
        $args->getObject() instanceof Quartier)
        {
            $args->getObject()->setGestionnaire($this->getGestionnaire());
            // dd($args->getObject());
        }
    }
}
