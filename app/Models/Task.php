<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     use HasFactory;

    protected $table = 'tasks';
    protected $primaryKey = 'id';
     protected $fillable = [
          'name',
          'description',
          'category_id'
     ];

     // protected $attributes = [
     //      'category_id' => 1, // Default category_id (optional)
     //  ];

     public function category()
     {
         return $this->belongsTo(Category::class); 
     }

     // public function user()
     // {
     // return $this->belongsTo(User::class); // Each task belongs to a user
     // }
}