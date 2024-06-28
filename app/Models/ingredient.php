<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ingredient extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo(supplier::class, 'supplier_id');
    }

}
