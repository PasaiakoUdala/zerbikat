<?php

namespace Zerbikat\BackendBundle\Filter;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Annotations\Reader;

class Configurator
{
    protected $em;
    protected $tokenStorage;
    protected $reader;

    public function __construct(ObjectManager $em, TokenStorageInterface $tokenStorage, Reader $reader)
    {
        $this->em              = $em;
        $this->tokenStorage    = $tokenStorage;
        $this->reader          = $reader;
    }

    public function onKernelRequest()
    {
        if ($user = $this->getUser()) {
            $filter = $this->em->getFilters()->enable('udala_filter');
            if ($user->getudala()) {
                $filter->setParameter('udala_id', $user->getudala()->getId());
                $filter->setAnnotationReader($this->reader);
            } else
            {
                return '' ;
            }
        }
    }

    private function getUser()
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return null;
        }

        $user = $token->getUser();

        if (!($user instanceof UserInterface)) {
            return null;
        }

        return $user;
    }
}