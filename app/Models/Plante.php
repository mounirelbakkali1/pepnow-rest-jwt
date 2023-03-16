<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plante extends Model
{
    use HasFactory;


    protected $fillable = [
        'nom',
        'description',
        'image',
        'prix',
        'stock',
        'categorie_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
