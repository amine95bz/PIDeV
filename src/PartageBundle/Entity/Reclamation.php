<?php

namespace PartageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity(repositoryClass="PartageBundle\Repository\ReclamationRepository")
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Reclameur", type="string", length=255)
     */
    private $reclameur;

    /**
     * @var string
     *
     * @ORM\Column(name="Reclamee", type="string", length=255)
     */
    private $reclamee;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reclameur
     *
     * @param string $reclameur
     *
     * @return Reclamation
     */
    public function setReclameur($reclameur)
    {
        $this->reclameur = $reclameur;

        return $this;
    }

    /**
     * Get reclameur
     *
     * @return string
     */
    public function getReclameur()
    {
        return $this->reclameur;
    }

    /**
     * Set reclamee
     *
     * @param string $reclamee
     *
     * @return Reclamation
     */
    public function setReclamee($reclamee)
    {
        $this->reclamee = $reclamee;

        return $this;
    }

    /**
     * Get reclamee
     *
     * @return string
     */
    public function getReclamee()
    {
        return $this->reclamee;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Reclamation
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reclamation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

