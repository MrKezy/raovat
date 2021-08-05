<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Users\Post;
use Illuminate\Http\Request;
use App\Models\Users\Category;
use Illuminate\Pagination\Paginator;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $categories = Category::all();
        $provinces = Province::all();
        Paginator::useBootstrap();
        $this->validate(
            $request,
            [
                'category_id' => [
                    'nullable',
                    'exists:categories,id'
                ],
                'province_id' => [
                    'nullable',
                    'exists:provinces,id'
                ],
                'text_search' => [
                    'nullable',
                    'min:5'
                ]
            ]
        );

        $posts = Post::where(function ($query) {
            $query->where('validate', '<', now())->orWhere('validate', null);
        })->where(function ($query) {
            global $request;
            if ($request->input('province_id') != null) {
                $query->where('province_id', $request->input('province_id'));
            }
            if ($request->input('category_id') != null) {
                $query->whereHas('categories', function ($query) {
                    global $request;
                    $query->where('category_id', $request->input('category_id'));
                });
            }
            if ($request->input('text_search') != null) {
                $query->where('title', 'like', '%' . $request->input('text_search') . '%');
            }
        })
            ->whereHas('users', function ($query) {
                $query->where('role', '!=', 'block');
            })->latest()->paginate(10);
        $title = 'Danh sách các bài viết tìm được';




        return view('users.search', [
            'posts' => $posts,
            'title' => $title,
            'categories' => $categories,
            'provinces' => $provinces
        ]);
    }
}
