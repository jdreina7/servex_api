<?php

namespace App;

use App\Category;
use App\Subcategory;
use App\User;
use App\Clients;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const IS_AVAILABLE = '1';
	const IS_NOT_AVAILABLE = '0';

    const ACTIVE = '1';
    const INACTIVE = '0';

    protected $fillable = [
    	'name',
    	'description',
    	'file_route',
    	'img',
        'status',
        'client_id',
        'category_id',
        'subcategory_id',
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
        return ucwords($name);
    }

    

    public function isAvailable()
    {
    	return $this->status == Product::IS_AVAILABLE;
    }

    public function isActive() {
        return $this->status == Product::ACTIVE;
    }

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
