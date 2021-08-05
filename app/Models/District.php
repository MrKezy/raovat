<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\Province;
use App\Models\Users\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    public function province()
    {
        return $this->belongsTo(Province::class, config('vietnam-maps.columns.province_id'), 'id');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
