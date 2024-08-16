<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $connection = 'mysql';

    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getControlAttribute()
    {
        return '
            <div class="btn-group">
                <button type="button" class="btn btn-sm" id="editRow" data-id="' . $this->id . '" data-toggle="modal" data-backdrop="false" data-target="#edit"><i class="la la-edit"></i></button>
                <button type="button" class="btn btn-sm" id="deleteAdmin" data-id="' . $this->id . '" data-toggle="modal" data-target="#deletemodal"><i class="la la-trash"></i></button>
            </div>
        ';
    }
}
