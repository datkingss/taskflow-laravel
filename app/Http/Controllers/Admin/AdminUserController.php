<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = User::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        // Phân trang danh sách người dùng (10 người trên 1 trang)
        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users', compact('users', 'search'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Tránh tự xóa chính mình
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        // Không cho xóa admin gốc (id = 1)
        if ($user->id === 1) {
            return redirect()->back()->with('error', 'Không thể xóa tài khoản Admin gốc của hệ thống!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Đã xóa người dùng thành công!');
    }
}
