<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function plantes()
    {
        return $this->hasMany(Plante::class, 'categorie_id');
    }
}
