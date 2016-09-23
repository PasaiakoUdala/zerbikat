<?php
// src/Zerbikat/BackendBundle/Entity/User.php

namespace Zerbikat\BackendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *          ERLAZIOAK
     */

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala")
     * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="SET NULL")
     *
     */
    private $udala;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Azpisaila
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Azpisaila")
     * @ORM\JoinColumn(name="azpisaila_id", referencedColumnName="id",onDelete="SET NULL")
     *
     */
    private $azpisaila;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected $password;









    /**
     *      FUNTZIOAK
     */

    /**
     *      Constructor.
     */
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
