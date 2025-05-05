<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBrand extends Model
{
    protected $filable = [
        'code',
        'name',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(MasterItem::class);
    }
}
