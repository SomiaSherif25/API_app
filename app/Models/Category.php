<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id', 'name_ar','name_en'];
    protected $table = 'categories';
    public $timestamp = false;
    use HasFactory;

}
