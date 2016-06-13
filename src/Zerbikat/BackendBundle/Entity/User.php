<?php
// src/Zerbikat/BackendBundle/Entity/User.php

namespace Zerbikat\BackendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;

//    /**
//     * @var string
//     * @Expose
//     * @ORM\Column(name="espedientekodea", type="string", length=9, nullable=true)
//     */
//    private $espedientekodea;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Azpisaila
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Azpisaila")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="azpisaila_id", referencedColumnName="id")
     * })
     */
    private $azpisaila;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     *
     * @return User
     */
    public function setUdala(\Zerbikat\BackendBundle\Entity\Udala $udala = null)
    {
        $this->udala = $udala;

        return $this;
    }

    /**
     * Get udala
     *
     * @return \Zerbikat\BackendBundle\Entity\Udala
     */
    public function getUdala()
    {
        return $this->udala;
    }

    /**
     * Set azpisaila
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpisaila $azpisaila
     *
     * @return User
     */
    public function setAzpisaila(\Zerbikat\BackendBundle\Entity\Azpisaila $azpisaila = null)
    {
        $this->azpisaila = $azpisaila;

        return $this;
    }

    /**
     * Get azpisaila
     *
     * @return \Zerbikat\BackendBundle\Entity\Azpisaila
     */
    public function getAzpisaila()
    {
        return $this->azpisaila;
    }
}
