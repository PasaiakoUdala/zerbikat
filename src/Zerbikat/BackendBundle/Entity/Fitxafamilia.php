<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Fitxafamilia
 *
 * @ORM\Table(name="fitxa_familia_erlazioak")
 * @ORM\Entity(repositoryClass="Zerbikat\BackendBundle\Repository\FitxafamiliaRepository")
 * @ExclusionPolicy("all")
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Fitxafamilia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="ordena", type="integer", nullable=true)
     */
    private $ordena=0;

    /**************************************************************************************************************
     **************************************************************************************************************
     ******************      ERLAZIOAK
     **************************************************************************************************************
     *************************************************************************************************************/

    /**
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Familia", inversedBy="fitxafamilia")
     * @ORM\JoinColumn(name="familia_id", referencedColumnName="id", nullable=false, onDelete="cascade")
     * @OrderBy({"ordena" = "ASC"})
     */
    protected $familia;

    /**
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Fitxa", inversedBy="fitxafamilia")
     * @ORM\JoinColumn(name="fitxa_id", referencedColumnName="id", nullable=false, onDelete="cascade")
     */
    protected $fitxa;

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala")
     * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $udala;

    /**************************************************************************************************************
     **************************************************************************************************************
     ******************      ERLAZIOAK FIN
     **************************************************************************************************************
     *************************************************************************************************************/


    public function __toString ()
    {
        return (string) "";
    }

    /**
     * Constructor
     */
    public function __construct ()
    {

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
     * Set ordena
     *
     * @param integer $ordena
     *
     * @return Fitxafamilia
     */
    public function setOrdena($ordena)
    {
        $this->ordena = $ordena;

        return $this;
    }

    /**
     * Get ordena
     *
     * @return integer
     */
    public function getOrdena()
    {
        return $this->ordena;
    }

    /**
     * Set familia
     *
     * @param \Zerbikat\BackendBundle\Entity\Familia $familia
     *
     * @return Fitxafamilia
     */
    public function setFamilia(\Zerbikat\BackendBundle\Entity\Familia $familia)
    {
        $this->familia = $familia;

        return $this;
    }

    /**
     * Get familia
     *
     * @return \Zerbikat\BackendBundle\Entity\Familia
     */
    public function getFamilia()
    {
        return $this->familia;
    }

    /**
     * Set fitxa
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxa
     *
     * @return Fitxafamilia
     */
    public function setFitxa(\Zerbikat\BackendBundle\Entity\Fitxa $fitxa)
    {
        $this->fitxa = $fitxa;

        return $this;
    }

    /**
     * Get fitxa
     *
     * @return \Zerbikat\BackendBundle\Entity\Fitxa
     */
    public function getFitxa()
    {
        return $this->fitxa;
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     *
     * @return Fitxafamilia
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
