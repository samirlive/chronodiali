<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReferenceOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferenceOrderRepository::class)]
#[ApiResource]
class ReferenceOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $merchant_order_number;

    #[ORM\OneToOne(mappedBy: 'reference', targetEntity: Data::class, cascade: ['persist', 'remove'])]
    private $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMerchantOrderNumber(): ?string
    {
        return $this->merchant_order_number;
    }

    public function setMerchantOrderNumber(?string $merchant_order_number): self
    {
        $this->merchant_order_number = $merchant_order_number;

        return $this;
    }

    public function getData(): ?Data
    {
        return $this->data;
    }

    public function setData(?Data $data): self
    {
        // unset the owning side of the relation if necessary
        if ($data === null && $this->data !== null) {
            $this->data->setReference(null);
        }

        // set the owning side of the relation if necessary
        if ($data !== null && $data->getReference() !== $this) {
            $data->setReference($this);
        }

        $this->data = $data;

        return $this;
    }
}
