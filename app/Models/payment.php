<?php

namespace App\Models;

use App\Models\transaction;
use App\Models\paymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class payment extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];

    public function transaction(){
        return $this->belongsTo(transaction::class,'transaction_id');
    }
    public function paymentMethod(){
        return $this->belongsTo(paymentMethod::class,'paymentMethod_id');
    }
}
