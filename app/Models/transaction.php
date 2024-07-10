<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function menu(){
        return $this->belongsTo(menu::class, 'menu_id');
    }
    public function customer(){
        return $this->belongsTo(customer::class, 'customer_id');
    }
    public function employee(){
        return $this->belongsTo(employee::class, 'customer_id');
    }
}
