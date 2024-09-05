<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Nominate extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function redemption(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'redemption_id');
    }
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    // =======================================
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->recive_date)) {
                $model->recive_date = Carbon::now()->toDateString();
            }
            if (is_null($model->redirect_date)) {
                $model->redirect_date = Carbon::now()->toDateString();
            }
        });
    }
    // =======================================
    public function scopeCheck()
    {
        return '
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="nominate-' . $this->id . '">
            <label class="custom-control-label" for="nominate-' . $this->id . '"></label>
        </div>';
    }
    // =======================================
    public function getReciveAttribute()
    {
        if ($this->is_recive == '1') {
            return "<span class='badge badge-primary '>مرشح</span>";
        } elseif ($this->is_recive == '2') {
            return "<span class='badge badge-info'>مطبوع</span>";
        } elseif ($this->is_recive == '3') {
            return "<span class='badge badge-success '>مستلم</span>";
        } elseif ($this->is_recive == '4') {
            return "<span class='badge badge-danger'>غير مستلم</span>";
        } else {
            return 'غير مصنف';
        }
    }
    // =======================================
    public function getControlAttribute()
    {
        return '
            <div class="btn-group">
                <button type="button" class="btn btn-sm" id="deleteNominate" data-id="' . $this->id . '" data-toggle="modal" data-target="#deletemodal"><i class="la la-trash"></i></button>
                <button type="button" class="btn btn-sm" id="showRow" data-id="' . $this->id . '" data-toggle="modal" data-backdrop="false" data-target="#info"><div class="fonticon-wrap"><i class="la la-eye"></i></div></button>
            </div>
        ';
    }
    // =======================================
    protected static function booted()
    {
        static::creating(function (Nominate $nominate) {
            $nominate->number_copon = DB::transaction(function () {
                return self::getNextCoponNumber();
            });
        });
    }

    protected static function getNextCoponNumber()
    {
        $year = Carbon::now()->year;

        // قفل الجدول لتجنب التكرارات في البيئات متعددة المستخدمين
        $number = Nominate::whereYear('created_at', $year)
            ->lockForUpdate()
            ->max('number_copon');

        // تحديد الرقم التالي بناءً على الرقم الأكبر الموجود
        if ($number) {
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        // تنسيق الرقم ليكون دائمًا من خمسة أرقام
        return str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
    // =======================================
    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? null, function ($query, $value) {
            $query->whereHas('user', function ($query) use ($value) {
                $query->where('name', 'LIKE', "%$value%")
                    ->orWhere('id-number', $value)
                    ->orWhere('id-number-wife', $value)
                    ->orWhere('name-wife', 'LIKE', "%$value%")
                    ->orWhere('notes', 'LIKE', "%$value%");
            });
        });

        $builder->when($filters['state_id'] ?? null, function ($query, $value) {
            $query->whereHas('user', function ($query) use ($value) {
                $query->where('state_id', $value);
            });
        });

        $builder->when($filters['region_id'] ?? null, function ($query, $value) {
            $query->whereHas('user', function ($query) use ($value) {
                $query->where('region_id', $value);
            });
        });
        $builder->when($filters['is_recive'] ?? null, function ($query, $value) {
            $query->where('is_recive', $value);
        });
    }
}
