<?php
// src/Zerbikat/BackendBundle/Entity/User.php

namespace Zerbikat\BackendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="fos_user",
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"username_canonical", "udala_id"})}
 * )
 * @UdalaEgiaztatu(userFieldName="udala_id")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="usernameCanonical", column=@ORM\Column(type="string", name="username_canonical", length=255, unique=false, nullable=true))
 * })
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
     * @var Azpisaila
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
     * @param Udala $udala
     *
     * @return User
     */
    public function setUdala( Udala $udala = null)
    {
        $this->udala = $udala;

        return $this;
    }

    /**
     * Get udala
     *
     * @return Udala
     */
    public function getUdala()
    {
        return $this->udala;
    }

    /**
     * Set azpisaila
     *
     * @param Azpisaila $azpisaila
     *
     * @return User
     */
    public function setAzpisaila( Azpisaila $azpisaila = null)
    {
        $this->azpisaila = $azpisaila;

        return $this;
    }

    /**
     * Get azpisaila
     *
     * @return Azpisaila
     */
    public function getAzpisaila()
    {
        return $this->azpisaila;
    }



}
