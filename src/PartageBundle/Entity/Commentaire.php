<?php

namespace PartageBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Commentaire
 * @ORM\Table(name="Commentaire")
 * @ORM\Entity(repositoryClass="PartageBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="contenu", type="string", length=255)

     */
    private $contenu;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")

     */
    private $date;

    /**
* @var string
     * @param \BaseBundle\Entity\User $user

     * @ORM\Column(name="user", type="string", length=255)
     *
*/
    private $user;
    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }





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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Commentaire
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
     * @return Commentaire
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
    /**
     * Set user
     *
     * @param \BaseBundle\Entity\User $user
     *
     * @return Commentaire
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }







}

