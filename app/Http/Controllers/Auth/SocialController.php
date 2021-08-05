<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    //
    public function redirect_google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirect_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function processGoogleLogin()
    {
        // Đăng nhập vào google để lấy dữ liệu
        $googleUser = Socialite::driver('google')->stateless()->user();
        if (!$googleUser) {
            return redirect('/login');
        }

        // Trường hợp chưa đăng nhập để tạo tài khoản mới
        // Sẽ check lần đầu là google_id , nếu chưa có sẽ check sang email , tiếp tục chưa có thì tạo tài khoản mới !
        if (!Auth::check()) {
            // check email hoặc google_id
            $systemUser = User::where('email', $googleUser->email)->orWhere('google_id', $googleUser->id)->first();
            if ($systemUser) {
                if ($systemUser->google_id == null) {
                    $systemUser->update(['google_id' => $googleUser->id]);
                }
                Auth::loginUsingId($systemUser->id);
                return redirect()->route('home');
            }
            // Tạo tài khoản mới
            $systemUser = User::create([
                'fullname' => $googleUser->name,
                'username' => 'google_' . $googleUser->id,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id
            ]);
            Auth::loginUsingId($systemUser->id);
            return redirect()->route('home');
        } else {
            // Trường hợp đã đăng nhập thì update google_id
            $systemUser = Auth::user();
            // Kiểm tra xem google id đã được gắn hay chưa
            if ($systemUser->google_id != null) {
                return redirect()->route('userEdit')->with([
                    'notice' => 'Lỗi! Tài khoản của bạn đã được kết nối trước đó.',
                    'status' => 'danger'
                ]);
            }
            // Trường hợp tài khoản google đã bị gắn cho tài khoản khác
            $check = User::where('google_id', $googleUser->id)->first();
            if ($check) {
                return redirect()->route('userEdit')->with([
                    'notice' => 'Lỗi! Tài khoản google đã được gắn cho tài khoản khác.',
                    'status' => 'danger'
                ]);
            }
            // Thỏa mãn toàn bộ điều kiện thì kết nối tài khoản google
            Auth::user()->update([
                'google_id' => $googleUser->id
            ]);
            return redirect()->route('userEdit')->with([
                'notice' => 'Đã kết nối với tài khoản google của bạn!',
                'status' => 'success'
            ]);
        }
    }
    public function processFacebookLogin()
    {
        // Đăng nhập vào facebook để lấy dữ liệu
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        if (!$facebookUser) {
            return redirect('/login');
        }

        // Trường hợp chưa đăng nhập để tạo tài khoản mới
        // Sẽ check lần đầu là facebook_id , nếu chưa có sẽ check sang email , tiếp tục chưa có thì tạo tài khoản mới !
        if (!Auth::check()) {
            // check email hoặc facebook_id
            $systemUser = User::where('email', $facebookUser->email)->orWhere('facebook_id', $facebookUser->id)->first();
            if ($systemUser) {
                if ($systemUser->facebook_id == null) {
                    $systemUser->update([
                        'facebook_id' => $facebookUser->id
                    ]);
                }
                Auth::loginUsingId($systemUser->id);
                return redirect()->route('home');
            }
            // Tạo tài khoản mới
            $systemUser = User::create([
                'fullname' => $facebookUser->name,
                'username' => 'facebook_' . $facebookUser->id,
                'email' => $facebookUser->email,
                'facebook_id' => $facebookUser->id
            ]);
            Auth::loginUsingId($systemUser->id);
            return redirect()->route('home');
        } else {
            // Trường hợp đã đăng nhập thì update facebook_id
            $systemUser = Auth::user();
            // Kiểm tra xem facebook id đã được gắn hay chưa
            if ($systemUser->facebook_id != null) {
                return redirect()->route('userEdit')->with([
                    'notice' => 'Lỗi! Tài khoản của bạn đã được kết nối trước đó.',
                    'status' => 'danger'
                ]);
            }
            // Trường hợp tài khoản facebook đã bị gắn cho tài khoản khác
            $check = User::where('facebook_id', $facebookUser->id)->first();
            if ($check) {
                return redirect()->route('userEdit')->with([
                    'notice' => 'Lỗi! Tài khoản facebook đã được gắn cho tài khoản khác.',
                    'status' => 'danger'
                ]);
            }
            // Thỏa mãn toàn bộ điều kiện thì kết nối tài khoản facebook
            Auth::user()->update([
                'facebook_id' => $facebookUser->id
            ]);
            return redirect()->route('userEdit')->with([
                'notice' => 'Đã kết nối với tài khoản facebook của bạn!',
                'status' => 'success'
            ]);
        }
    }
}
