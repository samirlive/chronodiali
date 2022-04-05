<?php

namespace App\Entity;

use App\Repository\PickupTimeslotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PickupTimeslotRepository::class)]
class PickupTimeslot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $start_time;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $end_time;

    #[ORM\Column(type: 'string', length: 255)]
    public $timezone;

    #[ORM\OneToOne(inversedBy: 'pickupTimeslot', targetEntity: ParcelJob::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $parcel_job;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?string
    {
        return $this->start_time;
    }

    public function setStartTime(?string $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?string
    {
        return $this->end_time;
    }

    public function setEndTime(?string $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

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
