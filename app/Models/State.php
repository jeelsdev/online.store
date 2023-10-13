<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function users(){
        return $this->hasMany(User::class);
    }

    public function stores(){
        return $this->hasMany(Store::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
