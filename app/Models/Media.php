<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = ['type', 'src', 'mediable_id', 'mediable_type'];

    public function mediable()
    {
        return $this->morphTo();
    }
}
