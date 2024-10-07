<?php

namespace App\DTO\Contract;

use Symfony\Component\Validator\Constraints as Assert;

class ProductDTO extends BaseDTO
{
    #[Assert\NotBlank(message: 'product.code.not_blank')]
    private ?string $code;

    #[Assert\NotBlank(message: 'product.name.not_blank')]
    #[Assert\Length(min: 2, max: 255, minMessage: 'product.name.length.min', maxMessage: 'product.name.length.max')]
    private ?string $name;

    #[Assert\Length(max: 1000, maxMessage: 'product.description.length_max')]
    private ?string $description;

    #[Assert\Url(message: 'product.image.url')]
    private ?string $image;

    #[Assert\NotBlank(message: 'product.category.not_blank')]
    private ?string $category;

    #[Assert\NotNull(message: 'product.price.not_null')]
    #[Assert\Positive(message: 'product.price.positive')]
    private ?float $price;

    #[Assert\NotNull(message: 'product.quantity.not_null')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'product.quantity.gte')]
    private ?int $quantity;

    #[Assert\Length(min: 4, max: 20, minMessage: 'product.internal_reference.length.min', maxMessage: 'product.internal_reference.length.max')]
    private ?string $internalReference;

    #[Assert\NotNull(message: 'product.shell_id.not_null')]
    #[Assert\Positive(message: 'product.shell_id.positive')]
    private ?int $shellId;

    #[Assert\Choice(choices: ['INSTOCK', 'LOWSTOCK', 'OUTOFSTOCK'], message: 'product.inventory_status.choice')]
    private ?string $inventoryStatus;

    #[Assert\NotNull(message: 'product.rating.not_null')]
    #[Assert\Range(notInRangeMessage: 'product.rating.range', min: 1, max: 5)]
    private ?int $rating;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string|null
     */
    public function getInternalReference(): ?string
    {
        return $this->internalReference;
    }

    /**
     * @param string|null $internalReference
     */
    public function setInternalReference(?string $internalReference): void
    {
        $this->internalReference = $internalReference;
    }

    /**
     * @return int|null
     */
    public function getShellId(): ?int
    {
        return $this->shellId;
    }

    /**
     * @param int|null $shellId
     */
    public function setShellId(?int $shellId): void
    {
        $this->shellId = $shellId;
    }

    /**
     * @return string|null
     */
    public function getInventoryStatus(): ?string
    {
        return $this->inventoryStatus;
    }

    /**
     * @param string|null $inventoryStatus
     */
    public function setInventoryStatus(?string $inventoryStatus): void
    {
        $this->inventoryStatus = $inventoryStatus;
    }

    /**
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @param int|null $rating
     */
    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }


}
