<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = ['level', 'message', 'context'];
    public function getControlAttribute()
    {
        return '
            <div class="btn-group">
                <button type="button" class="btn btn-sm" id="deleteLog" data-id="' . $this->id . '" data-toggle="modal" data-target="#deletemodal"><i class="la la-trash"></i></button>
            </div>
        ';
    }
}
