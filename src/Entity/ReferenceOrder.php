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
    private $merchant_order_number;

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
}
