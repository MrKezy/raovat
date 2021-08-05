<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EditUserRequest;

class InfoController extends Controller
{
    protected function user()
    {
        $user = Auth::user();
        return $user;
    }
    public function show()
    {
        Paginator::useBootstrap();
        $posts = $this->user()->posts()->latest()->paginate(10);
        return view('users.info', [
            'user' => $this->user(),
            'posts' => $posts,
            'title' => 'Bài rao vặt của bạn'
        ]);
    }
    public function edit($notice = null)
    {
        return view('users.edit', ['user' => $this->user(), 'notice' => $notice]);
    }
    public function store(EditUserRequest $request)
    {
        $user = $request->only(['fullname', 'password', 'phone']);
        if ($this->user()->phone != null) {
            if ($user['password'] == null) {
                $this->user()->update(['fullname' => $user['fullname']]);
                return redirect()->route('userEdit')->with([
                    'status' => 'success',
                    'notice' => 'Đã cập nhập thông tin thành công!'
                ]);
            } else {
                $this->user()->update(['fullname' => $user['fullname'], 'password' => Hash::make($user['password'])]);
                return redirect()->route('userEdit')->with([
                    'status' => 'success',
                    'notice' => 'Đã cập nhập thông tin thành công!'
                ]);
            }
        } else {
            if ($user['password'] == null) {
                $this->user()->update(['fullname' => $user['fullname'], 'phone' => $user['phone']]);
                return redirect()->route('userEdit')->with([
                    'status' => 'success',
                    'notice' => 'Đã cập nhập thông tin thành công!'
                ]);
            } else {
                $this->user()->update(['fullname' => $user['fullname'], 'phone' => $user['phone'], 'password' => Hash::make($user['password'])]);
                return redirect()->route('userEdit')->with([
                    'status' => 'success',
                    'notice' => 'Đã cập nhập thông tin thành công!'
                ]);
            }
        }
    }
    public function user_view($id)
    {

        if (Auth::check() && $this->user()->id == $id) {
            return redirect()->route('userInfo');
        }
        $user = User::findOrFail($id);
        $posts = $user->posts()->latest()->paginate(10);
        return view('users.info', [
            'user' => $user,
            'posts' => $posts,
            'title' => 'Bài rao vặt của ' . $user->fullname
        ]);
    }
}
