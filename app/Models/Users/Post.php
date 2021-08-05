<?php

namespace App\Models\Users;

use App\Models\User;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use App\Models\Users\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'user_id', 'province_id', 'district_id', 'ward_id', 'validate', 'reg_vip', 'is_vip'];
    protected $table = 'posts';
    public function provinces()
    {
        return $this->belongsTo(Province::class, config('vietnam-maps.columns.province_id'), 'id');
    }
    public function districts()
    {
        return $this->belongsTo(District::class, config('vietnam-maps.columns.district_id'), 'id');
    }
    public function wards()
    {
        return $this->belongsTo(Ward::class, config('vietnam-maps.columns.ward_id'), 'id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
