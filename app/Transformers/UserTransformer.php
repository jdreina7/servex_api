<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int)$user->id,
            'role_id' => (int)$user->role_id,
            'nombre' => (string)$user->name,
            'apellido' => (string)$user->surname,
            'correo' => (string)$user->email,
            'status' => ($user->status === 'true'),
            'created_by' => (string)$user->created_by,
            'created_at' => (string)$user->created_at,
            'updated_at' => (string)$user->updated_at,
            'deleted_at' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
        ];
    }

    public static function originalAttr($index) {
        $attributes = [
            'id' => 'id',
            'role_id' => 'role_id',
            'nombre' => 'name',
            'apellido' => 'surname',
            'correo' => 'email',
            'status' =>'status',
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' =>'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttr($index) {
        $attributes = [
            'id' => 'id',
            'role_id' => 'role_id',
            'name' => 'nombre',
            'surname' => 'apellido',
            'email' => 'correo',
            'status' =>'status',
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' =>'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
