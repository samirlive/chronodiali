<?php

namespace App\Entity;

use App\Repository\DeliveryTimeslotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeliveryTimeslotRepository::class)]
class DeliveryTimeslot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $start_time;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $end_time;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $timezone;

    #[ORM\OneToOne(mappedBy: 'delivery_timeslot', targetEntity: ParcelJob::class, cascade: ['persist', 'remove'])]
    public $parcelJob;


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

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getParcelJob(): ?ParcelJob
    {
        return $this->parcelJob;
    }

    public function setParcelJob(ParcelJob $parcelJob): self
    {
        // set the owning side of the relation if necessary
        if ($parcelJob->getDeliveryTimeslot() !== $this) {
            $parcelJob->setDeliveryTimeslot($this);
        }

        $this->parcelJob = $parcelJob;

        return $this;
    }

    
}
