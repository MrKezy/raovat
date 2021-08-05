<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\Post;
use Illuminate\Http\Request;
use App\Models\Users\Category;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Paginator::useBootstrap();
        $vips = Post::where('is_vip', true)
            ->where(function ($query) {
                $query->where('validate', '>=', now())->orWhere('validate', null);
            })->whereHas('users', function ($query) {
                $query->where('role', '!=', 'block');
            })->latest()->limit(10)->get();

        $categories = Category::latest()->paginate(10);
        return view('Categories.Categories', [
            'categories' => $categories,
            'vips' => $vips
        ]);
    }

    public function list()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories_create');
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
                'name' => [
                    'required',
                    'min:3',
                    'unique:categories,name'
                ],
            ],
            [
                'name.unique' => 'Tên danh mục đã tồn tại'
            ]
        );
        Category::create($request->all());
        return redirect()->route('admin.category.creat')->with([
            'status' => 'success',
            'notice' => 'Bạn đã tạo danh mục <strong> ' . $request->name . ' </strong> thành công!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        $posts = $category->posts()
            ->where(function ($query) {
                $query->where('validate', '>', now())->orWhere('validate', null);
            })
            ->whereHas('users', function (Builder $query) {
                $query->where('role', '!=', 'block');
            })->orderBy('id', 'desc')->paginate(10);

        return view('Categories.CategoryShow', [
            'category' => $category,
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Users\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories_edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Users\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate(
            $request,
            [
                'name' => [
                    'required',
                    'min:3',
                    'unique:categories,name'
                ],
            ],
            [
                'name.unique' => 'Tên danh mục đã tồn tại'
            ]
        );
        $category->update($request->all());
        return redirect()->route('admin.category.list')->with([
            'status' => 'success',
            'notice' => 'Bạn đã sửa danh mục <strong> ' . $request->name . ' </strong> thành công!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Kiểm tra xem có phải danh mục mặc định không !
        if ($category->id == 1) {
            return redirect()->route('admin.category.list')->with([
                'status' => 'danger',
                'notice' => 'Lỗi! Bạn không được phép xóa danh mục <strong>Mặc định</strong>'
            ]);
        }
        // Di chuyển các bài viết của anh mục bị xóa về danh mục mặc định
        $posts = $category->posts;
        foreach ($posts as $post) {
            $post->categories()->detach($category->id);
            if (count($post->categories) == 0) {
                $post->categories()->attach(1);
            }
        }
        // Xóa category rồi chuyển về list category
        $category->delete();
        return redirect()->route('admin.category.list')->with([
            'status' => 'success',
            'notice' => 'Bạn đã xóa danh mục <strong>' . $category->name . '</strong> thành công !'
        ]);
    }
}
