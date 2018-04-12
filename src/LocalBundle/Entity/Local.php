<?php

namespace LocalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Local
 *
 * @ORM\Table(name="local", indexes={@ORM\Index(name="prop", columns={"prop"}), @ORM\Index(name="prop_2", columns={"prop"}), @ORM\Index(name="prop_3", columns={"prop"}), @ORM\Index(name="prop_4", columns={"prop"})})
 * @ORM\Entity
 */
class Local
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_local", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idLocal;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=50, nullable=false)
     */
    public $description;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_local", type="string", length=10, nullable=false)
     */
    public $nomLocal;

    /**
     * @var float
     *
     * @ORM\Column(name="superficie", type="float", precision=10, scale=0, nullable=false)
     */
    public $superficie;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=20, nullable=false)
     */
    public $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="imgl1", type="string", length=10, nullable=true)
     */
    private $imgl1;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float", precision=10, scale=0, nullable=false)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lang", type="float", precision=10, scale=0, nullable=false)
     */
    private $lang;




    /**
     * Many Features have One Modele.
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     * @ORM\JoinColumn(name="prop", referencedColumnName="id")
     */
    private $prop;

    /**
     * @return mixed
     */
    public function getProp()
    {
        return $this->prop;
    }

    /**
     * @param mixed $prop
     */
    public function setProp($prop)
    {
        $this->prop = $prop;
    }







    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getNomLocal()
    {
        return $this->nomLocal;
    }

    /**
     * @param string $nomLocal
     */
    public function setNomLocal($nomLocal)
    {
        $this->nomLocal = $nomLocal;
    }

    /**
     * @return float
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * @param float $superficie
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;
    }

    /**
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param string $localisation
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
    }

    /**
     * @return string
     */
    public function getImgl1()
    {
        return $this->imgl1;
    }

    /**
     * @param string $imgl1
     */
    public function setImgl1($imgl1)
    {
        $this->imgl1 = $imgl1;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param float $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    function __toString()
    {
        return (string) $this->nomLocal;
    }
}

