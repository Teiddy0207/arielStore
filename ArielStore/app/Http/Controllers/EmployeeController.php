<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Employee::query();
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('birthday', 'like', "%{$search}%");
                });
            }
            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }
            $employees = $query->orderBy('created_at', 'desc')->get();
            $totalCount = Employee::count();
            return view('employee.index', compact('employees', 'totalCount'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi tải danh sách nhân viên.']);
        }
        
    }

    public function toggleActive(Employee $employee)
    {
        try {
            $employee->update(['is_active' => !$employee->is_active]);
            $action = $employee->is_active ? 'mở khóa' : 'khóa';
            
            return redirect()->route('employee.index')->with('success', "Đã {$action} tài khoản nhân viên {$employee->name} thành công!");
            
        } catch (\Exception $e) {
            return redirect()->route('employee.index')->with('error', "Đã xảy ra lỗi khi cập nhật tài khoản nhân viên: " . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:6',
            'birthday' => 'required|date|before:today',
            'role' => 'required|in:Quản lý,Nhân viên bán hàng,Nhân viên kho',
            'address' => 'required|string|max:500'
        ], [
            'name.required' => 'Tên nhân viên là bắt buộc.',
            'name.max' => 'Tên nhân viên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'birthday.required' => 'Ngày sinh là bắt buộc.',
            'birthday.date' => 'Ngày sinh không đúng định dạng.',
            'birthday.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'role.required' => 'Vai trò là bắt buộc.',
            'role.in' => 'Vai trò không hợp lệ.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.'
        ]);

        try {
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'birthday' => $request->birthday,
                'role' => $request->role,
                'address' => $request->address,
                'is_active' => true
            ]);

            return redirect()->route('employee.index')->with('success', 'Thêm mới tài khoản nhân viên ' . $request->name . ' thành công !');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Có lỗi xảy ra khi thêm nhân viên: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'birthday' => 'required|date|before:today',
            'role' => 'required|in:Quản lý,Nhân viên bán hàng,Nhân viên kho',
            'address' => 'required|string|max:500',
        ];
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6';
        }

        $request->validate($rules, [
            'name.required' => 'Tên nhân viên là bắt buộc.',
            'name.max' => 'Tên nhân viên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'birthday.required' => 'Ngày sinh là bắt buộc.',
            'birthday.date' => 'Ngày sinh không đúng định dạng.',
            'birthday.before' => 'Ngày sinh phải trước ngày hôm nay.',
            'role.required' => 'Vai trò là bắt buộc.',
            'role.in' => 'Vai trò không hợp lệ.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.'
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'birthday' => $request->birthday,
                'role' => $request->role,
                'address' => $request->address,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }

            $employee->update($updateData);

            return redirect()->route('employee.index')->with('success', 'Cập nhật tài khoản nhân viên ' . $employee->name . ' thành công !');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin nhân viên: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
