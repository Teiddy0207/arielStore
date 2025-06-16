<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'address',
        'role',
        'is_active'
    ];

    protected $casts = [
        'birthday' => 'date',
        'is_active' => 'boolean'
    ];

    public function getFormattedBirthdayAttribute()
    {
        return $this->birthday->format('d/m/Y');
    }

    public function getRoleBadgeClassAttribute()
    {
        return match($this->role) {
            'Quản lý' => 'manager',
            'Nhân viên kho' => 'leader',
            'Nhân viên bán hàng' => 'employee',
            default => 'employee'
        };
    }
}