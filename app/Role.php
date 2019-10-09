<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ACTIVE = '1';
    const INACTIVE = '0';

    protected $fillable = [
    	'name',
		'status',
		'created_at',
		'updated_at',
    ];

    /**
     * Mutadores y Accesadores
     */
    public function setNameAttr($name) {
        $this->attributes['name'] = strtolower($name);
    }
    
    public function getNameAttr ($name) {
        return ucfirst($name);
    }
    

    public function isActive() {
        return $this->status == Role::ACTIVE;
    }
}
