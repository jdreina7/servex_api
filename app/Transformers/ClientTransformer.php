<?php

namespace App\Transformers;

use App\Client;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Client $client)
    {
        return [
            'id' => (int)$client->id,
            'name' => (string)$client->name,
            'surname' => (string)$client->surname,
            'email' => (string)$client->email,
            'bussiness_name' => (string)$client->bussiness_name,
            'description' => (string)$client->description,
            'status' => ($client->status === 'true'),
            'created_at' => (string)$client->created_at,
            'updated_at' => (string)$client->updated_at,
            'deleted_at' => isset($client->deleted_at) ? (string)$client->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('clients.show', $client->id),
                ],
                [
                    'rel' => 'clients.category',
                    'href' => route('clients.categories.index', $client->id),
                ],
                // [
                //     'rel' => 'clients.subcategory',
                //     'href' => route('clients.subcategories.index', $client->id),
                // ],
                [
                    'rel' => 'clients.product',
                    'href' => route('clients.products.index', $client->id),
                ]
            ]
        ];
    }

    public static function originalAttr($index) {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'surname' => 'surname',
            'email' => 'email',
            'bussiness_name' => 'bussiness_name',
            'description' => 'description',
            'status' => 'status',
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
            'surname' => 'surname',
            'email' => 'email',
            'bussiness_name' => 'bussiness_name',
            'description' => 'description',
            'status' => 'status',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
