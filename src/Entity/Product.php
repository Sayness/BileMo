<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @OA\Schema
 * @Hateoas\Relation("self", href = "expr('/product/' ~ object.getId())"
 * , exclusion = @Hateoas\Exclusion(groups={"product:read"}))
 * @Hateoas\Relation("list", href = "expr('/products/",
 *  exclusion = @Hateoas\Exclusion(groups={"product:read"}))
 */


class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"customer:read"})
     * @OA\Property(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"product:read"})
     * @OA\Property(type="string",nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=555, nullable=true)
     * @Serializer\Groups({"product:read"})
     * @OA\Property(type="string",nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     *@Serializer\Groups({"product:read"})
     *@OA\Property(type="float",nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *@Serializer\Groups({"product:read"})
     *@OA\Property(type="datetime",nullable=true)
     */
    private $created_at;



 



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

 

}
