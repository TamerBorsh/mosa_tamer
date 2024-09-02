<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $connection = 'mysql';

    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'bool',
            // 'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }

    public function getSocialsUsertAttribute()
    {
        if ($this->socialst == '1') {
            return 'أعزب';
        } elseif ($this->socialst == '2') {
            return 'متزوج';
        } elseif ($this->socialst == '3') {
            return 'متعدد الزوجات';
        } elseif ($this->socialst == '4') {
            return 'أرمل';
        } elseif ($this->socialst == '5') {
            return 'مطلق';
        } else {
            return 'غير معلوم';
        }
    }

    public function getControlAttribute()
    {
        return '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="la la-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:;" id="showRow" data-id="' . $this->id . '" data-toggle="modal" data-backdrop="false" data-target="#backdrop">عرض التفاصيل</a>
                    <a class="dropdown-item" href="javascript:;" id="editRow" data-id="' . $this->id . '" data-toggle="modal" data-backdrop="false" data-target="#edit">تعديل</a>
                    <a class="dropdown-item" href="javascript:;" id="deleteUser" data-id="' . $this->id . '" data-toggle="modal" data-target="#deletemodal">حذف</a>
                </div>
            </li>
        ';
    }
    // =======================================
    public function scopeIsactive()
    {
        return $this->is_active == true ? "<span class='badge badge-info'>نشط</span>" : "<span class='badge badge-danger'>مجمد</span>";
    }
    // =======================================
    public function scopeCheck()
    {
        return '<div class="custom-control custom-checkbox">' . '<input type="checkbox" class="custom-control-input" id="user-' . $this->id . '">' . '<label class="custom-control-label" for="user-' . $this->id . '"></label>' . '</div>';
    }
    // ================================================
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
    // ================================================
    public function nominates()
    {
        return $this->hasMany(Nominate::class, 'user_id');
    }
    // ================================================
    public function units()
    {
        return $this->hasMany(Unit::class, 'user_id');
    }
    // ================================================
    public function user_systems()
    {
        return $this->hasMany(UserSystem::class, 'user_id');
    }
    // ================================================
    // العلاقة مع المؤسسة
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
    // ================================================

    public function wife()
    {
        return $this->hasOne(User::class, 'id-number-wife', 'id-number');
    }

    public function wifeCopons()
    {
        return $this->hasManyThrough(Coupon::class, User::class, 'id-number-wife', 'user_id', 'id', 'id');
    }
    // ================================================
    // ================================================

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? null, function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%$value%")
                    ->orWhere('id-number', $value)
                    ->orWhere('id-number-wife', $value)
                    ->orWhere('name-wife', 'LIKE', "%$value%")
                    ->orWhere('notes', 'LIKE', "%$value%");
            });
        });

        $builder->when($filters['is_active'] ?? null, function ($builder, $value) {
            $builder->where('is_active', $value);
        });

        $builder->when($filters['state_id'] ?? null, function ($builder, $value) {
            $builder->where('state_id', $value);
        });

        $builder->when($filters['region_id'] ?? null, function ($builder, $value) {
            $builder->where('region_id', $value);
        });

        $builder->when($filters['gender'] ?? null, function ($builder, $value) {
            $builder->where('gender', $value);
        });

        $builder->when($filters['socialst'] ?? null, function ($builder, $value) {
            $builder->where('socialst', $value);
        });

        $builder->when($filters['mosque'] ?? null, function ($builder, $value) {
            $builder->where('mosque', 'LIKE', "%$value%");
        });

        $builder->when($filters['count_childern'] ?? null, function ($builder, $value) {
            $builder->where('count_childern', '>=', $value);
        });

        // $builder->when($filters['month'] ?? null, function ($builder, $value) {
        //     $builder->whereHas('nominates', function ($q) use ($value) {
        //         $q->where(Carbon::parse($this->recive_date)->month, $value);
        //     });
        // });

        $builder->when($filters['min_count'] ?? null, function ($builder, $value) {
            $builder->whereHas('nominates', function ($q) use ($value) {
                $q->select('user_id')
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) <= ?', [$value]);
            });
        });

        $builder->when($filters['max_count'] ?? null, function ($builder, $value) {
            $builder->whereHas('nominates', function ($q) use ($value) {
                $q->select('user_id')
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) >= ?', [$value]);
            });
        });


        // $builder->when($filters['max_count'] ?? null, function ($builder, $value) {
        //     $builder->leftJoin('users as wives', 'users.id-number', '=', 'wives.id-number-wife')
        //             ->leftJoin('copons as user_copons', 'users.id', '=', 'user_copons.user_id')
        //             ->leftJoin('copons as wife_copons', 'wives.id', '=', 'wife_copons.user_id')
        //             ->select('users.*', DB::raw('GREATEST(COALESCE(COUNT(user_copons.id), 0), COALESCE(COUNT(wife_copons.id), 0)) as recive_count'))
        //             ->groupBy('users.id')
        //             ->havingRaw('recive_count >= ?', [$value]);
        // });
    }
    // ================================================
}
