<?php

namespace App\Http\Controllers\Users;

use App\Rules\Cities;
use App\Models\Province;
use App\Models\Users\Post;
use Illuminate\Http\Request;
use App\Models\Users\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return redirect()->route('userInfo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->sortByDesc('id');
        $provinces = Province::all();
        return view('users.createpost', [
            'categories' => $categories,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => [
                    'required',
                    'max:255'
                ],
                'content' => [
                    'required',
                    'min:100'
                ],
                'category_id' => [
                    'required',
                    'exists:categories,id',
                    'array'
                ],
                'province_id' => [
                    'required',
                    'exists:provinces,id',
                    'numeric'
                ],
                'district_id' => [
                    'required',
                    'exists:districts,id',
                    'numeric'
                ],
                'ward_id' => [
                    'required',
                    'exists:wards,id',
                    'numeric',
                    new Cities($request)
                ],
                'validate' => [
                    'nullable',
                    'date',
                    'after:now'
                ]
            ],
            [
                'category_id.exists' => 'Giá trị không hợp lệ',
                'province_id.exists' => 'Giá trị không hợp lệ',
                'district_id.exists' => 'Giá trị không hợp lệ',
                'ward_id.exists' => 'Giá trị không hợp lệ',
                'ward_id.Cities' => 'Giá trị không hợp lệ',
                'validate.after' => 'Ngày tháng không hợp lệ'
            ]
        );
        $user = Auth::user();
        $post = $user->posts()->create($request->all());
        $post->categories()->attach($request->category_id);
        return redirect()->route('post.show', ['post' => $post->id])->with([
            'status' => 'success',
            'notice' => 'Bạn đã tạo tin rao vặt thành công!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users\Post  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('users.showpost', [
            'post' => $post,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Users\Post  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all()->sortByDesc('id');
        $provinces = Province::all();
        return view('users.editpost', [
            'post' => $post,
            'categories' =>  $categories,
            'provinces' => $provinces
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Users\Post  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate(
            $request,
            [
                'title' => [
                    'required',
                    'max:255'
                ],
                'content' => [
                    'required',
                    'min:100'
                ],
                'category_id' => [
                    'required',
                    'exists:categories,id',
                    'array'
                ],
                'province_id' => [
                    'required',
                    'exists:provinces,id',
                    'numeric'
                ],
                'district_id' => [
                    'required',
                    'exists:districts,id',
                    'numeric'
                ],
                'ward_id' => [
                    'required',
                    'exists:wards,id',
                    'numeric',
                    new Cities($request)
                ],
                'validate' => [
                    'nullable',
                    'date',
                    'after:now'
                ]
            ],
            [
                'category_id.exists' => 'Giá trị không hợp lệ',
                'province_id.exists' => 'Giá trị không hợp lệ',
                'district_id.exists' => 'Giá trị không hợp lệ',
                'ward_id.exists' => 'Giá trị không hợp lệ',
                'ward_id.Cities' => 'Giá trị không hợp lệ',
                'validate.after' => 'Ngày tháng không hợp lệ'
            ]
        );
        $post->update($request->all());
        $post->categories()->sync($request->category_id);
        return redirect()->route('post.edit', ['post' => $post])->with([
            'status' => 'success',
            'notice' => 'Bạn đã chỉnh sửa tin rao vặt thành công!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users\Post  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $categories = $post->categories;
        $post->categories()->detach($categories);
        $post->delete();
        return redirect()->route('userInfo');
    }
}
