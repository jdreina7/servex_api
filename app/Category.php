<?php

namespace App;

use App\Product;
use App\Subcategory;
use App\User;
use App\Client;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const ACTIVE = '1';
    const INACTIVE = '0';

    protected $fillable = [
    	'name',
    	'description',
    	'img',
		'status',
		'created_by',
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
        return $this->status == Category::ACTIVE;
    }

    public function subcategories() {
    	return $this->hasMany(Subcategory::class);
    }

    public function products() {
    	return $this->hasMany(Product::class);
    }

    public function clients() {
    	return $this->belongsToMany(Client::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }
}
