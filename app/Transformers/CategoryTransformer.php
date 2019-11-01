<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'ide' => (int)$category->id,
            'nombre' => (string)$category->name,
            'desc' => (string)$category->description,
            'imagen' => (string)$category->img,
            'estado' => ($category->status === 'true'),
            'creadoPor' => (string)$category->created_at,
            'actualizado' => (string)$category->updated_at,
            'eliminado' => isset($category->deleted_at) ? (string)$category->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show', $category->id),
                ],
                [
                    'rel' => 'categories.clients',
                    'href' => route('categories.clients.index', $category->id),
                ],
                [
                    'rel' => 'categories.subcategory',
                    'href' => route('categories.subcategories.index', $category->id),
                ],
                [
                    'rel' => 'categories.product',
                    'href' => route('categories.products.index', $category->id),
                ]
            ]
        ];
    }

    public static function originalAttr($index) {
        $attributes = [
            'ide' => 'id',
            'nombre' => 'name',
            'desc' => 'description',
            'imagen' => 'img',
            'estado' => 'status',
            'creadoPor' => 'created_at',
            'actualizado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttr($index) {
        $attributes = [
            'id' => 'ide',
            'name' => 'nombre',
            'description' => 'desc',
            'img' => 'imagen',
            'status' => 'estado',
            'created_at' => 'creadoPor',
            'updated_at' => 'actualizado',
            'deleted_at' => 'eliminado',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
