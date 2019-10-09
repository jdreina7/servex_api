<?php

namespace App;

use App\Category;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{
    const ACTIVE = '1';
    const INACTIVE = '0';
    
    protected $fillable = [
    	'name',
    	'description',
    	'img',
        'status',
        'category_id',
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
        return $this->status == Subcategory::ACTIVE;
    }

    public function category() {
    	return $this->belongsTo(Category::class);
    }

    public function products() {
    	return $this->hasMany(Product::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }
}
