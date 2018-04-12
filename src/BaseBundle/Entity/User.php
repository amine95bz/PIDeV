<?php

namespace BaseBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Model\UserNotificationInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 */
class User extends BaseUser implements UserNotificationInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $photo;



    /**
     * @ORM\OneToMany(targetEntity="BaseBundle\Entity\User",mappedBy="user",cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;
    /**
     * @ORM\OneToMany(targetEntity="CommandeBundle\Entity\UserAdress", mappedBy="user", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adress;

    /**
     * @var Notification
     * @ORM\OneToMany(targetEntity="BaseBundle\Entity\Notification", mappedBy="user", orphanRemoval=true ,cascade={"persist"})
     */
    protected $notifications;

    public function __construct()
    {
        parent::__construct();
        $this->notifications = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function addNotification($notification)
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeNotification($notification)
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        $this->getId();
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }



    /** Add commandes
     *
     * @param \CommandeBundle\Entity\Commandes $commandes
     * @return User
     */
    public function addCommande(\CommandeBundle\Entity\Commandes $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes
     *
     * @param \CommandeBundle\Entity\Commandes $commandes
     */
    public function removeCommande(\CommandeBundle\Entity\Commandes $commandes)
    {
        $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add adress
     *
     * @param \CommandeBundle\Entity\UserAdress $adress
     * @return User
     */
    public function addAdress(\CommandeBundle\Entity\UserAdress $adress)
    {
        $this->adress[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \CommandeBundle\Entity\UserAdress $adress
     */
    public function removeAdress(\CommandeBundle\Entity\UserAdress $adress)
    {
        $this->adress->removeElement($adress);
    }

    /**
     * Get adress
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdress()
    {
        return $this->adress;
    }
}
