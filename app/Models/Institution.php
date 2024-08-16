<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    use HasFactory;
    protected $connection = 'mysql';

    protected $guarded = [];

    public function getControlAttribute()
    {
        return '
            <div class="btn-group">
                <button type="button" class="btn btn-sm" id="editRow" data-id="' . $this->id . '" data-toggle="modal" data-backdrop="false" data-target="#edit"><i class="la la-edit"></i></button>
                <button type="button" class="btn btn-sm" id="deleteInstitution" data-id="' . $this->id . '" data-toggle="modal" data-target="#deletemodal"><i class="la la-trash"></i></button>
            </div>
        ';
    }
}
