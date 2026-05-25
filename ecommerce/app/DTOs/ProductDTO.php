<?php
namespace App\DTOs;

class ProductDTO
{
    public function __construct(
        public readonly string  $name,
        public readonly int     $categoryId,
        public readonly float   $price,
        public readonly int     $quantity,
        public readonly string  $status        = 'draft',
        public readonly ?string $description   = null,
        public readonly ?string $shortDescription = null,
        public readonly ?string $sku           = null,
        public readonly ?float  $discountPrice = null,
        public readonly ?int    $brandId       = null,
        public readonly bool    $isFeatured    = false,
        public readonly ?string $metaTitle     = null,
        public readonly ?string $metaDescription = null,
        public readonly ?array  $tags          = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name:             $data['name'],
            categoryId:       (int) $data['category_id'],
            price:            (float) $data['price'],
            quantity:         (int) $data['quantity'],
            status:           $data['status'] ?? 'draft',
            description:      $data['description'] ?? null,
            shortDescription: $data['short_description'] ?? null,
            sku:              $data['sku'] ?? null,
            discountPrice:    isset($data['discount_price']) ? (float) $data['discount_price'] : null,
            brandId:          isset($data['brand_id']) ? (int) $data['brand_id'] : null,
            isFeatured:       (bool) ($data['is_featured'] ?? false),
            metaTitle:        $data['meta_title'] ?? null,
            metaDescription:  $data['meta_description'] ?? null,
            tags:             isset($data['tags']) ? explode(',', $data['tags']) : null,
        );
    }
}
