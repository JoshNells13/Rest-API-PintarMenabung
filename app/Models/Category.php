<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'icon',
        'color',
        'type',
    ];


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'category_id');
    }
}
