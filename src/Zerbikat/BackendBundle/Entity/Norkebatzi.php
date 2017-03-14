<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Norkebatzi
 *
 * @ORM\Table(name="norkebatzi")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Norkebatzi
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="norkeu", type="string", length=255, nullable=true)
     */
    private $norkeu;

    /**
     * @var string
     *
     * @ORM\Column(name="norkes", type="string", length=255, nullable=true)
     */
    private $norkes;



    /**
     *          ERLAZIOAK
     */

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala")
     * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $udala;

    /**
     *          TOSTRING
     */
    public function __toString()
    {
        return (string) $this->getNorkeu();
    }

    /**
     * Set norkeu
     *
     * @param string $norkeu
     * @return Norkebatzi
     */
    public function setNorkeu($norkeu)
    {
        $this->norkeu = $norkeu;

        return $this;
    }

    /**
     * Get norkeu
     *
     * @return string 
     */
    public function getNorkeu()
    {
        return $this->norkeu;
    }

    /**
     * Set norkes
     *
     * @param string $norkes
     * @return Norkebatzi
     */
    public function setNorkes($norkes)
    {
        $this->norkes = $norkes;

        return $this;
    }

    /**
     * Get norkes
     *
     * @return string 
     */
    public function getNorkes()
    {
        return $this->norkes;
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
     * @return Norkebatzi
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
