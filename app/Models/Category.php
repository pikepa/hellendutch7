<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    protected $dates = ['created_at'];

    protected $guarded = [];

    //
    public function products()
    {
        return $this->belongsToMany(Product::class)->orderBy('publish_at', 'desc');
    }

    public function path()
    {
        return "/category/{$this->id}";
    }
}
