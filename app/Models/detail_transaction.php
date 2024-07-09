<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transactions(){
        return $this->belongsTo(transaction::class, 'transaction_id');
    }
    public function stockMenu(){
        return $this->belongsTo(stockMenu::class,'stock_menu_id');
    }
}
