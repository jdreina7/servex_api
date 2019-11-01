<?php

namespace App;

use App\User;
use App\Category;
use App\Product;
use App\Transformers\ClientTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = ClientTransformer::class;
    
    const ACTIVE = '1';
    const INACTIVE = '0';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email', 
        'bussiness_name',
        'description',
        'logo', 
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

    public function setSurnameAttr($surname) {
        $this->attributes['surname'] = strtolower($surname);
    }

    public function getSurnameAttr ($surname) {
        return ucfirst($surname);
    }

    public function setBusinessNameAttr($bussiness_name) {
        $this->attributes['bussiness_name'] = strtolower($bussiness_name);
    }

    public function getBusinessNameAttr ($bussiness_name) {
        return ucfirst($bussiness_name);
    }

    public function setEmailAttr($email) {
        $this->attributes['email'] = strtolower($email);
    }

    public function isActive() {
        return $this->status == Client::ACTIVE;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at'=> 'datetime',
    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function categories() {
    	return $this->belongsToMany(Category::class);
    }

    public function products() {
    	return $this->hasMany(Product::class);
    }

    public function subcategories() {
        return $this->hasManyThrough(Subcategory::class, Product::class);
    }
}
