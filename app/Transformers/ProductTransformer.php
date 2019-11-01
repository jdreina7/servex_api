<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => (int)$product->id,
            'name' => (string)$product->name,
            'description' => (string)$product->description,
            'status' => ($product->status === 'true'),
            'client_id' => (int)$product->client_id,
            'category_id' => (int)$product->category_id,
            'subcategory_id' => (int)$product->subcategory_id,
            'created_at' => (string)$product->created_at,
            'updated_at' => (string)$product->updated_at,
            'deleted_at' => isset($product->deleted_at) ? (string)$product->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $product->id),
                ],
                [
                    'rel' => 'products.category',
                    'href' => route('products.categories.index', $product->id),
                ],
                [
                    'rel' => 'products.subcategory',
                    'href' => route('products.subcategories.index', $product->id),
                ],
                [
                    'rel' => 'products.client',
                    'href' => route('products.clients.index', $product->id),
                ]
            ]
        ];
    }

    public static function originalAttr($index) {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'status' => 'status',
            'client_id' => 'client_id',
            'category_id' => 'category_id',
            'subcategory_id' => 'subcategory_id',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttr($index) {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'status' => 'status',
            'client_id' => 'client_id',
            'category_id' => 'category_id',
            'subcategory_id' => 'subcategory_id',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
