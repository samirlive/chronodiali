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
    public $is_pickup_required;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $pickup_service_type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $pickup_service_level;

    #[ORM\Column(type: 'integer', nullable: true)]
    public $pickup_address_id;

    #[ORM\Column(type: 'string', nullable: true)]
    public $pickup_date;

    #[ORM\Column(type: 'string', nullable: true)]
    public $delivery_start_date;

    #[ORM\Column(type: 'text', nullable: true)]
    public $delivery_instructions;

    #[ORM\Column(type: 'float')]
    private $weight;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $size;

    #[ORM\OneToOne(mappedBy: 'parcel_job', targetEntity: Data::class, cascade: ['persist', 'remove'])]
    private $data;

    #[ORM\OneToOne(mappedBy: 'parcel_job', targetEntity: PickupTimeslot::class, cascade: ['persist', 'remove'])]
    public $pickup_timeslot;

    #[ORM\Column(type: 'string', length: 255)]
    public $pickup_instructions;

    #[ORM\OneToOne(inversedBy: 'parcelJob', targetEntity: DeliveryTimeslot::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    public $delivery_timeslot;

    #[ORM\OneToOne(inversedBy: 'parcelJob', targetEntity: Dimension::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    public $dimensions;

    #[ORM\Column(type: 'array')]
    public $items = [];

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

    public function getPickupDate(): ?string 
    {
        return $this->pickup_date;
    }

    public function setPickupDate(?string  $pickup_date): self
    {
        $this->pickup_date = $pickup_date;

        return $this;
    }

    public function getDeliveryStartDate(): ?string 
    {
        return $this->delivery_start_date;
    }

    public function setDeliveryStartDate(?string  $delivery_start_date): self
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

    public function getData(): ?Data
    {
        return $this->data;
    }

    public function setData(Data $data): self
    {
        // set the owning side of the relation if necessary
        if ($data->getParcelJob() !== $this) {
            $data->setParcelJob($this);
        }

        $this->data = $data;

        return $this;
    }

    public function getPickupTimeslot(): ?PickupTimeslot
    {
        return $this->pickup_timeslot;
    }

    public function setPickupTimeslot(PickupTimeslot $pickup_timeslot): self
    {
        $this->pickup_timeslot = $pickup_timeslot;

        return $this;
    }

    public function getPickupInstructions(): ?string
    {
        return $this->pickup_instructions;
    }

    public function setPickupInstructions(string $pickup_instructions): self
    {
        $this->pickup_instructions = $pickup_instructions;

        return $this;
    }

    public function getDeliveryTimeslot(): ?DeliveryTimeslot
    {
        return $this->delivery_timeslot;
    }

    public function setDeliveryTimeslot($delivery_timeslot): self
    {
        $this->delivery_timeslot = $delivery_timeslot;

        return $this;
    }

    public function getDimensions(): ?Dimension
    {
        return $this->dimensions;
    }

    public function setDimensions(Dimension $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
