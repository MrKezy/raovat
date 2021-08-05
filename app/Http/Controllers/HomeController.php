<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Users\Post;
use Illuminate\Http\Request;
use App\Models\Users\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Paginator::useBootstrap();
        $categories = Category::all();
        $provinces = Province::all();

        $vips = Post::where('is_vip', true)
            ->where(function ($query) {
                $query->where('validate', '>=', now())->orWhere('validate', null);
            })->whereHas('users', function ($query) {
                $query->where('role', '!=', 'block');
            })->latest()->limit(5)->get();

        $posts = Post::where('is_vip', false)
            ->where(function ($query) {
                $query->where('validate', '>=', now())->orWhere('validate', null);
            })->whereHas('users', function ($query) {
                $query->where('role', '!=', 'block');
            })->latest()->paginate(10);


        return view('home', [
            'categories' => $categories,
            'provinces' => $provinces,
            'vips' => $vips,
            'posts' => $posts,
        ]);
    }
}
