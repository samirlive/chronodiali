<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ParcelJobRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcelJobRepository::class)]
#[ApiResource]
class ParcelJob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $is_pickup_required;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pickup_service_type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pickup_service_level;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pickup_address_id;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private $pickup_date;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private $delivery_start_date;

    #[ORM\Column(type: 'text', nullable: true)]
    private $delivery_instructions;

    #[ORM\Column(type: 'float')]
    private $weight;

    #[ORM\Column(type: 'string', length: 255)]
    private $size;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsPickupRequired(): ?bool
    {
        return $this->is_pickup_required;
    }

    public function setIsPickupRequired(?bool $is_pickup_required): self
    {
        $this->is_pickup_required = $is_pickup_required;

        return $this;
    }

    public function getPickupServiceType(): ?string
    {
        return $this->pickup_service_type;
    }

    public function setPickupServiceType(?string $pickup_service_type): self
    {
        $this->pickup_service_type = $pickup_service_type;

        return $this;
    }

    public function getPickupServiceLevel(): ?string
    {
        return $this->pickup_service_level;
    }

    public function setPickupServiceLevel(?string $pickup_service_level): self
    {
        $this->pickup_service_level = $pickup_service_level;

        return $this;
    }

    public function getPickupAddressId(): ?int
    {
        return $this->pickup_address_id;
    }

    public function setPickupAddressId(?int $pickup_address_id): self
    {
        $this->pickup_address_id = $pickup_address_id;

        return $this;
    }

    public function getPickupDate(): ?\DateTimeImmutable
    {
        return $this->pickup_date;
    }

    public function setPickupDate(?\DateTimeImmutable $pickup_date): self
    {
        $this->pickup_date = $pickup_date;

        return $this;
    }

    public function getDeliveryStartDate(): ?\DateTimeImmutable
    {
        return $this->delivery_start_date;
    }

    public function setDeliveryStartDate(?\DateTimeImmutable $delivery_start_date): self
    {
        $this->delivery_start_date = $delivery_start_date;

        return $this;
    }

    public function getDeliveryInstructions(): ?string
    {
        return $this->delivery_instructions;
    }

    public function setDeliveryInstructions(?string $delivery_instructions): self
    {
        $this->delivery_instructions = $delivery_instructions;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }
}
