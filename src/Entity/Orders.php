<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $userSurname;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderPosition", mappedBy="orders")
     */
    private $orderPosition;

    public function __construct()
    {
        $this->orderPosition = new ArrayCollection();
        $this->created_at = new \DateTime() ? new \DateTime() : 'NEW';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserSurname(): ?string
    {
        return $this->userSurname;
    }

    public function setUserSurname(string $userSurname): self
    {
        $this->userSurname = $userSurname;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|OrderPosition[]
     */
    public function getOrderPosition(): Collection
    {
        return $this->orderPosition;
    }

    public function addOrderPosition(OrderPosition $orderPosition): self
    {
        if (!$this->orderPosition->contains($orderPosition)) {
            $this->orderPosition[] = $orderPosition;
            $orderPosition->setOrders($this);
        }

        return $this;
    }

    public function removeOrderPosition(OrderPosition $orderPosition): self
    {
        if ($this->orderPosition->contains($orderPosition)) {
            $this->orderPosition->removeElement($orderPosition);
            // set the owning side to null (unless already changed)
            if ($orderPosition->getOrders() === $this) {
                $orderPosition->setOrders(null);
            }
        }

        return $this;
    }
}
