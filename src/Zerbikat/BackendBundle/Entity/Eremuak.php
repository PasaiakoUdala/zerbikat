<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Eremuak
 *
 * @ORM\Table(name="eremuak")
 * @ORM\Entity
 */
class Eremuak
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** @ORM\OneToOne(targetEntity="Udala") */
    private $udala;

    /**
     * @var oharraktext
     *
     * @ORM\Column(name="oharraktext", type="boolean", nullable=true)
     */
    private $oharraktext;

    /**
     * @var oharraklabeleu
     *
     * @ORM\Column(name="oharraklabeleu", type="string", length=255, nullable=true)
     */
    private $oharraklabeleu;

    /**
     * @var oharraklabeles
     *
     * @ORM\Column(name="oharraklabeles", type="string", length=255, nullable=true)
     */
    private $oharraklabeles;


    /**
     * @var helburuatext
     *
     * @ORM\Column(name="helburuatext", type="boolean", nullable=true)
     */
    private $helburuatext;

    /**
     * @var helburualabeleu
     *
     * @ORM\Column(name="helburualabeleu", type="string", length=255, nullable=true)
     */
    private $helburualabeleu;

    /**
     * @var helburualabeles
     *
     * @ORM\Column(name="helburualabeles", type="string", length=255, nullable=true)
     */
    private $helburualabeles;


    /**
     * @var ebazpensinpli
     *
     * @ORM\Column(name="ebazpensinpli", type="boolean", nullable=true)
     */
    private $ebazpensinpli;

    /**
     * @var ebazpensinplilabeleu
     *
     * @ORM\Column(name="ebazpensinplilabeleu", type="string", length=255, nullable=true)
     */
    private $ebazpensinplilabeleu;

    /**
     * @var ebazpensinplilabeles
     *
     * @ORM\Column(name="ebazpensinplilabeles", type="string", length=255, nullable=true)
     */
    private $ebazpensinplilabeles;


    /**
     * @var arduraaitorpena
     *
     * @ORM\Column(name="arduraaitorpena", type="boolean", nullable=true)
     */
    private $arduraaitorpena;

    /**
     * @var arduraaitorpenalabeleu
     *
     * @ORM\Column(name="arduraaitorpenalabeleu", type="string", length=255, nullable=true)
     */
    private $arduraaitorpenalabeleu;

    /**
     * @var arduraaitorpenalabeles
     *
     * @ORM\Column(name="arduraaitorpenalabeles", type="string", length=255, nullable=true)
     */
    private $arduraaitorpenalabeles;



    /**
     * @var aurreikusi
     *
     * @ORM\Column(name="aurreikusi", type="boolean", nullable=true)
     */
    private $aurreikusi;

    /**
     * @var aurreikusilabeleu
     *
     * @ORM\Column(name="aurreikusilabeleu", type="string", length=255, nullable=true)
     */
    private $aurreikusilabeleu;

    /**
     * @var aurreikusilabeles
     *
     * @ORM\Column(name="aurreikusilabeles", type="string", length=255, nullable=true)
     */
    private $aurreikusilabeles;

    /**
     * @var arrunta
     *
     * @ORM\Column(name="arrunta", type="boolean", nullable=true)
     */
    private $arrunta;

    /**
     * @var arruntalabeleu
     *
     * @ORM\Column(name="arruntalabeleu", type="string", length=255, nullable=true)
     */
    private $arruntalabeleu;

    /**
     * @var arruntalabeles
     *
     * @ORM\Column(name="arruntalabeles", type="string", length=255, nullable=true)
     */
    private $arruntalabeles;


    /**
     * @var isiltasunadmin
     *
     * @ORM\Column(name="isiltasunadmin", type="boolean", nullable=true)
     */
    private $isiltasunadmin;

    /**
     * @var isiltasunadminlabeleu
     *
     * @ORM\Column(name="isiltasunadminlabeleu", type="string", length=255, nullable=true)
     */
    private $isiltasunadminlabeleu;

    /**
     * @var isiltasunadminlabeles
     *
     * @ORM\Column(name="isiltasunadminlabeles", type="string", length=255, nullable=true)
     */
    private $isiltasunadminlabeles;




    /**
     * @var norkeskatutext
     *
     * @ORM\Column(name="norkeskatutext", type="boolean", nullable=true)
     */
    private $norkeskatutext;

    /**
     * @var norkeskatutable
     *
     * @ORM\Column(name="norkeskatutable", type="boolean", nullable=true)
     */
    private $norkeskatutable;


    /**
     * @var norkeskatulabeleu
     *
     * @ORM\Column(name="norkeskatulabeleu", type="string", length=255, nullable=true)
     */
    private $norkeskatulabeleu;

    /**
     * @var norkeskatulabeles
     *
     * @ORM\Column(name="norkeskatulabeles", type="string", length=255, nullable=true)
     */
    private $norkeskatulabeles;



    /**
     * @var dokumentazioatext
     *
     * @ORM\Column(name="dokumentazioatext", type="boolean", nullable=true)
     */
    private $dokumentazioatext;

    /**
     * @var dokumentazioatable
     *
     * @ORM\Column(name="dokumentazioatable", type="boolean", nullable=true)
     */
    private $dokumentazioatable;


    /**
     * @var dokumentazioalabeleu
     *
     * @ORM\Column(name="dokumentazioalabeleu", type="string", length=255, nullable=true)
     */
    private $dokumentazioalabeleu;

    /**
     * @var dokumentazioalabeles
     *
     * @ORM\Column(name="dokumentazioalabeles", type="string", length=255, nullable=true)
     */
    private $dokumentazioalabeles;



    /**
     * @var kostuatext
     *
     * @ORM\Column(name="kostuatext", type="boolean", nullable=true)
     */
    private $kostuatext;

    /**
     * @var kostuatable
     *
     * @ORM\Column(name="kostuatable", type="boolean", nullable=true)
     */
    private $kostuatable;


    /**
     * @var kostualabeleu
     *
     * @ORM\Column(name="kostualabeleu", type="string", length=255, nullable=true)
     */
    private $kostualabeleu;

    /**
     * @var kostualabeles
     *
     * @ORM\Column(name="kostualabeles", type="string", length=255, nullable=true)
     */
    private $kostualabeles;



    /**
     * @var araudiatext
     *
     * @ORM\Column(name="araudiatext", type="boolean", nullable=true)
     */
    private $araudiatext;

    /**
     * @var araudiatable
     *
     * @ORM\Column(name="araudiatable", type="boolean", nullable=true)
     */
    private $araudiatable;


    /**
     * @var araudialabeleu
     *
     * @ORM\Column(name="araudialabeleu", type="string", length=255, nullable=true)
     */
    private $araudialabeleu;

    /**
     * @var araudialabeles
     *
     * @ORM\Column(name="araudialabeles", type="string", length=255, nullable=true)
     */
    private $araudialabeles;


    /**
     * @var prozeduratext
     *
     * @ORM\Column(name="prozeduratext", type="boolean", nullable=true)
     */
    private $prozeduratext;

    /**
     * @var prozeduratable
     *
     * @ORM\Column(name="prozeduratable", type="boolean", nullable=true)
     */
    private $prozeduratable;


    /**
     * @var prozeduralabeleu
     *
     * @ORM\Column(name="prozeduralabeleu", type="string", length=255, nullable=true)
     */
    private $prozeduralabeleu;

    /**
     * @var prozeduralabeles
     *
     * @ORM\Column(name="prozeduralabeles", type="string", length=255, nullable=true)
     */
    private $prozeduralabeles;



    /**
     * @var tramiteatext
     *
     * @ORM\Column(name="tramiteatext", type="boolean", nullable=true)
     */
    private $tramiteatext;

    /**
     * @var tramiteatable
     *
     * @ORM\Column(name="tramiteatable", type="boolean", nullable=true)
     */
    private $tramiteatable;


    /**
     * @var tramitealabeleu
     *
     * @ORM\Column(name="tramitealabeleu", type="string", length=255, nullable=true)
     */
    private $tramitealabeleu;

    /**
     * @var tramitealabeles
     *
     * @ORM\Column(name="tramitealabeles", type="string", length=255, nullable=true)
     */
    private $tramitealabeles;



    /**
     * @var doklaguntext
     *
     * @ORM\Column(name="doklaguntext", type="boolean", nullable=false)
     */
    private $doklaguntext;

    /**
     * @var doklaguntable
     *
     * @ORM\Column(name="doklaguntable", type="boolean", nullable=true)
     */
    private $doklaguntable;


    /**
     * @var doklagunlabeleu
     *
     * @ORM\Column(name="doklagunlabeleu", type="string", length=255, nullable=true)
     */
    private $doklagunlabeleu;

    /**
     * @var doklagunlabeles
     *
     * @ORM\Column(name="doklagunlabeles", type="string", length=255, nullable=true)
     */
    private $doklagunlabeles;


    /**
     *
     *      FUNTZIOAK
     *
     */



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
     * Set oharraktext
     *
     * @param boolean $oharraktext
     *
     * @return Eremuak
     */
    public function setOharraktext($oharraktext)
    {
        $this->oharraktext = $oharraktext;

        return $this;
    }

    /**
     * Get oharraktext
     *
     * @return boolean
     */
    public function getOharraktext()
    {
        return $this->oharraktext;
    }

    /**
     * Set oharraklabeleu
     *
     * @param string $oharraklabeleu
     *
     * @return Eremuak
     */
    public function setOharraklabeleu($oharraklabeleu)
    {
        $this->oharraklabeleu = $oharraklabeleu;

        return $this;
    }

    /**
     * Get oharraklabeleu
     *
     * @return string
     */
    public function getOharraklabeleu()
    {
        return $this->oharraklabeleu;
    }

    /**
     * Set oharraklabeles
     *
     * @param string $oharraklabeles
     *
     * @return Eremuak
     */
    public function setOharraklabeles($oharraklabeles)
    {
        $this->oharraklabeles = $oharraklabeles;

        return $this;
    }

    /**
     * Get oharraklabeles
     *
     * @return string
     */
    public function getOharraklabeles()
    {
        return $this->oharraklabeles;
    }

    /**
     * Set helburuatext
     *
     * @param boolean $helburuatext
     *
     * @return Eremuak
     */
    public function setHelburuatext($helburuatext)
    {
        $this->helburuatext = $helburuatext;

        return $this;
    }

    /**
     * Get helburuatext
     *
     * @return boolean
     */
    public function getHelburuatext()
    {
        return $this->helburuatext;
    }

    /**
     * Set helburualabeleu
     *
     * @param string $helburualabeleu
     *
     * @return Eremuak
     */
    public function setHelburualabeleu($helburualabeleu)
    {
        $this->helburualabeleu = $helburualabeleu;

        return $this;
    }

    /**
     * Get helburualabeleu
     *
     * @return string
     */
    public function getHelburualabeleu()
    {
        return $this->helburualabeleu;
    }

    /**
     * Set helburualabeles
     *
     * @param string $helburualabeles
     *
     * @return Eremuak
     */
    public function setHelburualabeles($helburualabeles)
    {
        $this->helburualabeles = $helburualabeles;

        return $this;
    }

    /**
     * Get helburualabeles
     *
     * @return string
     */
    public function getHelburualabeles()
    {
        return $this->helburualabeles;
    }

    /**
     * Set ebazpensinpli
     *
     * @param boolean $ebazpensinpli
     *
     * @return Eremuak
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
     * Set ebazpensinplilabeleu
     *
     * @param string $ebazpensinplilabeleu
     *
     * @return Eremuak
     */
    public function setEbazpensinplilabeleu($ebazpensinplilabeleu)
    {
        $this->ebazpensinplilabeleu = $ebazpensinplilabeleu;

        return $this;
    }

    /**
     * Get ebazpensinplilabeleu
     *
     * @return string
     */
    public function getEbazpensinplilabeleu()
    {
        return $this->ebazpensinplilabeleu;
    }

    /**
     * Set ebazpensinplilabeles
     *
     * @param string $ebazpensinplilabeles
     *
     * @return Eremuak
     */
    public function setEbazpensinplilabeles($ebazpensinplilabeles)
    {
        $this->ebazpensinplilabeles = $ebazpensinplilabeles;

        return $this;
    }

    /**
     * Get ebazpensinplilabeles
     *
     * @return string
     */
    public function getEbazpensinplilabeles()
    {
        return $this->ebazpensinplilabeles;
    }

    /**
     * Set arduraaitorpena
     *
     * @param boolean $arduraaitorpena
     *
     * @return Eremuak
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
     * Set arduraaitorpenalabeleu
     *
     * @param string $arduraaitorpenalabeleu
     *
     * @return Eremuak
     */
    public function setArduraaitorpenalabeleu($arduraaitorpenalabeleu)
    {
        $this->arduraaitorpenalabeleu = $arduraaitorpenalabeleu;

        return $this;
    }

    /**
     * Get arduraaitorpenalabeleu
     *
     * @return string
     */
    public function getArduraaitorpenalabeleu()
    {
        return $this->arduraaitorpenalabeleu;
    }

    /**
     * Set arduraaitorpenalabeles
     *
     * @param string $arduraaitorpenalabeles
     *
     * @return Eremuak
     */
    public function setArduraaitorpenalabeles($arduraaitorpenalabeles)
    {
        $this->arduraaitorpenalabeles = $arduraaitorpenalabeles;

        return $this;
    }

    /**
     * Get arduraaitorpenalabeles
     *
     * @return string
     */
    public function getArduraaitorpenalabeles()
    {
        return $this->arduraaitorpenalabeles;
    }

    /**
     * Set aurreikusi
     *
     * @param boolean $aurreikusi
     *
     * @return Eremuak
     */
    public function setAurreikusi($aurreikusi)
    {
        $this->aurreikusi = $aurreikusi;

        return $this;
    }

    /**
     * Get aurreikusi
     *
     * @return boolean
     */
    public function getAurreikusi()
    {
        return $this->aurreikusi;
    }

    /**
     * Set aurreikusilabeleu
     *
     * @param string $aurreikusilabeleu
     *
     * @return Eremuak
     */
    public function setAurreikusilabeleu($aurreikusilabeleu)
    {
        $this->aurreikusilabeleu = $aurreikusilabeleu;

        return $this;
    }

    /**
     * Get aurreikusilabeleu
     *
     * @return string
     */
    public function getAurreikusilabeleu()
    {
        return $this->aurreikusilabeleu;
    }

    /**
     * Set aurreikusilabeles
     *
     * @param string $aurreikusilabeles
     *
     * @return Eremuak
     */
    public function setAurreikusilabeles($aurreikusilabeles)
    {
        $this->aurreikusilabeles = $aurreikusilabeles;

        return $this;
    }

    /**
     * Get aurreikusilabeles
     *
     * @return string
     */
    public function getAurreikusilabeles()
    {
        return $this->aurreikusilabeles;
    }

    /**
     * Set arrunta
     *
     * @param boolean $arrunta
     *
     * @return Eremuak
     */
    public function setArrunta($arrunta)
    {
        $this->arrunta = $arrunta;

        return $this;
    }

    /**
     * Get arrunta
     *
     * @return boolean
     */
    public function getArrunta()
    {
        return $this->arrunta;
    }

    /**
     * Set arruntalabeleu
     *
     * @param string $arruntalabeleu
     *
     * @return Eremuak
     */
    public function setArruntalabeleu($arruntalabeleu)
    {
        $this->arruntalabeleu = $arruntalabeleu;

        return $this;
    }

    /**
     * Get arruntalabeleu
     *
     * @return string
     */
    public function getArruntalabeleu()
    {
        return $this->arruntalabeleu;
    }

    /**
     * Set arruntalabeles
     *
     * @param string $arruntalabeles
     *
     * @return Eremuak
     */
    public function setArruntalabeles($arruntalabeles)
    {
        $this->arruntalabeles = $arruntalabeles;

        return $this;
    }

    /**
     * Get arruntalabeles
     *
     * @return string
     */
    public function getArruntalabeles()
    {
        return $this->arruntalabeles;
    }

    /**
     * Set isiltasunadmin
     *
     * @param boolean $isiltasunadmin
     *
     * @return Eremuak
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
     * Set isiltasunadminlabeleu
     *
     * @param string $isiltasunadminlabeleu
     *
     * @return Eremuak
     */
    public function setIsiltasunadminlabeleu($isiltasunadminlabeleu)
    {
        $this->isiltasunadminlabeleu = $isiltasunadminlabeleu;

        return $this;
    }

    /**
     * Get isiltasunadminlabeleu
     *
     * @return string
     */
    public function getIsiltasunadminlabeleu()
    {
        return $this->isiltasunadminlabeleu;
    }

    /**
     * Set isiltasunadminlabeles
     *
     * @param string $isiltasunadminlabeles
     *
     * @return Eremuak
     */
    public function setIsiltasunadminlabeles($isiltasunadminlabeles)
    {
        $this->isiltasunadminlabeles = $isiltasunadminlabeles;

        return $this;
    }

    /**
     * Get isiltasunadminlabeles
     *
     * @return string
     */
    public function getIsiltasunadminlabeles()
    {
        return $this->isiltasunadminlabeles;
    }

    /**
     * Set norkeskatutext
     *
     * @param boolean $norkeskatutext
     *
     * @return Eremuak
     */
    public function setNorkeskatutext($norkeskatutext)
    {
        $this->norkeskatutext = $norkeskatutext;

        return $this;
    }

    /**
     * Get norkeskatutext
     *
     * @return boolean
     */
    public function getNorkeskatutext()
    {
        return $this->norkeskatutext;
    }

    /**
     * Set norkeskatutable
     *
     * @param boolean $norkeskatutable
     *
     * @return Eremuak
     */
    public function setNorkeskatutable($norkeskatutable)
    {
        $this->norkeskatutable = $norkeskatutable;

        return $this;
    }

    /**
     * Get norkeskatutable
     *
     * @return boolean
     */
    public function getNorkeskatutable()
    {
        return $this->norkeskatutable;
    }

    /**
     * Set norkeskatulabeleu
     *
     * @param string $norkeskatulabeleu
     *
     * @return Eremuak
     */
    public function setNorkeskatulabeleu($norkeskatulabeleu)
    {
        $this->norkeskatulabeleu = $norkeskatulabeleu;

        return $this;
    }

    /**
     * Get norkeskatulabeleu
     *
     * @return string
     */
    public function getNorkeskatulabeleu()
    {
        return $this->norkeskatulabeleu;
    }

    /**
     * Set norkeskatulabeles
     *
     * @param string $norkeskatulabeles
     *
     * @return Eremuak
     */
    public function setNorkeskatulabeles($norkeskatulabeles)
    {
        $this->norkeskatulabeles = $norkeskatulabeles;

        return $this;
    }

    /**
     * Get norkeskatulabeles
     *
     * @return string
     */
    public function getNorkeskatulabeles()
    {
        return $this->norkeskatulabeles;
    }

    /**
     * Set dokumentazioatext
     *
     * @param boolean $dokumentazioatext
     *
     * @return Eremuak
     */
    public function setDokumentazioatext($dokumentazioatext)
    {
        $this->dokumentazioatext = $dokumentazioatext;

        return $this;
    }

    /**
     * Get dokumentazioatext
     *
     * @return boolean
     */
    public function getDokumentazioatext()
    {
        return $this->dokumentazioatext;
    }

    /**
     * Set dokumentazioatable
     *
     * @param boolean $dokumentazioatable
     *
     * @return Eremuak
     */
    public function setDokumentazioatable($dokumentazioatable)
    {
        $this->dokumentazioatable = $dokumentazioatable;

        return $this;
    }

    /**
     * Get dokumentazioatable
     *
     * @return boolean
     */
    public function getDokumentazioatable()
    {
        return $this->dokumentazioatable;
    }

    /**
     * Set dokumentazioalabeleu
     *
     * @param string $dokumentazioalabeleu
     *
     * @return Eremuak
     */
    public function setDokumentazioalabeleu($dokumentazioalabeleu)
    {
        $this->dokumentazioalabeleu = $dokumentazioalabeleu;

        return $this;
    }

    /**
     * Get dokumentazioalabeleu
     *
     * @return string
     */
    public function getDokumentazioalabeleu()
    {
        return $this->dokumentazioalabeleu;
    }

    /**
     * Set dokumentazioalabeles
     *
     * @param string $dokumentazioalabeles
     *
     * @return Eremuak
     */
    public function setDokumentazioalabeles($dokumentazioalabeles)
    {
        $this->dokumentazioalabeles = $dokumentazioalabeles;

        return $this;
    }

    /**
     * Get dokumentazioalabeles
     *
     * @return string
     */
    public function getDokumentazioalabeles()
    {
        return $this->dokumentazioalabeles;
    }

    /**
     * Set kostuatext
     *
     * @param boolean $kostuatext
     *
     * @return Eremuak
     */
    public function setKostuatext($kostuatext)
    {
        $this->kostuatext = $kostuatext;

        return $this;
    }

    /**
     * Get kostuatext
     *
     * @return boolean
     */
    public function getKostuatext()
    {
        return $this->kostuatext;
    }

    /**
     * Set kostuatable
     *
     * @param boolean $kostuatable
     *
     * @return Eremuak
     */
    public function setKostuatable($kostuatable)
    {
        $this->kostuatable = $kostuatable;

        return $this;
    }

    /**
     * Get kostuatable
     *
     * @return boolean
     */
    public function getKostuatable()
    {
        return $this->kostuatable;
    }

    /**
     * Set kostualabeleu
     *
     * @param string $kostualabeleu
     *
     * @return Eremuak
     */
    public function setKostualabeleu($kostualabeleu)
    {
        $this->kostualabeleu = $kostualabeleu;

        return $this;
    }

    /**
     * Get kostualabeleu
     *
     * @return string
     */
    public function getKostualabeleu()
    {
        return $this->kostualabeleu;
    }

    /**
     * Set kostualabeles
     *
     * @param string $kostualabeles
     *
     * @return Eremuak
     */
    public function setKostualabeles($kostualabeles)
    {
        $this->kostualabeles = $kostualabeles;

        return $this;
    }

    /**
     * Get kostualabeles
     *
     * @return string
     */
    public function getKostualabeles()
    {
        return $this->kostualabeles;
    }

    /**
     * Set araudiatext
     *
     * @param boolean $araudiatext
     *
     * @return Eremuak
     */
    public function setAraudiatext($araudiatext)
    {
        $this->araudiatext = $araudiatext;

        return $this;
    }

    /**
     * Get araudiatext
     *
     * @return boolean
     */
    public function getAraudiatext()
    {
        return $this->araudiatext;
    }

    /**
     * Set araudiatable
     *
     * @param boolean $araudiatable
     *
     * @return Eremuak
     */
    public function setAraudiatable($araudiatable)
    {
        $this->araudiatable = $araudiatable;

        return $this;
    }

    /**
     * Get araudiatable
     *
     * @return boolean
     */
    public function getAraudiatable()
    {
        return $this->araudiatable;
    }

    /**
     * Set araudialabeleu
     *
     * @param string $araudialabeleu
     *
     * @return Eremuak
     */
    public function setAraudialabeleu($araudialabeleu)
    {
        $this->araudialabeleu = $araudialabeleu;

        return $this;
    }

    /**
     * Get araudialabeleu
     *
     * @return string
     */
    public function getAraudialabeleu()
    {
        return $this->araudialabeleu;
    }

    /**
     * Set araudialabeles
     *
     * @param string $araudialabeles
     *
     * @return Eremuak
     */
    public function setAraudialabeles($araudialabeles)
    {
        $this->araudialabeles = $araudialabeles;

        return $this;
    }

    /**
     * Get araudialabeles
     *
     * @return string
     */
    public function getAraudialabeles()
    {
        return $this->araudialabeles;
    }

    /**
     * Set prozeduratext
     *
     * @param boolean $prozeduratext
     *
     * @return Eremuak
     */
    public function setProzeduratext($prozeduratext)
    {
        $this->prozeduratext = $prozeduratext;

        return $this;
    }

    /**
     * Get prozeduratext
     *
     * @return boolean
     */
    public function getProzeduratext()
    {
        return $this->prozeduratext;
    }

    /**
     * Set prozeduratable
     *
     * @param boolean $prozeduratable
     *
     * @return Eremuak
     */
    public function setProzeduratable($prozeduratable)
    {
        $this->prozeduratable = $prozeduratable;

        return $this;
    }

    /**
     * Get prozeduratable
     *
     * @return boolean
     */
    public function getProzeduratable()
    {
        return $this->prozeduratable;
    }

    /**
     * Set prozeduralabeleu
     *
     * @param string $prozeduralabeleu
     *
     * @return Eremuak
     */
    public function setProzeduralabeleu($prozeduralabeleu)
    {
        $this->prozeduralabeleu = $prozeduralabeleu;

        return $this;
    }

    /**
     * Get prozeduralabeleu
     *
     * @return string
     */
    public function getProzeduralabeleu()
    {
        return $this->prozeduralabeleu;
    }

    /**
     * Set prozeduralabeles
     *
     * @param string $prozeduralabeles
     *
     * @return Eremuak
     */
    public function setProzeduralabeles($prozeduralabeles)
    {
        $this->prozeduralabeles = $prozeduralabeles;

        return $this;
    }

    /**
     * Get prozeduralabeles
     *
     * @return string
     */
    public function getProzeduralabeles()
    {
        return $this->prozeduralabeles;
    }

    /**
     * Set tramiteatext
     *
     * @param boolean $tramiteatext
     *
     * @return Eremuak
     */
    public function setTramiteatext($tramiteatext)
    {
        $this->tramiteatext = $tramiteatext;

        return $this;
    }

    /**
     * Get tramiteatext
     *
     * @return boolean
     */
    public function getTramiteatext()
    {
        return $this->tramiteatext;
    }

    /**
     * Set tramiteatable
     *
     * @param boolean $tramiteatable
     *
     * @return Eremuak
     */
    public function setTramiteatable($tramiteatable)
    {
        $this->tramiteatable = $tramiteatable;

        return $this;
    }

    /**
     * Get tramiteatable
     *
     * @return boolean
     */
    public function getTramiteatable()
    {
        return $this->tramiteatable;
    }

    /**
     * Set tramitealabeleu
     *
     * @param string $tramitealabeleu
     *
     * @return Eremuak
     */
    public function setTramitealabeleu($tramitealabeleu)
    {
        $this->tramitealabeleu = $tramitealabeleu;

        return $this;
    }

    /**
     * Get tramitealabeleu
     *
     * @return string
     */
    public function getTramitealabeleu()
    {
        return $this->tramitealabeleu;
    }

    /**
     * Set tramitealabeles
     *
     * @param string $tramitealabeles
     *
     * @return Eremuak
     */
    public function setTramitealabeles($tramitealabeles)
    {
        $this->tramitealabeles = $tramitealabeles;

        return $this;
    }

    /**
     * Get tramitealabeles
     *
     * @return string
     */
    public function getTramitealabeles()
    {
        return $this->tramitealabeles;
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     *
     * @return Eremuak
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
     * Set doklaguntext
     *
     * @param boolean $doklaguntext
     *
     * @return Eremuak
     */
    public function setDoklaguntext($doklaguntext)
    {
        $this->doklaguntext = $doklaguntext;

        return $this;
    }

    /**
     * Get doklaguntext
     *
     * @return boolean
     */
    public function getDoklaguntext()
    {
        return $this->doklaguntext;
    }

    /**
     * Set doklaguntable
     *
     * @param boolean $doklaguntable
     *
     * @return Eremuak
     */
    public function setDoklaguntable($doklaguntable)
    {
        $this->doklaguntable = $doklaguntable;

        return $this;
    }

    /**
     * Get doklaguntable
     *
     * @return boolean
     */
    public function getDoklaguntable()
    {
        return $this->doklaguntable;
    }

    /**
     * Set doklagunlabeleu
     *
     * @param string $doklagunlabeleu
     *
     * @return Eremuak
     */
    public function setDoklagunlabeleu($doklagunlabeleu)
    {
        $this->doklagunlabeleu = $doklagunlabeleu;

        return $this;
    }

    /**
     * Get doklagunlabeleu
     *
     * @return string
     */
    public function getDoklagunlabeleu()
    {
        return $this->doklagunlabeleu;
    }

    /**
     * Set doklagunlabeles
     *
     * @param string $doklagunlabeles
     *
     * @return Eremuak
     */
    public function setDoklagunlabeles($doklagunlabeles)
    {
        $this->doklagunlabeles = $doklagunlabeles;

        return $this;
    }

    /**
     * Get doklagunlabeles
     *
     * @return string
     */
    public function getDoklagunlabeles()
    {
        return $this->doklagunlabeles;
    }
}
