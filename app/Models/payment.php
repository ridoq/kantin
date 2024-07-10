<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transaction(){
        return $this->belongsTo(transaction::class,'transaction_id');
    }
    public function paymentMethod(){
        return $this->belongsTo(paymentMethod::class,'paymentMethod_id');
    }
}
