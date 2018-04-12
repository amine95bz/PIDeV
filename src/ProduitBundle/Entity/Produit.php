<?php
namespace ProduitBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="nomV", columns={"nomV"}), @ORM\Index(name="nomV_2", columns={"nomV"})})
 *@ORM\Entity(repositoryClass="ProduitBundle\Repository\ProduitRepository")
 *
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ref", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ref;

    /**
     * @return int
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param int $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="nomP", type="string", length=10, nullable=false)
     */
    private $nomp;
    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=false)
     */
    private $img;
    /**
     * @var integer
     *
     * @ORM\Column(name="quantit", type="integer", nullable=false)
     */
    private $quantit = '1';
    /**
     * @var string
     *
     * @ORM\Column(name="descrip", type="string", length=255, nullable=false)
     */
    private $descrip;
    /**
     * @var string
     *
     * @ORM\Column(name="nomV", type="string", length=20, nullable=true)
     */
    private $nomv;
    /**
     * Many Features have One Modele.
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     * @ORM\JoinColumn(name="prop", referencedColumnName="id")
     */
    private $prop;
    /**
     * @return string
     */
    public function getNomp()
    {
        return $this->nomp;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    /**
     * @param string $nomp
     */
    public function setNomp($nomp)
    {
        $this->nomp = $nomp;
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
    public function getImg()
    {
        return $this->img;
    }
    /**
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }
    /**
     * @return int
     */
    public function getQuantit()
    {
        return $this->quantit;
    }
    /**
     * @param int $quantit
     */
    public function setQuantit($quantit)
    {
        $this->quantit = $quantit;
    }
    /**
     * @return string
     */
    public function getDescrip()
    {
        return $this->descrip;
    }
    /**
     * @param string $descrip
     */
    public function setDescrip($descrip)
    {
        $this->descrip = $descrip;
    }
    /**
     * @return string
     */
    public function getNomv()
    {
        return $this->nomv;
    }
    /**
     * @param string $nomv
     */
    public function setNomv($nomv)
    {
        $this->nomv = $nomv;
    }
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
}