<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fitxa
 *
 * @ORM\Table(name="fitxa", indexes={@ORM\Index(name="aurreikusi_id_idx", columns={"aurreikusi_id"}), @ORM\Index(name="arrunta_id_idx", columns={"arrunta_id"}), @ORM\Index(name="norkebatzi_id_idx", columns={"norkebatzi_id"}), @ORM\Index(name="azpisaila_id_idx", columns={"azpisaila_id"}), @ORM\Index(name="datuenbabesa_id_idx", columns={"datuenbabesa_id"}), @ORM\Index(name="zerbitzua_id_idx", columns={"zerbitzua_id"})})
 * @ORM\Entity
 */
class Fitxa
{
    /** @ORM\ManyToOne(targetEntity="Udala") */
    private $udala;

    /**
     * @var string
     *
     * @ORM\Column(name="espedientekodea", type="string", length=9, nullable=true)
     */
    private $espedientekodea;

    /**
     * @var string
     *
     * @ORM\Column(name="deskribapenaeu", type="string", length=255, nullable=true)
     */
    private $deskribapenaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="deskribapenaes", type="string", length=255, nullable=true)
     */
    private $deskribapenaes;

    /**
     * @var string
     *
     * @ORM\Column(name="helburuaeu", type="text", length=65535, nullable=true)
     */
    private $helburuaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="helburuaes", type="text", length=65535, nullable=true)
     */
    private $helburuaes;

    /**
     * @var string
     *
     * @ORM\Column(name="norkeu", type="text", length=65535, nullable=true)
     */
    private $norkeu;

    /**
     * @var string
     *
     * @ORM\Column(name="norkes", type="text", length=65535, nullable=true)
     */
    private $norkes;

    /**
     * @var string
     *
     * @ORM\Column(name="dokumentazioaeu", type="text", length=65535, nullable=true)
     */
    private $dokumentazioaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="dokumentazioaes", type="text", length=65535, nullable=true)
     */
    private $dokumentazioaes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nolabertan", type="boolean", nullable=true)
     */
    private $nolabertan;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nolainternet", type="boolean", nullable=true)
     */
    private $nolainternet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nolatelefono", type="boolean", nullable=true)
     */
    private $nolatelefono;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nolapostela", type="boolean", nullable=true)
     */
    private $nolapostela;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nolaposta", type="boolean", nullable=true)
     */
    private $nolaposta;

    /**
     * @var string
     *
     * @ORM\Column(name="nolabesteakeu", type="string", length=255, nullable=true)
     */
    private $nolabesteakeu;

    /**
     * @var string
     *
     * @ORM\Column(name="nolabesteakes", type="string", length=255, nullable=true)
     */
    private $nolabesteakes;

    /**
     * @var string
     *
     * @ORM\Column(name="kostuaeu", type="text", length=65535, nullable=true)
     */
    private $kostuaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="kostuaes", type="text", length=65535, nullable=true)
     */
    private $kostuaes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ebazpensinpli", type="boolean", nullable=true)
     */
    private $ebazpensinpli;

    /**
     * @var boolean
     *
     * @ORM\Column(name="arduraaitorpena", type="boolean", nullable=true)
     */
    private $arduraaitorpena;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isiltasunadmin", type="boolean", nullable=true)
     */
    private $isiltasunadmin;

    /**
     * @var string
     *
     * @ORM\Column(name="araudiaeu", type="text", length=65535, nullable=true)
     */
    private $araudiaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="araudiaes", type="text", length=65535, nullable=true)
     */
    private $araudiaes;

    /**
     * @var string
     *
     * @ORM\Column(name="prozeduraeu", type="text", length=65535, nullable=true)
     */
    private $prozeduraeu;

    /**
     * @var string
     *
     * @ORM\Column(name="prozeduraes", type="text", length=65535, nullable=true)
     */
    private $prozeduraes;

    /**
     * @var string
     *
     * @ORM\Column(name="tramiteakeu", type="text", length=65535, nullable=true)
     */
    private $tramiteakeu;

    /**
     * @var string
     *
     * @ORM\Column(name="tramiteakes", type="text", length=65535, nullable=true)
     */
    private $tramiteakes;

    /**
     * @var string
     *
     * @ORM\Column(name="doklaguneu", type="text", length=65535, nullable=true)
     */
    private $doklaguneu;

    /**
     * @var string
     *
     * @ORM\Column(name="doklagunes", type="text", length=65535, nullable=true)
     */
    private $doklagunes;

    /**
     * @var string
     *
     * @ORM\Column(name="oharrakeu", type="text", length=65535, nullable=true)
     */
    private $oharrakeu;

    /**
     * @var string
     *
     * @ORM\Column(name="oharrakes", type="text", length=65535, nullable=true)
     */
    private $oharrakes;


    /**
     * @var boolean
     *
     * @ORM\Column(name="publikoa", type="boolean", nullable=true)
     */
    private $publikoa;

    /**
     * @var integer
     *
     * @ORM\Column(name="kontsultak", type="bigint", nullable=true)
     */
    private $kontsultak;

    /**
     * @var string
     *
     * @ORM\Column(name="parametroa", type="string", length=50, nullable=true)
     */
    private $parametroa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Norkebatzi
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Norkebatzi")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="norkebatzi_id", referencedColumnName="id")
     * })
     */
    private $norkebatzi;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Zerbitzua
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Zerbitzua")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="zerbitzua_id", referencedColumnName="id")
     * })
     */
    private $zerbitzua;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Datuenbabesa
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Datuenbabesa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="datuenbabesa_id", referencedColumnName="id")
     * })
     */
    private $datuenbabesa;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Azpisaila
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Azpisaila")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="azpisaila_id", referencedColumnName="id")
     * })
     */
    private $azpisaila;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Aurreikusi
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Aurreikusi")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aurreikusi_id", referencedColumnName="id")
     * })
     */
    private $aurreikusi;

    /**
     * @var \Zerbikat\BackendBundle\Entity\Arrunta
     *
     * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Arrunta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arrunta_id", referencedColumnName="id")
     * })
     */
    private $arrunta;

    /**
     * @var string
     *
     * @ORM\Column(name="besteak1eu", type="text", length=65535, nullable=true)
     */
    private $besteak1eu;

    /**
     * @var string
     *
     * @ORM\Column(name="besteak1es", type="text", length=65535, nullable=true)
     */
    private $besteak1es;
    /**
     * @var string
     *
     * @ORM\Column(name="besteak2eu", type="text", length=65535, nullable=true)
     */
    private $bestea2keu;

    /**
     * @var string
     *
     * @ORM\Column(name="besteak2es", type="text", length=65535, nullable=true)
     */
    private $besteak2es;
    /**
     * @var string
     *
     * @ORM\Column(name="besteak3eu", type="text", length=65535, nullable=true)
     */
    private $besteak3eu;
    /**
     * @var string
     *
     * @ORM\Column(name="besteak3es", type="text", length=65535, nullable=true)
     */
    private $besteak3es;
      


    /**
     * Set espedientekodea
     *
     * @param string $espedientekodea
     * @return Fitxa
     */
    public function setEspedientekodea($espedientekodea)
    {
        $this->espedientekodea = $espedientekodea;

        return $this;
    }

    /**
     * Get espedientekodea
     *
     * @return string 
     */
    public function getEspedientekodea()
    {
        return $this->espedientekodea;
    }

    /**
     * Set deskribapenaeu
     *
     * @param string $deskribapenaeu
     * @return Fitxa
     */
    public function setDeskribapenaeu($deskribapenaeu)
    {
        $this->deskribapenaeu = $deskribapenaeu;

        return $this;
    }

    /**
     * Get deskribapenaeu
     *
     * @return string 
     */
    public function getDeskribapenaeu()
    {
        return $this->deskribapenaeu;
    }

    /**
     * Set deskribapenaes
     *
     * @param string $deskribapenaes
     * @return Fitxa
     */
    public function setDeskribapenaes($deskribapenaes)
    {
        $this->deskribapenaes = $deskribapenaes;

        return $this;
    }

    /**
     * Get deskribapenaes
     *
     * @return string 
     */
    public function getDeskribapenaes()
    {
        return $this->deskribapenaes;
    }

    /**
     * Set helburuaeu
     *
     * @param string $helburuaeu
     * @return Fitxa
     */
    public function setHelburuaeu($helburuaeu)
    {
        $this->helburuaeu = $helburuaeu;

        return $this;
    }

    /**
     * Get helburuaeu
     *
     * @return string 
     */
    public function getHelburuaeu()
    {
        return $this->helburuaeu;
    }

    /**
     * Set helburuaes
     *
     * @param string $helburuaes
     * @return Fitxa
     */
    public function setHelburuaes($helburuaes)
    {
        $this->helburuaes = $helburuaes;

        return $this;
    }

    /**
     * Get helburuaes
     *
     * @return string 
     */
    public function getHelburuaes()
    {
        return $this->helburuaes;
    }

    /**
     * Set norkeu
     *
     * @param string $norkeu
     * @return Fitxa
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
     * @return Fitxa
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
     * Set dokumentazioaeu
     *
     * @param string $dokumentazioaeu
     * @return Fitxa
     */
    public function setDokumentazioaeu($dokumentazioaeu)
    {
        $this->dokumentazioaeu = $dokumentazioaeu;

        return $this;
    }

    /**
     * Get dokumentazioaeu
     *
     * @return string 
     */
    public function getDokumentazioaeu()
    {
        return $this->dokumentazioaeu;
    }

    /**
     * Set dokumentazioaes
     *
     * @param string $dokumentazioaes
     * @return Fitxa
     */
    public function setDokumentazioaes($dokumentazioaes)
    {
        $this->dokumentazioaes = $dokumentazioaes;

        return $this;
    }

    /**
     * Get dokumentazioaes
     *
     * @return string 
     */
    public function getDokumentazioaes()
    {
        return $this->dokumentazioaes;
    }

    /**
     * Set nolabertan
     *
     * @param boolean $nolabertan
     * @return Fitxa
     */
    public function setNolabertan($nolabertan)
    {
        $this->nolabertan = $nolabertan;

        return $this;
    }

    /**
     * Get nolabertan
     *
     * @return boolean 
     */
    public function getNolabertan()
    {
        return $this->nolabertan;
    }

    /**
     * Set nolainternet
     *
     * @param boolean $nolainternet
     * @return Fitxa
     */
    public function setNolainternet($nolainternet)
    {
        $this->nolainternet = $nolainternet;

        return $this;
    }

    /**
     * Get nolainternet
     *
     * @return boolean 
     */
    public function getNolainternet()
    {
        return $this->nolainternet;
    }

    /**
     * Set nolatelefono
     *
     * @param boolean $nolatelefono
     * @return Fitxa
     */
    public function setNolatelefono($nolatelefono)
    {
        $this->nolatelefono = $nolatelefono;

        return $this;
    }

    /**
     * Get nolatelefono
     *
     * @return boolean 
     */
    public function getNolatelefono()
    {
        return $this->nolatelefono;
    }

    /**
     * Set nolapostela
     *
     * @param boolean $nolapostela
     * @return Fitxa
     */
    public function setNolapostela($nolapostela)
    {
        $this->nolapostela = $nolapostela;

        return $this;
    }

    /**
     * Get nolapostela
     *
     * @return boolean 
     */
    public function getNolapostela()
    {
        return $this->nolapostela;
    }

    /**
     * Set nolaposta
     *
     * @param boolean $nolaposta
     * @return Fitxa
     */
    public function setNolaposta($nolaposta)
    {
        $this->nolaposta = $nolaposta;

        return $this;
    }

    /**
     * Get nolaposta
     *
     * @return boolean 
     */
    public function getNolaposta()
    {
        return $this->nolaposta;
    }

    /**
     * Set nolabesteakeu
     *
     * @param string $nolabesteakeu
     * @return Fitxa
     */
    public function setNolabesteakeu($nolabesteakeu)
    {
        $this->nolabesteakeu = $nolabesteakeu;

        return $this;
    }

    /**
     * Get nolabesteakeu
     *
     * @return string 
     */
    public function getNolabesteakeu()
    {
        return $this->nolabesteakeu;
    }

    /**
     * Set nolabesteakes
     *
     * @param string $nolabesteakes
     * @return Fitxa
     */
    public function setNolabesteakes($nolabesteakes)
    {
        $this->nolabesteakes = $nolabesteakes;

        return $this;
    }

    /**
     * Get nolabesteakes
     *
     * @return string 
     */
    public function getNolabesteakes()
    {
        return $this->nolabesteakes;
    }

    /**
     * Set kostuaeu
     *
     * @param string $kostuaeu
     * @return Fitxa
     */
    public function setKostuaeu($kostuaeu)
    {
        $this->kostuaeu = $kostuaeu;

        return $this;
    }

    /**
     * Get kostuaeu
     *
     * @return string 
     */
    public function getKostuaeu()
    {
        return $this->kostuaeu;
    }

    /**
     * Set kostuaes
     *
     * @param string $kostuaes
     * @return Fitxa
     */
    public function setKostuaes($kostuaes)
    {
        $this->kostuaes = $kostuaes;

        return $this;
    }

    /**
     * Get kostuaes
     *
     * @return string 
     */
    public function getKostuaes()
    {
        return $this->kostuaes;
    }

    /**
     * Set ebazpensinpli
     *
     * @param boolean $ebazpensinpli
     * @return Fitxa
     */
    public function setEbazpensinpli($ebazpensinpli)
    {
        $this->ebazpensinpli = $ebazpensinpli;

        return $this;
    }

    /**
     * Get ebazpensinpli
     *
     * @return boolean 
     */
    public function getEbazpensinpli()
    {
        return $this->ebazpensinpli;
    }

    /**
     * Set arduraaitorpena
     *
     * @param boolean $arduraaitorpena
     * @return Fitxa
     */
    public function setArduraaitorpena($arduraaitorpena)
    {
        $this->arduraaitorpena = $arduraaitorpena;

        return $this;
    }

    /**
     * Get arduraaitorpena
     *
     * @return boolean 
     */
    public function getArduraaitorpena()
    {
        return $this->arduraaitorpena;
    }

    /**
     * Set isiltasunadmin
     *
     * @param boolean $isiltasunadmin
     * @return Fitxa
     */
    public function setIsiltasunadmin($isiltasunadmin)
    {
        $this->isiltasunadmin = $isiltasunadmin;

        return $this;
    }

    /**
     * Get isiltasunadmin
     *
     * @return boolean 
     */
    public function getIsiltasunadmin()
    {
        return $this->isiltasunadmin;
    }

    /**
     * Set araudiaeu
     *
     * @param string $araudiaeu
     * @return Fitxa
     */
    public function setAraudiaeu($araudiaeu)
    {
        $this->araudiaeu = $araudiaeu;

        return $this;
    }

    /**
     * Get araudiaeu
     *
     * @return string 
     */
    public function getAraudiaeu()
    {
        return $this->araudiaeu;
    }

    /**
     * Set araudiaes
     *
     * @param string $araudiaes
     * @return Fitxa
     */
    public function setAraudiaes($araudiaes)
    {
        $this->araudiaes = $araudiaes;

        return $this;
    }

    /**
     * Get araudiaes
     *
     * @return string 
     */
    public function getAraudiaes()
    {
        return $this->araudiaes;
    }

    /**
     * Set prozeduraeu
     *
     * @param string $prozeduraeu
     * @return Fitxa
     */
    public function setProzeduraeu($prozeduraeu)
    {
        $this->prozeduraeu = $prozeduraeu;

        return $this;
    }

    /**
     * Get prozeduraeu
     *
     * @return string 
     */
    public function getProzeduraeu()
    {
        return $this->prozeduraeu;
    }

    /**
     * Set prozeduraes
     *
     * @param string $prozeduraes
     * @return Fitxa
     */
    public function setProzeduraes($prozeduraes)
    {
        $this->prozeduraes = $prozeduraes;

        return $this;
    }

    /**
     * Get prozeduraes
     *
     * @return string 
     */
    public function getProzeduraes()
    {
        return $this->prozeduraes;
    }

    /**
     * Set tramiteakeu
     *
     * @param string $tramiteakeu
     * @return Fitxa
     */
    public function setTramiteakeu($tramiteakeu)
    {
        $this->tramiteakeu = $tramiteakeu;

        return $this;
    }

    /**
     * Get tramiteakeu
     *
     * @return string 
     */
    public function getTramiteakeu()
    {
        return $this->tramiteakeu;
    }

    /**
     * Set tramiteakes
     *
     * @param string $tramiteakes
     * @return Fitxa
     */
    public function setTramiteakes($tramiteakes)
    {
        $this->tramiteakes = $tramiteakes;

        return $this;
    }

    /**
     * Get tramiteakes
     *
     * @return string 
     */
    public function getTramiteakes()
    {
        return $this->tramiteakes;
    }

    /**
     * Set doklaguneu
     *
     * @param string $doklaguneu
     * @return Fitxa
     */
    public function setDoklaguneu($doklaguneu)
    {
        $this->doklaguneu = $doklaguneu;

        return $this;
    }

    /**
     * Get doklaguneu
     *
     * @return string 
     */
    public function getDoklaguneu()
    {
        return $this->doklaguneu;
    }

    /**
     * Set doklagunes
     *
     * @param string $doklagunes
     * @return Fitxa
     */
    public function setDoklagunes($doklagunes)
    {
        $this->doklagunes = $doklagunes;

        return $this;
    }

    /**
     * Get doklagunes
     *
     * @return string 
     */
    public function getDoklagunes()
    {
        return $this->doklagunes;
    }

    /**
     * Set oharrakeu
     *
     * @param string $oharrakeu
     * @return Fitxa
     */
    public function setOharrakeu($oharrakeu)
    {
        $this->oharrakeu = $oharrakeu;

        return $this;
    }

    /**
     * Get oharrakeu
     *
     * @return string 
     */
    public function getOharrakeu()
    {
        return $this->oharrakeu;
    }

    /**
     * Set oharrakes
     *
     * @param string $oharrakes
     * @return Fitxa
     */
    public function setOharrakes($oharrakes)
    {
        $this->oharrakes = $oharrakes;

        return $this;
    }

    /**
     * Get oharrakes
     *
     * @return string 
     */
    public function getOharrakes()
    {
        return $this->oharrakes;
    }

    /**
     * Set besteakeu
     *
     * @param string $besteakeu
     * @return Fitxa
     */
    public function setBesteakeu($besteakeu)
    {
        $this->besteakeu = $besteakeu;

        return $this;
    }

    /**
     * Get besteakeu
     *
     * @return string 
     */
    public function getBesteakeu()
    {
        return $this->besteakeu;
    }

    /**
     * Set besteakes
     *
     * @param string $besteakes
     * @return Fitxa
     */
    public function setBesteakes($besteakes)
    {
        $this->besteakes = $besteakes;

        return $this;
    }

    /**
     * Get besteakes
     *
     * @return string 
     */
    public function getBesteakes()
    {
        return $this->besteakes;
    }

    /**
     * Set publikoa
     *
     * @param boolean $publikoa
     * @return Fitxa
     */
    public function setPublikoa($publikoa)
    {
        $this->publikoa = $publikoa;

        return $this;
    }

    /**
     * Get publikoa
     *
     * @return boolean 
     */
    public function getPublikoa()
    {
        return $this->publikoa;
    }

    /**
     * Set kontsultak
     *
     * @param integer $kontsultak
     * @return Fitxa
     */
    public function setKontsultak($kontsultak)
    {
        $this->kontsultak = $kontsultak;

        return $this;
    }

    /**
     * Get kontsultak
     *
     * @return integer 
     */
    public function getKontsultak()
    {
        return $this->kontsultak;
    }

    /**
     * Set parametroa
     *
     * @param string $parametroa
     * @return Fitxa
     */
    public function setParametroa($parametroa)
    {
        $this->parametroa = $parametroa;

        return $this;
    }

    /**
     * Get parametroa
     *
     * @return string 
     */
    public function getParametroa()
    {
        return $this->parametroa;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Fitxa
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Fitxa
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * Set norkebatzi
     *
     * @param \Zerbikat\BackendBundle\Entity\Norkebatzi $norkebatzi
     * @return Fitxa
     */
    public function setNorkebatzi(\Zerbikat\BackendBundle\Entity\Norkebatzi $norkebatzi = null)
    {
        $this->norkebatzi = $norkebatzi;

        return $this;
    }

    /**
     * Get norkebatzi
     *
     * @return \Zerbikat\BackendBundle\Entity\Norkebatzi 
     */
    public function getNorkebatzi()
    {
        return $this->norkebatzi;
    }

    /**
     * Set zerbitzua
     *
     * @param \Zerbikat\BackendBundle\Entity\Zerbitzua $zerbitzua
     * @return Fitxa
     */
    public function setZerbitzua(\Zerbikat\BackendBundle\Entity\Zerbitzua $zerbitzua = null)
    {
        $this->zerbitzua = $zerbitzua;

        return $this;
    }

    /**
     * Get zerbitzua
     *
     * @return \Zerbikat\BackendBundle\Entity\Zerbitzua 
     */
    public function getZerbitzua()
    {
        return $this->zerbitzua;
    }

    /**
     * Set datuenbabesa
     *
     * @param \Zerbikat\BackendBundle\Entity\Datuenbabesa $datuenbabesa
     * @return Fitxa
     */
    public function setDatuenbabesa(\Zerbikat\BackendBundle\Entity\Datuenbabesa $datuenbabesa = null)
    {
        $this->datuenbabesa = $datuenbabesa;

        return $this;
    }

    /**
     * Get datuenbabesa
     *
     * @return \Zerbikat\BackendBundle\Entity\Datuenbabesa 
     */
    public function getDatuenbabesa()
    {
        return $this->datuenbabesa;
    }

    /**
     * Set azpisaila
     *
     * @param \Zerbikat\BackendBundle\Entity\Azpisaila $azpisaila
     * @return Fitxa
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

    /**
     * Set aurreikusi
     *
     * @param \Zerbikat\BackendBundle\Entity\Aurreikusi $aurreikusi
     * @return Fitxa
     */
    public function setAurreikusi(\Zerbikat\BackendBundle\Entity\Aurreikusi $aurreikusi = null)
    {
        $this->aurreikusi = $aurreikusi;

        return $this;
    }

    /**
     * Get aurreikusi
     *
     * @return \Zerbikat\BackendBundle\Entity\Aurreikusi 
     */
    public function getAurreikusi()
    {
        return $this->aurreikusi;
    }

    /**
     * Set arrunta
     *
     * @param \Zerbikat\BackendBundle\Entity\Arrunta $arrunta
     * @return Fitxa
     */
    public function setArrunta(\Zerbikat\BackendBundle\Entity\Arrunta $arrunta = null)
    {
        $this->arrunta = $arrunta;

        return $this;
    }

    /**
     * Get arrunta
     *
     * @return \Zerbikat\BackendBundle\Entity\Arrunta 
     */
    public function getArrunta()
    {
        return $this->arrunta;
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     * @return Fitxa
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
     * Set besteak1eu
     *
     * @param string $besteak1eu
     *
     * @return Fitxa
     */
    public function setBesteak1eu($besteak1eu)
    {
        $this->besteak1eu = $besteak1eu;

        return $this;
    }

    /**
     * Get besteak1eu
     *
     * @return string
     */
    public function getBesteak1eu()
    {
        return $this->besteak1eu;
    }

    /**
     * Set besteak1es
     *
     * @param string $besteak1es
     *
     * @return Fitxa
     */
    public function setBesteak1es($besteak1es)
    {
        $this->besteak1es = $besteak1es;

        return $this;
    }

    /**
     * Get besteak1es
     *
     * @return string
     */
    public function getBesteak1es()
    {
        return $this->besteak1es;
    }

    /**
     * Set bestea2keu
     *
     * @param string $bestea2keu
     *
     * @return Fitxa
     */
    public function setBestea2keu($bestea2keu)
    {
        $this->bestea2keu = $bestea2keu;

        return $this;
    }

    /**
     * Get bestea2keu
     *
     * @return string
     */
    public function getBestea2keu()
    {
        return $this->bestea2keu;
    }

    /**
     * Set besteak2es
     *
     * @param string $besteak2es
     *
     * @return Fitxa
     */
    public function setBesteak2es($besteak2es)
    {
        $this->besteak2es = $besteak2es;

        return $this;
    }

    /**
     * Get besteak2es
     *
     * @return string
     */
    public function getBesteak2es()
    {
        return $this->besteak2es;
    }

    /**
     * Set besteak3eu
     *
     * @param string $besteak3eu
     *
     * @return Fitxa
     */
    public function setBesteak3eu($besteak3eu)
    {
        $this->besteak3eu = $besteak3eu;

        return $this;
    }

    /**
     * Get besteak3eu
     *
     * @return string
     */
    public function getBesteak3eu()
    {
        return $this->besteak3eu;
    }

    /**
     * Set besteak3es
     *
     * @param string $besteak3es
     *
     * @return Fitxa
     */
    public function setBesteak3es($besteak3es)
    {
        $this->besteak3es = $besteak3es;

        return $this;
    }

    /**
     * Get besteak3es
     *
     * @return string
     */
    public function getBesteak3es()
    {
        return $this->besteak3es;
    }
}
