<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Transaction extends Model
{
    use HasApiTokens,HasFactory;

    protected $table = 'transactions';

    public $fillable = ['category_id','wallet_id','amount','date','note'];

    public function Wallet(){
        return $this->belongsTo(Wallet::class,'wallet_id');
    }

    public function Category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
