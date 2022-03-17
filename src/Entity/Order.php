<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $createdAt;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;



    #[ORM\OneToOne(targetEntity: Customer::class, cascade: ['persist', 'remove'])]
    private $toRecipient;

    #[ORM\OneToOne(targetEntity: Customer::class, cascade: ['persist', 'remove'])]
    private $fromExpediter;

    #[ORM\OneToOne(targetEntity: ReferenceOrder::class, cascade: ['persist', 'remove'])]
    private $reference;

    #[ORM\OneToOne(targetEntity: ParcelJob::class, cascade: ['persist', 'remove'])]
    private $parcel_job;

    #[ORM\Column(type: 'text', nullable: true)]
    private $restApiQuery;

    #[ORM\Column(type: 'text', nullable: true)]
    private $graphqlApiQuery;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $service_type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $service_level;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $requested_tracking_number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->fromExpediter = new Customer();
        $this->toRecipient = new Customer();
        $this->parcel_job = new ParcelJob();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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


    public function getToRecipient(): ?Customer
    {
        return $this->toRecipient;
    }

    public function setToRecipient(?Customer $toRecipient): self
    {
        $this->toRecipient = $toRecipient;

        return $this;
    }

    public function getFromExpediter(): ?Customer
    {
        return $this->fromExpediter;
    }

    public function setFromExpediter(?Customer $fromExpediter): self
    {
        $this->fromExpediter = $fromExpediter;

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

    public function getParcelJob(): ?ParcelJob
    {
        return $this->parcel_job;
    }

    public function setParcelJob(?ParcelJob $parcel_job): self
    {
        $this->parcel_job = $parcel_job;

        return $this;
    }

    public function getRestApiQuery(): ?string
    {
        return $this->restApiQuery;
    }

    public function setRestApiQuery(?string $restApiQuery): self
    {
        $this->restApiQuery = $restApiQuery;

        return $this;
    }

    public function getGraphqlApiQuery(): ?string
    {
        return $this->graphqlApiQuery;
    }

    public function setGraphqlApiQuery(?string $graphqlApiQuery): self
    {
        $this->graphqlApiQuery = $graphqlApiQuery;

        return $this;
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

    public function setRequestedTrackingNumber(?string $requested_tracking_number): self
    {
        $this->requested_tracking_number = $requested_tracking_number;

        return $this;
    }
}
