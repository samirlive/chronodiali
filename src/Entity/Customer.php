<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $phone_number;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $address1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $address2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $country;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $postcode;

    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'customers')]
    public $address;

    #[ORM\OneToMany(mappedBy: 'from', targetEntity: Data::class, orphanRemoval: true)]
    private $data;

    #[ORM\OneToMany(mappedBy: 'to', targetEntity: Data::class, orphanRemoval: true)]
    private $dataTo;


    public function __construct(/*string $name*/)
    {

        $this->country = "MA";
        //$this->name = $name;
        $this->data = new ArrayCollection();
        $this->dataTo = new ArrayCollection(); 
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Data>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(Data $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setFrom($this);
        }

        return $this;
    }

    public function removeData(Data $data): self
    {
        if ($this->data->removeElement($data)) {
            // set the owning side to null (unless already changed)
            if ($data->getFrom() === $this) {
                $data->setFrom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Data>
     */
    public function getDataTo(): Collection
    {
        return $this->dataTo;
    }

    public function addDataTo(Data $dataTo): self
    {
        if (!$this->dataTo->contains($dataTo)) {
            $this->dataTo[] = $dataTo;
            $dataTo->setTo($this);
        }

        return $this;
    }

    public function removeDataTo(Data $dataTo): self
    {
        if ($this->dataTo->removeElement($dataTo)) {
            // set the owning side to null (unless already changed)
            if ($dataTo->getTo() === $this) {
                $dataTo->setTo(null);
            }
        }

        return $this;
    }
}
