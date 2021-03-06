<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Users\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditUserRequest;

class AdminController extends Controller
{
    //
    public function show()
    {
        $posts = Post::where('is_vip', false)
            ->where(function ($query) {
                $query->where('validate', '>=', now())->orWhere('validate', null);
            })->whereHas('users', function ($query) {
                $query->where('role', '!=', 'block');
            })->count();

        $vips = Post::where('is_vip', true)
            ->where(function ($query) {
                $query->where('validate', '>=', now())->orWhere('validate', null);
            })->whereHas('users', function ($query) {
                $query->where('role', '!=', 'block');
            })->count();

        $vips_reg = Post::where('reg_vip', true)->where('is_vip', false)
            ->where(function ($query) {
                $query->where('validate', '>=', now())->orWhere('validate', null);
            })->whereHas('users', function ($query) {
                $query->where('role', '!=', 'block');
            })->count();

        $postvalidate = Post::where('validate', '<', now())->whereHas('users', function ($query) {
            $query->where('role', '!=', 'block');
        })->count();

        $postblock = Post::whereHas('users', function ($query) {
            $query->where('role', 'block');
        })->count();

        $users = User::where('role', '!=', 'block')->count();
        $userblock = User::where('role', 'block')->count();

        return view('admin.show', [
            'posts' => $posts,
            'vips' => $vips,
            'vips_reg' => $vips_reg,
            'postvalidate' => $postvalidate,
            'postblock' => $postblock,
            'users' => $users,
            'userblock' => $userblock
        ]);
    }
    public function user_list()
    {
        Paginator::useBootstrap();
        $users = User::latest()->paginate(10);
        return view('admin.user_list', [
            'users' => $users
        ]);
    }

    public function user_show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user_show', [
            'user' => $user
        ]);
    }

    public function store(EditUserRequest $request, $id)
    {
        $systemUser = User::findOrFail($id);
        $user = $request->only(['fullname', 'password', 'phone']);
        if ($systemUser->phone != null) {
            if ($user['password'] == null) {
                $systemUser->update(['fullname' => $user['fullname']]);
                return redirect()->route('admin.user.show', ['id' => $id])->with('notice', '???? c???p nh???p th??ng tin th??nh c??ng!');
            } else {
                $systemUser->update(['fullname' => $user['fullname'], 'password' => Hash::make($user['password'])]);
                return redirect()->route('admin.user.show', ['id' => $id])->with('notice', '???? c???p nh???p th??ng tin th??nh c??ng!');;
            }
        } else {
            if ($user['password'] == null) {
                $systemUser->update(['fullname' => $user['fullname'], 'phone' => $user['phone']]);
                return redirect()->route('admin.user.show', ['id' => $id])->with('notice', '???? c???p nh???p th??ng tin th??nh c??ng!');
            } else {
                $systemUser->update(['fullname' => $user['fullname'], 'phone' => $user['phone'], 'password' => Hash::make($user['password'])]);
                return redirect()->route('admin.user.show', ['id' => $id])->with('notice', '???? c???p nh???p th??ng tin th??nh c??ng!');;
            }
        }
    }

    public function checklookuser($id)
    {
        $user = User::findOrFail($id);
        if (($user->role != 'block') && (Auth::user()->id != $id)) {
            $user->role = 'block';
            $notice = '<strong>Success!</strong> B???n ???? kh??a th??nh vi??n <b class="alert-link">' . $user->fullname . '</b>.';
            $status = 'success';
        } else if (($user->role == 'block') && (Auth::user()->id != $id)) {
            $user->role = 'user';
            $notice = '<strong>Success!</strong> B???n ???? m??? kh??a th??nh vi??n <b class="alert-link">' . $user->fullname . '</b>.';
            $status = 'success';
        } else {
            $notice = '<strong>L???i!</strong> B???n kh??ng th??? t??? kh??a ch??nh m??nh! ';
            $status = 'danger';
        }

        $user->save();
        return redirect()->route('admin.user')->with([
            'notice' => $notice,
            'status' => $status
        ]);
    }
    public function checkadminuser($id)
    {
        $user = User::findOrFail($id);
        if (($user->role != 'admin') && (Auth::user()->id != $id)) {
            $user->role = 'admin';
            $notice = '<strong>Success!</strong> B???n ???? n??ng th??nh vi??n <b class="alert-link">' . $user->fullname . '</b> l??m admin.';
            $status = 'success';
        } else if (($user->role == 'admin') && (Auth::user()->id != $id)) {
            $user->role = 'user';
            $notice = '<strong>Success!</strong> B???n ???? h??? th??nh vi??n <b class="alert-link">' . $user->fullname . '</b> l??m user.';
            $status = 'success';
        } else {
            $notice = '<strong>L???i!</strong> B???n kh??ng th??? h??? ch??nh m??nh! ';
            $status = 'danger';
        }

        $user->save();
        return redirect()->route('admin.user')->with([
            'notice' => $notice,
            'status' => $status
        ]);
    }

    public function post_list()
    {
        Paginator::useBootstrap();
        $posts = Post::latest()->paginate(10);
        return view('admin.posts_list', [
            'posts' => $posts
        ]);
    }
    public function post_list_check_vips()
    {
        Paginator::useBootstrap();
        $posts = Post::where('reg_vip', true)->where('is_vip', false)->where(function ($query) {
            $query->where('validate', '>=', now())->orWhere('validate', null);
        })->latest()->paginate(10);
        return view('admin.post_list_check_vip', [
            'posts' => $posts
        ]);
    }

    public function post_list_vips()
    {
        Paginator::useBootstrap();
        $posts = Post::where('reg_vip', true)->where('is_vip', true)->latest()->paginate(10);
        return view('admin.post_list_vip', [
            'posts' => $posts
        ]);
    }

    public function post_list_validate()
    {
        Paginator::useBootstrap();
        $posts = Post::where('validate', '<', now())->latest()->paginate(10);
        return view('admin.post_list_validate', [
            'posts' => $posts
        ]);
    }
    public function post_postblock_validate()
    {
        Paginator::useBootstrap();
        $posts = Post::whereHas('users', function ($query) {
            $query->where('role', 'block');
        })->latest()->paginate(10);
        return view('admin.post_list_block', [
            'posts' => $posts
        ]);
    }



    public function checkpost($id)
    {
        $post = Post::findOrFail($id);
        if (!$post->is_vip) {
            $post->reg_vip = true;
            $post->is_vip = true;
            $notice = '<strong>Success!</strong> B???n ???? duy???t VIP b??i vi???t <b class="alert-link"> ID: ' . $post->id . '</b>.';
            $status = 'success';
        } else {
            $post->reg_vip = false;
            $post->is_vip = false;
            $notice = '<strong>Success!</strong> B???n ???? h??? VIP b??i vi???t <b class="alert-link"> ID: ' . $post->id . '</b>.';
            $status = 'success';
        }
        $post->save();
        return redirect()->route('admin.vips.show')->with([
            'notice' => $notice,
            'status' => $status
        ]);
    }

    public function upVip($id)
    {
        $post = Post::findOrFail($id);
        if (($post->reg_vip) && (!$post->is_vip)) {
            $post->reg_vip = true;
            $post->is_vip = true;
            $notice = '<strong>Success!</strong> B???n ???? duy???t VIP b??i vi???t <b class="alert-link"> ID: ' . $post->id . '</b>.';
            $status = 'success';
        } else {
            $notice = '<strong>L???i!</strong> B??i vi???t <b class="alert-link"> ID: ' . $post->id . '</b>. kh??ng ????ng k?? VIP';
            $status = 'danger';
        }
        $post->save();
        return redirect()->route('admin.vips.check')->with([
            'notice' => $notice,
            'status' => $status
        ]);
    }

    public function downVip($id)
    {
        $post = Post::findOrFail($id);
        if (($post->reg_vip) && (!$post->is_vip)) {
            $post->reg_vip = false;
            $post->is_vip = false;
            $notice = '<strong>Success!</strong> B???n ???? t??? ch???i duy???t VIP b??i vi???t <b class="alert-link"> ID: ' . $post->id . '</b>.';
            $status = 'success';
        } else {
            $notice = '<strong>L???i!</strong> B??i vi???t <b class="alert-link"> ID: ' . $post->id . '</b>. kh??ng ????ng k?? VIP';
            $status = 'danger';
        }
        $post->save();
        return redirect()->route('admin.vips.check')->with([
            'notice' => $notice,
            'status' => $status
        ]);
    }
}
