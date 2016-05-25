<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Familia
 *
 * @ORM\Table(name="familia")
 * @ORM\Entity
 */
class Familia
{
    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;

    /**
     * @var string
     *
     * @ORM\Column(name="familiaeu", type="string", length=255, nullable=true)
     */
    private $familiaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="familiaes", type="string", length=255, nullable=true)
     */
    private $familiaes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set familiaeu
     *
     * @param string $familiaeu
     * @return Familia
     */
    public function setFamiliaeu($familiaeu)
    {
        $this->familiaeu = $familiaeu;

        return $this;
    }

    /**
     * Get familiaeu
     *
     * @return string 
     */
    public function getFamiliaeu()
    {
        return $this->familiaeu;
    }

    /**
     * Set familiaes
     *
     * @param string $familiaes
     * @return Familia
     */
    public function setFamiliaes($familiaes)
    {
        $this->familiaes = $familiaes;

        return $this;
    }

    /**
     * Get familiaes
     *
     * @return string 
     */
    public function getFamiliaes()
    {
        return $this->familiaes;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     * @return Familia
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
}
