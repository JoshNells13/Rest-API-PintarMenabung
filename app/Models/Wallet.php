<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Wallet extends Model
{
    use HasApiTokens,HasFactory;

    protected $table = 'wallets';

    public $fillable = ['name','user_id','currency_id'];

    public function Currency(){
        return $this->belongsTo(Currencies::class,'currency_id');
    }

    public function Wallet(){
        return $this->hasMany(Wallet::class,'wallet_id');
    }
}
