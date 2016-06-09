<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Baldintza
 *
 * @ORM\Table(name="baldintza")
 * @ORM\Entity
 */
class Baldintza
{
    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;
    
    /**
     * @var string
     *
     * @ORM\Column(name="baldintzaeu", type="string", length=255, nullable=true)
     */
    private $baldintzaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="baldintzaes", type="string", length=255, nullable=true)
     */
    private $baldintzaes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    public function __toString()
    {
        return $this->getBaldintzaeu();
    }



    /**
     * Set baldintzaeu
     *
     * @param string $baldintzaeu
     * @return Baldintza
     */
    public function setBaldintzaeu($baldintzaeu)
    {
        $this->baldintzaeu = $baldintzaeu;

        return $this;
    }

    /**
     * Get baldintzaeu
     *
     * @return string 
     */
    public function getBaldintzaeu()
    {
        return $this->baldintzaeu;
    }

    /**
     * Set baldintzaes
     *
     * @param string $baldintzaes
     * @return Baldintza
     */
    public function setBaldintzaes($baldintzaes)
    {
        $this->baldintzaes = $baldintzaes;

        return $this;
    }

    /**
     * Get baldintzaes
     *
     * @return string 
     */
    public function getBaldintzaes()
    {
        return $this->baldintzaes;
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
     * @return Baldintza
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
