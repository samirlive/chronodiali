<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $item_description;

    #[ORM\Column(type: 'integer')]
    public $quantity;

    #[ORM\Column(type: 'boolean')]
    public $is_dangerous_good;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemDescription(): ?string
    {
        return $this->item_description;
    }

    public function setItemDescription(string $item_description): self
    {
        $this->item_description = $item_description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getIsDangerousGood(): ?bool
    {
        return $this->is_dangerous_good;
    }

    public function setIsDangerousGood(bool $is_dangerous_good): self
    {
        $this->is_dangerous_good = $is_dangerous_good;

        return $this;
    }
}
