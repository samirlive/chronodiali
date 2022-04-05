<?php

namespace App\Entity;

use App\Repository\DataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataRepository::class)]
class Data
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $service_type;

    #[ORM\Column(type: 'string', length: 255)]
    public $service_level;

    #[ORM\Column(type: 'string', length: 255)]
    public $requested_tracking_number;

    #[ORM\OneToOne(inversedBy: 'data', targetEntity: ReferenceOrder::class, cascade: ['persist', 'remove'])]
    public $reference;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'data')]
    #[ORM\JoinColumn(nullable: false)]
    public $from;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'dataTo')]
    #[ORM\JoinColumn(nullable: false)]
    public $to;

    #[ORM\OneToOne(inversedBy: 'data', targetEntity: ParcelJob::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    public $parcel_job;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceType(): ?string
    {
        return $this->service_type;
    }

    public function setServiceType(string $service_type): self
    {
        $this->service_type = $service_type;

        return $this;
    }

    public function getServiceLevel(): ?string
    {
        return $this->service_level;
    }

    public function setServiceLevel(string $service_level): self
    {
        $this->service_level = $service_level;

        return $this;
    }

    public function getRequestedTrackingNumber(): ?string
    {
        return $this->requested_tracking_number;
    }

    public function setRequestedTrackingNumber(string $requested_tracking_number): self
    {
        $this->requested_tracking_number = $requested_tracking_number;

        return $this;
    }

    public function getReference(): ?ReferenceOrder
    {
        return $this->reference;
    }

    public function setReference(?ReferenceOrder $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getFrom(): ?Customer
    {
        return $this->from;
    }

    public function setFrom(?Customer $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getTo(): ?Customer
    {
        return $this->to;
    }

    public function setTo(?Customer $to): self
    {
        $this->to = $to;

        return $this;
    }

    public function getParcelJob(): ?ParcelJob
    {
        return $this->parcel_job;
    }

    public function setParcelJob(ParcelJob $parcel_job): self
    {
        $this->parcel_job = $parcel_job;

        return $this;
    }

}
