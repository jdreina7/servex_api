<?php

namespace App;

use App\Role;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    const ACTIVE = '1';
    const INACTIVE = '0';

    const VERIFIED = '1';
    const NOT_VERIFIED = '0';

    protected $dates = ['deleted_at'];

    public $transformer = UserTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'surname',
        'email', 
        'password', 
        'image', 
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

    public function setSurnameAttr($surname) {
        $this->attributes['surname'] = strtolower($surname);
    }

    public function getSurnameAttr ($surname) {
        return ucfirst($surname);
    }

    public function setEmailAttr($email) {
        $this->attributes['email'] = strtolower($email);
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at'=> 'datetime',
    ];

    public function isVerified() {
        return $this->verified == User::VERIFIED;
    }

    public function isActive() {
        return $this->status == User::ACTIVE;
    }

    public static function gnerateVerifiedToken() {
        return str_random(40);
    }

    public function role() {
        return $this->belongsTo(Role::Class);
    }

    // public function role() {
    //     return $this->belongsTo('App\Role', 'role_id');
    // }

}
