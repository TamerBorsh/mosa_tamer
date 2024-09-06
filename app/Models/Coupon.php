<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = [];
    // ===========================
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
    public function institutionsupport()
    {
        return $this->belongsTo(Institution::class, 'institution_support');
    }

    public function nominates()
    {
        return $this->hasMany(Nominate::class);
    }

    // ===========================
    //  لحساب الكمية المتبقية
    public function getRemainingQuantityAttribute()
    {
        return $this->quantity - $this->nominates->count();
    }
    // ===========================
    public function getCouponTypeAttribute()
    {
        if ($this->type == '1') {
            return "غذائي";
        } elseif ($this->type == '2') {
            return "صحي";
        } elseif ($this->type == '3') {
            return "padding";
        } else {
            return 'أٌخرى';
        }
    }
    // ===========================
    public function getControlAttribute()
    {
        return '
            <div class="btn-group">
                <button type="button" class="btn btn-sm" id="editRow" data-id="' . $this->id . '" data-toggle="modal" data-backdrop="false" data-target="#edit"><i class="la la-edit"></i></button>
                <button type="button" class="btn btn-sm" id="deleteCoupon" data-id="' . $this->id . '" data-toggle="modal" data-target="#deletemodal"><i class="la la-trash"></i></button>
            </div>
        ';
    }
    // ===========================
}
