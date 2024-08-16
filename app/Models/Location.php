<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class, 'user_id');
    }

    public function getControlAttribute()
    {
        return '
            <div class="btn-group">
                <button type="button" class="btn btn-sm" id="editRow" data-id="' . $this->id . '" data-toggle="modal" data-backdrop="false" data-target="#edit"><i class="la la-edit"></i></button>
                <button type="button" class="btn btn-sm" id="deleteLocation" data-id="' . $this->id . '" data-toggle="modal" data-target="#deletemodal"><i class="la la-trash"></i></button>
            </div>
        ';
    }
}
