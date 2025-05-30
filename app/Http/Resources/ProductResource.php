<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
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

        'id'=>$this->id,
        'title'=>$this->title,
        'description'=>$this ->description,
        'price'=>$this->price,
        'quantity'=>$this->quantity,
        'status'=>$this->status,
        'updated_at'=> $this->updated_at,
        'created_at'=>$this->created_at,
        'product_images'=>$this->whenLoaded(
            'product_images',function()
            {
                return ProductImageResource::collection($this->product_images);
            }
        ),
        'category_id'=>$this->category_id,
        'category'=>new CategoryResource($this->whenLoaded('category')),
        'brand_id'=>$this->brand_id,
        'brand'=>new BrandResource($this->whenLoaded('brand')),
    ];
    }
}
