<?php

namespace App\Transformers;

use App\Subcategory;
use League\Fractal\TransformerAbstract;

class SubcategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Subcategory $subcategory)
    {
        return [
            'id' => (int)$subcategory->id,
            'name' => (string)$subcategory->name,
            'description' => (string)$subcategory->description,
            'status' => ($subcategory->status === 'true'),
            'created_by' => (string)$subcategory->created_by,
            'created_at' => (string)$subcategory->created_at,
            'updated_at' => (string)$subcategory->updated_at,
            'deleted_at' => isset($subcategory->deleted_at) ? (string)$subcategory->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('subcategories.show', $subcategory->id),
                ],
                // [
                //     'rel' => 'subcategories.clients',
                //     'href' => route('subcategories.clients.index', $subcategory->id),
                // ],
                [
                    'rel' => 'subcategories.categories',
                    'href' => route('subcategories.categories.index', $subcategory->id),
                ],
                [
                    'rel' => 'subcategories.product',
                    'href' => route('subcategories.products.index', $subcategory->id),
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
            'created_by' => 'created_by',
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
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
