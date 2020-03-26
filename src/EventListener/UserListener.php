<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use App\Entity\User;
use App\Controller\UserController;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\DataFixtures\UserFixtures;
use App\Security\LoginFormAuthentificatorAuthenticator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentToken;
use Doctrine\ORM\Cache\Persister;
class UserListener
{
    private $encoder;


    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if ($entity instanceof User) {
            if (strlen($entity->getPlainPassword())>0) {
                $entity->setPassword($this->encoder->load($entity,$entity->getPlainPassword()));
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args) {
        return $this->prePersist($args);
    }
}