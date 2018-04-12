<?php

namespace LocalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce", indexes={@ORM\Index(name="id_prop", columns={"id_prop"}), @ORM\Index(name="id_local", columns={"id_local"})})
 * @ORM\Entity
 */
class Annonce
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="date", nullable=true)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="date", nullable=true)
     */
    private $enddate;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=50, nullable=false)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;




    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insertdate", type="date", nullable=true)
     */
    private $insertdate;

    /**
     * Many Features have One Modele.
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     * @ORM\JoinColumn(name="id_prop", referencedColumnName="id")
     */
    private $id_prop;


    /**
     * Many Features have One Modele.
     * @ORM\ManyToOne(targetEntity="LocalBundle\Entity\Local")
     * @ORM\JoinColumn(name="id_local", referencedColumnName="id_local")
     */
    private $id_local;

    /**
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * @param \DateTime $startdate
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
    }

    /**
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * @param \DateTime $enddate
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getIdProp()
    {
        return $this->id_prop;
    }

    /**
     * @param mixed $id_prop
     */
    public function setIdProp($id_prop)
    {
        $this->id_prop = $id_prop;
    }

    /**
     * @return mixed
     */
    public function getIdLocal()
    {
        return $this->id_local;
    }

    /**
     * @param mixed $id_local
     */
    public function setIdLocal($id_local)
    {
        $this->id_local = $id_local;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getInsertdate()
    {
        return $this->insertdate;
    }

    /**
     * @param \DateTime $insertdate
     */
    public function setInsertdate($insertdate)
    {
        $this->insertdate = $insertdate;
    }




}

