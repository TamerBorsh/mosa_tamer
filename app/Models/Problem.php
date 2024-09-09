<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    protected $guarded = [];

    public function getControlAttribute()
    {
        return '
            <div class="btn-group">
                <a href="' . route("users.problem.show", $this->id) . '"><div class="fonticon-wrap"><i class="la la-eye"></i></div></a>
            </div>
        ';
    }
}
