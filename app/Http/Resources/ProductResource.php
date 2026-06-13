<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => [
                'ar' => $this->getTranslation('name', 'ar'),
                'en' => $this->getTranslation('name', 'en'),
                'current' => $this->name,
            ],
            'slug' => $this->slug,
            'description' => [
                'ar' => $this->getTranslation('description', 'ar'),
                'en' => $this->getTranslation('description', 'en'),
                'current' => $this->description,
            ],
            'details' => [
                'ar' => $this->getTranslation('details', 'ar'),
                'en' => $this->getTranslation('details', 'en'),
                'current' => $this->details,
            ],
            'price' => $this->price,
            'image' => $this->image,
            'in_stock' => $this->in_stock,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
