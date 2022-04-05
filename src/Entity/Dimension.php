<?php

namespace App\Entity;

use App\Repository\DimensionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DimensionRepository::class)]
class Dimension
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    public $weight;

    #[ORM\Column(type: 'integer')]
    public $size;

    #[ORM\OneToOne(mappedBy: 'dimension', targetEntity: ParcelJob::class, cascade: ['persist', 'remove'])]
    public $parcelJob;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getParcelJob(): ?ParcelJob
    {
        return $this->parcelJob;
    }

    public function setParcelJob(ParcelJob $parcelJob): self
    {
        // set the owning side of the relation if necessary
        if ($parcelJob->getDimension() !== $this) {
            $parcelJob->setDimension($this);
        }

        $this->parcelJob = $parcelJob;

        return $this;
    }
}
