<?php

    namespace Zerbikat\BackendBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;
    use JMS\Serializer\Annotation\ExclusionPolicy;
    use JMS\Serializer\Annotation\Expose;
    use JMS\Serializer\Annotation as JMS;
    use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;
    use Doctrine\ORM\Mapping\OrderBy;
    use Zerbikat\BackendBundle\Entity\Arrunta;
    use Zerbikat\BackendBundle\Entity\Aurreikusi;
    use Zerbikat\BackendBundle\Entity\Azpiatala;
    use Zerbikat\BackendBundle\Entity\Azpisaila;
    use Zerbikat\BackendBundle\Entity\Besteak1;
    use Zerbikat\BackendBundle\Entity\Besteak2;
    use Zerbikat\BackendBundle\Entity\Besteak3;
    use Zerbikat\BackendBundle\Entity\Datuenbabesa;
    use Zerbikat\BackendBundle\Entity\Doklagun;
    use Zerbikat\BackendBundle\Entity\Dokumentazioa;
    use Zerbikat\BackendBundle\Entity\Etiketa;
    use Zerbikat\BackendBundle\Entity\FitxaAraudia;
    use Zerbikat\BackendBundle\Entity\Fitxafamilia;
    use Zerbikat\BackendBundle\Entity\FitxaKostua;
    use Zerbikat\BackendBundle\Entity\FitxaProzedura;
    use Zerbikat\BackendBundle\Entity\IsiltasunAdministratiboa;
    use Zerbikat\BackendBundle\Entity\Kanala;
    use Zerbikat\BackendBundle\Entity\Norkebatzi;
    use Zerbikat\BackendBundle\Entity\Norkeskatu;
    use Zerbikat\BackendBundle\Entity\Udala;
    use Zerbikat\BackendBundle\Entity\Zerbitzua;

    /**
     * Fitxa
     *
     * @ORM\Table(name="fitxa", indexes={@ORM\Index(name="aurreikusi_id_idx", columns={"aurreikusi_id"}), @ORM\Index(name="arrunta_id_idx", columns={"arrunta_id"}), @ORM\Index(name="norkebatzi_id_idx", columns={"norkebatzi_id"}), @ORM\Index(name="azpisaila_id_idx", columns={"azpisaila_id"}), @ORM\Index(name="datuenbabesa_id_idx", columns={"datuenbabesa_id"}), @ORM\Index(name="zerbitzua_id_idx", columns={"zerbitzua_id"})})
     * @ORM\Entity
     * @ExclusionPolicy("all")
     * @UdalaEgiaztatu(userFieldName="udala_id")
     */
    class Fitxa
    {

        /**
         * @var integer
         *
         * @Expose
         * @ORM\Column(name="id", type="bigint")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         * @JMS\Groups({"kontakud"})
         */
        private $id;

        /**
         * @var integer
         *
         * @ORM\Column(name="origenid", type="bigint", nullable=true)
         */
        private $origenid;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="espedientekodea", type="string", length=9, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $espedientekodea;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="expedientes", type="string", length=9, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $expedientes;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="deskribapenaeu", type="string", length=255, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $deskribapenaeu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="deskribapenaes", type="string", length=255, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $deskribapenaes;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="helburuaeu", type="text", length=65535, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $helburuaeu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="helburuaes", type="text", length=65535, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $helburuaes;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="norkeu", type="text", length=65535, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $norkeu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="norkes", type="text", length=65535, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $norkes;

        /**
         * @var string
         *
         * @ORM\Column(name="dokumentazioaeu", type="text", length=65535, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $dokumentazioaeu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="dokumentazioaes", type="text", length=65535, nullable=true)
         * @JMS\Groups({"kontakud"})
         */
        private $dokumentazioaes;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="kostuaeu", type="text", length=65535, nullable=true)
         */
        private $kostuaeu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="kostuaes", type="text", length=65535, nullable=true)
         */
        private $kostuaes;

        /**
         * @var boolean
         * @Expose
         * @ORM\Column(name="ebazpensinpli", type="boolean", nullable=true)
         */
        private $ebazpensinpli;

        /**
         * @var boolean
         * @Expose
         * @ORM\Column(name="arduraaitorpena", type="boolean", nullable=true)
         */
        private $arduraaitorpena;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="araudiaeu", type="text", length=65535, nullable=true)
         */
        private $araudiaeu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="araudiaes", type="text", length=65535, nullable=true)
         */
        private $araudiaes;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="prozeduraeu", type="text", length=65535, nullable=true)
         */
        private $prozeduraeu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="prozeduraes", type="text", length=65535, nullable=true)
         */
        private $prozeduraes;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="doklaguneu", type="text", length=65535, nullable=true)
         */
        private $doklaguneu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="doklagunes", type="text", length=65535, nullable=true)
         */
        private $doklagunes;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="oharrakeu", type="text", length=65535, nullable=true)
         */
        private $oharrakeu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="oharrakes", type="text", length=65535, nullable=true)
         */
        private $oharrakes;

        /**
         * @var datuenbabesaeu
         * @Expose
         * @ORM\Column(name="datuenbabesaeu", type="text", length=65535, nullable=true)
         */
        private $datuenbabesaeu;

        /**
         * @var datuenbabesaes
         * @Expose
         * @ORM\Column(name="datuenbabesaes", type="text", length=65535, nullable=true)
         */
        private $datuenbabesaes;

        /**
         * @var norkonartueu
         * @Expose
         * @ORM\Column(name="norkonartueu", type="text", length=65535, nullable=true)
         */
        private $norkonartueu;

        /**
         * @var norkonartues
         * @Expose
         * @ORM\Column(name="norkonartues", type="text", length=65535, nullable=true)
         */
        private $norkonartues;


        /**
         * @var boolean
         * @Expose
         * @ORM\Column(name="publikoa", type="boolean", nullable=true)
         */
        private $publikoa;

        /**
         * @var boolean
         * @Expose
         * @ORM\Column(name="hitzarmena", type="boolean", nullable=true)
         */
        private $hitzarmena;


        /**
         * @var integer
         * @Expose
         * @ORM\Column(name="kontsultak", type="bigint", nullable=true)
         */
        private $kontsultak;

        /**
         * @var string
         * @Expose
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
         * @ORM\Column(name="updated_at", type="datetime", nullable=false)
         */
        private $updatedAt;

        /**
         * @var jarraibideakeu
         *
         * @ORM\Column(name="jarraibideakeu", type="text", nullable=true)
         */
        private $jarraibideakeu;

        /**
         * @var jarraibideakes
         *
         * @ORM\Column(name="jarraibideakes", type="text", nullable=true)
         */
        private $jarraibideakes;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="besteak1eu", type="text", length=65535, nullable=true)
         * @Expose
         */
        private $besteak1eu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="besteak1es", type="text", length=65535, nullable=true)
         */
        private $besteak1es;
        /**
         * @var string
         * @Expose
         * @ORM\Column(name="besteak2eu", type="text", length=65535, nullable=true)
         */
        private $besteak2eu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="besteak2es", type="text", length=65535, nullable=true)
         */
        private $besteak2es;
        /**
         * @var string
         * @Expose
         * @ORM\Column(name="besteak3eu", type="text", length=65535, nullable=true)
         */
        private $besteak3eu;

        /**
         * @var string
         * @Expose
         * @ORM\Column(name="besteak3es", type="text", length=65535, nullable=true)
         */
        private $besteak3es;

        /**
         * @var kanalaeu
         * @Expose
         * @ORM\Column(name="kanalaeu", type="text", length=65535, nullable=true)
         */
        private $kanalaeu;

        /**
         * @var kanalaes
         * @Expose
         * @ORM\Column(name="kanalaes", type="text", length=65535, nullable=true)
         */
        private $kanalaes;


        /**************************************************************************************************************
         **************************************************************************************************************
         ******* ERLAZIOAK: ManyToOne *********************************************************************************
         **************************************************************************************************************
         *************************************************************************************************************/

        /**
         * @ORM\ManyToOne(targetEntity="Udala")
         * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="CASCADE")
         */
        private $udala;

        /**
         * @var Norkebatzi
         *
         * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Norkebatzi")
         * @ORM\JoinColumn(name="norkebatzi_id", referencedColumnName="id", onDelete="SET NULL")
         *
         */
        private $norkebatzi;

        /**
         * @var Zerbitzua
         *
         * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Zerbitzua")
         * @ORM\JoinColumn(name="zerbitzua_id", referencedColumnName="id", onDelete="SET NULL")
         *
         */
        private $zerbitzua;

        /**
         * @var Datuenbabesa
         *
         * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Datuenbabesa")
         * @ORM\JoinColumn(name="datuenbabesa_id", referencedColumnName="id", onDelete="SET NULL")
         *
         */
        private $datuenbabesa;

        /**
         * @var Azpisaila
         *
         * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Azpisaila")
         * @ORM\JoinColumn(name="azpisaila_id", referencedColumnName="id", onDelete="SET NULL")
         *
         * @Expose
         */
        private $azpisaila;

        /**
         * @var Aurreikusi
         *
         * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Aurreikusi")
         * @ORM\JoinColumn(name="aurreikusi_id", referencedColumnName="id", onDelete="SET NULL")
         *
         * @Expose
         */
        private $aurreikusi;

        /**
         * @var Arrunta
         *
         * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\Arrunta")
         * @ORM\JoinColumn(name="arrunta_id", referencedColumnName="id", onDelete="SET NULL")
         *
         * @Expose
         */
        private $arrunta;

        /**
         * @var IsiltasunAdministratiboa
         * @Expose
         * @ORM\ManyToOne(targetEntity="Zerbikat\BackendBundle\Entity\IsiltasunAdministratiboa",inversedBy="fitxak")
         * @ORM\JoinColumn(name="isiltasunadmin_id", referencedColumnName="id", onDelete="SET NULL")
         *
         */
        private $isiltasunadmin;


        /**
         *      ERLAZIOAK: ManyToMany
         */

        /**
         * @var dokumentazioak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Dokumentazioa", inversedBy="fitxa")
         * @OrderBy({"kodea" = "ASC"})
         */
        private $dokumentazioak;


        /**
         * @var kanalak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Kanala",inversedBy="fitxak")
         */
        private $kanalak;

        /**
         * @var besteak1ak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Besteak1",inversedBy="fitxak")
         */
        private $besteak1ak;

        /**
         * @var besteak2ak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Besteak2",inversedBy="fitxak")
         */
        private $besteak2ak;

        /**
         * @var besteak3ak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Besteak3",inversedBy="fitxak")
         */
        private $besteak3ak;

        /**
         * @var etiketak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Etiketa",inversedBy="fitxak")
         */
        private $etiketak;

        /**
         * @var norkeskatuak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Norkeskatu",inversedBy="fitxak")
         */
        private $norkeskatuak;

        /**
         * @var doklagunak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Doklagun",inversedBy="fitxak")
         */
        private $doklagunak;

        /**
         * @var azpiatalak[]
         * @Expose
         * @ORM\ManyToMany(targetEntity="Azpiatala",inversedBy="fitxak")
         * @ORM\JoinTable(name="fitxa_azpiatala")
         */
        private $azpiatalak;


        /**
         *      ERLAZIOAK: ManyToMany + Extra fields
         */


        /**
         * @Expose
         * @ORM\OneToMany(targetEntity="Zerbikat\BackendBundle\Entity\Fitxafamilia", mappedBy="fitxa", cascade={"remove"}, orphanRemoval=true)
         * @OrderBy({"ordena" = "ASC"})
         */
        private $fitxafamilia;

        /**
         * @var prozedurak[]
         *
         * @ORM\OneToMany(targetEntity="FitxaProzedura" , mappedBy="fitxa",cascade={"persist"} )
         * @ORM\OrderBy({"ordena" = "ASC"})
         */
        private $prozedurak;

        /**
         * @var araudiak[]
         * @Expose
         * @ORM\OneToMany(targetEntity="FitxaAraudia", mappedBy="fitxa",cascade={"persist"})
         */
        private $araudiak;

        /**
         * @var kostuak[]
         * @Expose
         * @ORM\OneToMany(targetEntity="FitxaKostua", mappedBy="fitxa",cascade={"persist"})
         */
        private $kostuak;


        public function __toString ()
        {
            return (string) $this->getDeskribapenaeu();
        }


        /**
         *
         *
         *      FUNTZIOAK
         *
         *
         *
         */


        /**
         * Constructor
         */
        public function __construct ()
        {
            $this->araudiak = new ArrayCollection();
            $this->dokumentazioak = new ArrayCollection();
            $this->kanalak = new ArrayCollection();
            $this->besteak1ak = new ArrayCollection();
            $this->besteak2ak = new ArrayCollection();
            $this->besteak3ak = new ArrayCollection();
            $this->etiketak = new ArrayCollection();
            $this->norkeskatuak = new ArrayCollection();
            $this->doklagunak = new ArrayCollection();
            $this->fitxafamilia = new ArrayCollection();
            $this->prozedurak = new ArrayCollection();
            $this->azpiatalak = new ArrayCollection();

            $this->prozedurak = new ArrayCollection();
            $this->kostuak = new ArrayCollection();

            $this->createdAt = new \DateTime();
            $this->updatedAt = new \DateTime();
            $this->publikoa = 1;
        }


        public function addFitxaProzedura ( FitxaProzedura $fitxaProzedura )
        {
            $this->prozedurak->add( $fitxaProzedura );
        }

        public function removeFitxaProzedura ( FitxaProzedura $fitxaProzedura )
        {
            $this->prozedurak->removeElement( $fitxaProzedura );
        }

        public function addFitxaAraudia ( FitxaAraudia $fitxaAraudia )
        {
            $this->araudiak->add( $fitxaAraudia );
        }

        public function removeFitxaAraudia ( FitxaAraudia $fitxaAraudia )
        {
            $this->araudiak->removeElement( $fitxaAraudia );
        }

        public function addFitxaKostua ( FitxaKostua $fitxaKostua )
        {
            $this->kostuak->add( $fitxaKostua );
        }

        public function removeFitxaKostua ( FitxaKostua $fitxaKostua )
        {
            $this->kostuak->removeElement( $fitxaKostua );
        }


        /**
         *
         *      HEMENDIK AURRERA AUTOMATIKOKI SORTUTATOAK
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
     * Set espedientekodea
     *
     * @param string $espedientekodea
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     * Set kostuaeu
     *
     * @param string $kostuaeu
     *
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
     *
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
     *
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
     *
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
     * Set araudiaeu
     *
     * @param string $araudiaeu
     *
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
     *
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
     *
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
     *
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
     * Set doklaguneu
     *
     * @param string $doklaguneu
     *
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
     *
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
     *
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
     *
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
     * Set datuenbabesaeu
     *
     * @param string $datuenbabesaeu
     *
     * @return Fitxa
     */
    public function setDatuenbabesaeu($datuenbabesaeu)
    {
        $this->datuenbabesaeu = $datuenbabesaeu;

        return $this;
    }

    /**
     * Get datuenbabesaeu
     *
     * @return string
     */
    public function getDatuenbabesaeu()
    {
        return $this->datuenbabesaeu;
    }

    /**
     * Set datuenbabesaes
     *
     * @param string $datuenbabesaes
     *
     * @return Fitxa
     */
    public function setDatuenbabesaes($datuenbabesaes)
    {
        $this->datuenbabesaes = $datuenbabesaes;

        return $this;
    }

    /**
     * Get datuenbabesaes
     *
     * @return string
     */
    public function getDatuenbabesaes()
    {
        return $this->datuenbabesaes;
    }

    /**
     * Set norkonartueu
     *
     * @param string $norkonartueu
     *
     * @return Fitxa
     */
    public function setNorkonartueu($norkonartueu)
    {
        $this->norkonartueu = $norkonartueu;

        return $this;
    }

    /**
     * Get norkonartueu
     *
     * @return string
     */
    public function getNorkonartueu()
    {
        return $this->norkonartueu;
    }

    /**
     * Set norkonartues
     *
     * @param string $norkonartues
     *
     * @return Fitxa
     */
    public function setNorkonartues($norkonartues)
    {
        $this->norkonartues = $norkonartues;

        return $this;
    }

    /**
     * Get norkonartues
     *
     * @return string
     */
    public function getNorkonartues()
    {
        return $this->norkonartues;
    }

    /**
     * Set publikoa
     *
     * @param boolean $publikoa
     *
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
     * Set hitzarmena
     *
     * @param boolean $hitzarmena
     *
     * @return Fitxa
     */
    public function setHitzarmena($hitzarmena)
    {
        $this->hitzarmena = $hitzarmena;

        return $this;
    }

    /**
     * Get hitzarmena
     *
     * @return boolean
     */
    public function getHitzarmena()
    {
        return $this->hitzarmena;
    }

    /**
     * Set kontsultak
     *
     * @param integer $kontsultak
     *
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
     *
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
     *
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
     *
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
     * Set jarraibideakeu
     *
     * @param string $jarraibideakeu
     *
     * @return Fitxa
     */
    public function setJarraibideakeu($jarraibideakeu)
    {
        $this->jarraibideakeu = $jarraibideakeu;

        return $this;
    }

    /**
     * Get jarraibideakeu
     *
     * @return string
     */
    public function getJarraibideakeu()
    {
        return $this->jarraibideakeu;
    }

    /**
     * Set jarraibideakes
     *
     * @param string $jarraibideakes
     *
     * @return Fitxa
     */
    public function setJarraibideakes($jarraibideakes)
    {
        $this->jarraibideakes = $jarraibideakes;

        return $this;
    }

    /**
     * Get jarraibideakes
     *
     * @return string
     */
    public function getJarraibideakes()
    {
        return $this->jarraibideakes;
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
     * Set besteak2eu
     *
     * @param string $besteak2eu
     *
     * @return Fitxa
     */
    public function setBesteak2eu($besteak2eu)
    {
        $this->besteak2eu = $besteak2eu;

        return $this;
    }

    /**
     * Get besteak2eu
     *
     * @return string
     */
    public function getBesteak2eu()
    {
        return $this->besteak2eu;
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

    /**
     * Set kanalaeu
     *
     * @param string $kanalaeu
     *
     * @return Fitxa
     */
    public function setKanalaeu($kanalaeu)
    {
        $this->kanalaeu = $kanalaeu;

        return $this;
    }

    /**
     * Get kanalaeu
     *
     * @return string
     */
    public function getKanalaeu()
    {
        return $this->kanalaeu;
    }

    /**
     * Set kanalaes
     *
     * @param string $kanalaes
     *
     * @return Fitxa
     */
    public function setKanalaes($kanalaes)
    {
        $this->kanalaes = $kanalaes;

        return $this;
    }

    /**
     * Get kanalaes
     *
     * @return string
     */
    public function getKanalaes()
    {
        return $this->kanalaes;
    }

    /**
     * Set udala
     *
     * @param Udala $udala
     *
     * @return Fitxa
     */
    public function setUdala(Udala $udala = null)
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
     * Set norkebatzi
     *
     * @param Norkebatzi $norkebatzi
     *
     * @return Fitxa
     */
    public function setNorkebatzi(Norkebatzi $norkebatzi = null)
    {
        $this->norkebatzi = $norkebatzi;

        return $this;
    }

    /**
     * Get norkebatzi
     *
     * @return Norkebatzi
     */
    public function getNorkebatzi()
    {
        return $this->norkebatzi;
    }

    /**
     * Set zerbitzua
     *
     * @param Zerbitzua $zerbitzua
     *
     * @return Fitxa
     */
    public function setZerbitzua(Zerbitzua $zerbitzua = null)
    {
        $this->zerbitzua = $zerbitzua;

        return $this;
    }

    /**
     * Get zerbitzua
     *
     * @return Zerbitzua
     */
    public function getZerbitzua()
    {
        return $this->zerbitzua;
    }

    /**
     * Set datuenbabesa
     *
     * @param Datuenbabesa $datuenbabesa
     *
     * @return Fitxa
     */
    public function setDatuenbabesa(Datuenbabesa $datuenbabesa = null)
    {
        $this->datuenbabesa = $datuenbabesa;

        return $this;
    }

    /**
     * Get datuenbabesa
     *
     * @return Datuenbabesa
     */
    public function getDatuenbabesa()
    {
        return $this->datuenbabesa;
    }

    /**
     * Set azpisaila
     *
     * @param Azpisaila $azpisaila
     *
     * @return Fitxa
     */
    public function setAzpisaila(Azpisaila $azpisaila = null)
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

    /**
     * Set aurreikusi
     *
     * @param Aurreikusi $aurreikusi
     *
     * @return Fitxa
     */
    public function setAurreikusi(Aurreikusi $aurreikusi = null)
    {
        $this->aurreikusi = $aurreikusi;

        return $this;
    }

    /**
     * Get aurreikusi
     *
     * @return Aurreikusi
     */
    public function getAurreikusi()
    {
        return $this->aurreikusi;
    }

    /**
     * Set arrunta
     *
     * @param Arrunta $arrunta
     *
     * @return Fitxa
     */
    public function setArrunta(Arrunta $arrunta = null)
    {
        $this->arrunta = $arrunta;

        return $this;
    }

    /**
     * Get arrunta
     *
     * @return Arrunta
     */
    public function getArrunta()
    {
        return $this->arrunta;
    }

    /**
     * Set isiltasunadmin
     *
     * @param IsiltasunAdministratiboa $isiltasunadmin
     *
     * @return Fitxa
     */
    public function setIsiltasunadmin(IsiltasunAdministratiboa $isiltasunadmin = null)
    {
        $this->isiltasunadmin = $isiltasunadmin;

        return $this;
    }

    /**
     * Get isiltasunadmin
     *
     * @return IsiltasunAdministratiboa
     */
    public function getIsiltasunadmin()
    {
        return $this->isiltasunadmin;
    }

    /**
     * Add dokumentazioak
     *
     * @param Dokumentazioa $dokumentazioak
     *
     * @return Fitxa
     */
    public function addDokumentazioak(Dokumentazioa $dokumentazioak)
    {
        $this->dokumentazioak[] = $dokumentazioak;

        return $this;
    }

    /**
     * Remove dokumentazioak
     *
     * @param Dokumentazioa $dokumentazioak
     */
    public function removeDokumentazioak(Dokumentazioa $dokumentazioak)
    {
        $this->dokumentazioak->removeElement($dokumentazioak);
    }

    /**
     * Get dokumentazioak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDokumentazioak()
    {
        return $this->dokumentazioak;
    }

    /**
     * Add kanalak
     *
     * @param Kanala $kanalak
     *
     * @return Fitxa
     */
    public function addKanalak(Kanala $kanalak)
    {
        $this->kanalak[] = $kanalak;

        return $this;
    }

    /**
     * Remove kanalak
     *
     * @param Kanala $kanalak
     */
    public function removeKanalak(Kanala $kanalak)
    {
        $this->kanalak->removeElement($kanalak);
    }

    /**
     * Get kanalak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKanalak()
    {
        return $this->kanalak;
    }

    /**
     * Add besteak1ak
     *
     * @param Besteak1 $besteak1ak
     *
     * @return Fitxa
     */
    public function addBesteak1ak(Besteak1 $besteak1ak)
    {
        $this->besteak1ak[] = $besteak1ak;

        return $this;
    }

    /**
     * Remove besteak1ak
     *
     * @param Besteak1 $besteak1ak
     */
    public function removeBesteak1ak(Besteak1 $besteak1ak)
    {
        $this->besteak1ak->removeElement($besteak1ak);
    }

    /**
     * Get besteak1ak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBesteak1ak()
    {
        return $this->besteak1ak;
    }

    /**
     * Add besteak2ak
     *
     * @param Besteak2 $besteak2ak
     *
     * @return Fitxa
     */
    public function addBesteak2ak(Besteak2 $besteak2ak)
    {
        $this->besteak2ak[] = $besteak2ak;

        return $this;
    }

    /**
     * Remove besteak2ak
     *
     * @param Besteak2 $besteak2ak
     */
    public function removeBesteak2ak(Besteak2 $besteak2ak)
    {
        $this->besteak2ak->removeElement($besteak2ak);
    }

    /**
     * Get besteak2ak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBesteak2ak()
    {
        return $this->besteak2ak;
    }

    /**
     * Add besteak3ak
     *
     * @param Besteak3 $besteak3ak
     *
     * @return Fitxa
     */
    public function addBesteak3ak(Besteak3 $besteak3ak)
    {
        $this->besteak3ak[] = $besteak3ak;

        return $this;
    }

    /**
     * Remove besteak3ak
     *
     * @param Besteak3 $besteak3ak
     */
    public function removeBesteak3ak(Besteak3 $besteak3ak)
    {
        $this->besteak3ak->removeElement($besteak3ak);
    }

    /**
     * Get besteak3ak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBesteak3ak()
    {
        return $this->besteak3ak;
    }

    /**
     * Add etiketak
     *
     * @param Etiketa $etiketak
     *
     * @return Fitxa
     */
    public function addEtiketak(Etiketa $etiketak)
    {
        $this->etiketak[] = $etiketak;

        return $this;
    }

    /**
     * Remove etiketak
     *
     * @param Etiketa $etiketak
     */
    public function removeEtiketak(Etiketa $etiketak)
    {
        $this->etiketak->removeElement($etiketak);
    }

    /**
     * Get etiketak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtiketak()
    {
        return $this->etiketak;
    }

    /**
     * Add norkeskatuak
     *
     * @param Norkeskatu $norkeskatuak
     *
     * @return Fitxa
     */
    public function addNorkeskatuak(Norkeskatu $norkeskatuak)
    {
        $this->norkeskatuak[] = $norkeskatuak;

        return $this;
    }

    /**
     * Remove norkeskatuak
     *
     * @param Norkeskatu $norkeskatuak
     */
    public function removeNorkeskatuak(Norkeskatu $norkeskatuak)
    {
        $this->norkeskatuak->removeElement($norkeskatuak);
    }

    /**
     * Get norkeskatuak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNorkeskatuak()
    {
        return $this->norkeskatuak;
    }

    /**
     * Add doklagunak
     *
     * @param Doklagun $doklagunak
     *
     * @return Fitxa
     */
    public function addDoklagunak(Doklagun $doklagunak)
    {
        $this->doklagunak[] = $doklagunak;

        return $this;
    }

    /**
     * Remove doklagunak
     *
     * @param Doklagun $doklagunak
     */
    public function removeDoklagunak(Doklagun $doklagunak)
    {
        $this->doklagunak->removeElement($doklagunak);
    }

    /**
     * Get doklagunak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDoklagunak()
    {
        return $this->doklagunak;
    }

    /**
     * Add azpiatalak
     *
     * @param Azpiatala $azpiatalak
     *
     * @return Fitxa
     */
    public function addAzpiatalak(Azpiatala $azpiatalak)
    {
        $this->azpiatalak[] = $azpiatalak;

        return $this;
    }

    /**
     * Remove azpiatalak
     *
     * @param Azpiatala $azpiatalak
     */
    public function removeAzpiatalak(Azpiatala $azpiatalak)
    {
        $this->azpiatalak->removeElement($azpiatalak);
    }

    /**
     * Get azpiatalak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAzpiatalak()
    {
        return $this->azpiatalak;
    }

    /**
     * Add fitxafamilium
     *
     * @param Fitxafamilia $fitxafamilium
     *
     * @return Fitxa
     */
    public function addFitxafamilium(Fitxafamilia $fitxafamilium)
    {
        $this->fitxafamilia[] = $fitxafamilium;

        return $this;
    }

    /**
     * Remove fitxafamilium
     *
     * @param Fitxafamilia $fitxafamilium
     */
    public function removeFitxafamilium(Fitxafamilia $fitxafamilium)
    {
        $this->fitxafamilia->removeElement($fitxafamilium);
    }

    /**
     * Get fitxafamilia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFitxafamilia()
    {
        return $this->fitxafamilia;
    }

    /**
     * Add prozedurak
     *
     * @param FitxaProzedura $prozedurak
     *
     * @return Fitxa
     */
    public function addProzedurak(FitxaProzedura $prozedurak)
    {
        $this->prozedurak[] = $prozedurak;

        return $this;
    }

    /**
     * Remove prozedurak
     *
     * @param FitxaProzedura $prozedurak
     */
    public function removeProzedurak(FitxaProzedura $prozedurak)
    {
        $this->prozedurak->removeElement($prozedurak);
    }

    /**
     * Get prozedurak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProzedurak()
    {
        return $this->prozedurak;
    }

    /**
     * Add araudiak
     *
     * @param FitxaAraudia $araudiak
     *
     * @return Fitxa
     */
    public function addAraudiak(FitxaAraudia $araudiak)
    {
        $this->araudiak[] = $araudiak;

        return $this;
    }

    /**
     * Remove araudiak
     *
     * @param FitxaAraudia $araudiak
     */
    public function removeAraudiak(FitxaAraudia $araudiak)
    {
        $this->araudiak->removeElement($araudiak);
    }

    /**
     * Get araudiak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAraudiak()
    {
        return $this->araudiak;
    }

    /**
     * Add kostuak
     *
     * @param FitxaKostua $kostuak
     *
     * @return Fitxa
     */
    public function addKostuak(FitxaKostua $kostuak)
    {
        $this->kostuak[] = $kostuak;

        return $this;
    }

    /**
     * Remove kostuak
     *
     * @param FitxaKostua $kostuak
     */
    public function removeKostuak(FitxaKostua $kostuak)
    {
        $this->kostuak->removeElement($kostuak);
    }

    /**
     * Get kostuak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKostuak()
    {
        return $this->kostuak;
    }

    /**
     * Set expedientes
     *
     * @param string $expedientes
     *
     * @return Fitxa
     */
    public function setExpedientes($expedientes)
    {
        $this->expedientes = $expedientes;

        return $this;
    }

    /**
     * Get expedientes
     *
     * @return string
     */
    public function getExpedientes()
    {
        return $this->expedientes;
    }

    /**
     * Set origenid
     *
     * @param integer $origenid
     *
     * @return Fitxa
     */
    public function setOrigenid($origenid)
    {
        $this->origenid = $origenid;

        return $this;
    }

    /**
     * Get origenid
     *
     * @return integer
     */
    public function getOrigenid()
    {
        return $this->origenid;
    }
}
