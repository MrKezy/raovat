<?php

namespace App\Models;

use App\Models\Users\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
    public function districts()
    {
        return $this->hasMany(District::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
