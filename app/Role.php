<?php

namespace App;

use App\Transformers\RoleTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = RoleTransformer::class;
    
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
