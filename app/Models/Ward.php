<?php

namespace App\Models;

use App\Models\District;
use App\Models\Users\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory;
    public function district()
    {
        return $this->belongsTo(District::class, config('vietnam-maps.columns.district_id'), 'id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
