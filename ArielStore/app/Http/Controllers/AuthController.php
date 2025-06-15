<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Employee;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.'
        ]);

        try {
            $employee = Employee::where('email', $request->email)->first();
            if (!$employee) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
            }
            if (!$employee->is_active) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.']);
            }
            if (!Hash::check($request->password, $employee->password)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['password' => 'Mật khẩu không chính xác.']);
            }

            Session::put('employee_id', $employee->id);
            Session::put('employee_name', $employee->name);
            Session::put('employee_email', $employee->email);
            Session::put('employee_role', $employee->role);
            Session::put('is_logged_in', true);

            return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công! Chào mừng ' . $employee->name);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Có lỗi xảy ra trong quá trình đăng nhập. Vui lòng thử lại.']);
        }
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        Session::flush();   
        return redirect()->route('login');
    }
}
