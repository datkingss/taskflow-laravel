<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskActivityNotification;

class TaskController extends Controller
{
    public function index()
    {
        // Lấy toàn bộ task và phân loại theo trạng thái (không giới hạn số lượng)
        $pendingTasks = Task::where('status', 'pending')->latest()->get();
        $inProgressTasks = Task::where('status', 'in_progress')->latest()->get();
        $completedTasks = Task::where('status', 'completed')->latest()->get();

        return view('tasks.index', compact('pendingTasks', 'inProgressTasks', 'completedTasks'));
    }

    public function store(Request $request)
    {
        // 1. Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        // 2. Lưu vào Database (Cần gán vào biến $task để lấy dữ liệu gửi thông báo)
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'created_by' => Auth::id(),
            'assigned_to' => Auth::id(), // Tạm thời tự giao cho mình
        ]);

        // 3. Gửi thông báo TẠO MỚI
        Auth::user()->notify(new TaskActivityNotification($task, 'tạo mới'));

        // 4. Quay lại trang cũ với thông báo thành công
        return redirect()->back()->with('success', 'Đã tạo công việc mới thành công!');
    }

    public function update(Request $request, Task $task)
    {
        // 1. Xác thực dữ liệu
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        // 2. Cập nhật vào Database
        $task->update($validated);

        // 3. Gửi thông báo CẬP NHẬT
        Auth::user()->notify(new TaskActivityNotification($task, 'cập nhật'));

        return redirect()->back()->with('success', 'Đã cập nhật công việc thành công!');
    }

    public function destroy(Task $task)
    {
        // Gửi thông báo XÓA (Gửi trước khi xóa để vẫn lấy được tên task)
        Auth::user()->notify(new TaskActivityNotification($task, 'xóa'));

        // Xóa công việc khỏi Database
        $task->delete();

        return redirect()->back()->with('success', 'Đã xóa công việc!');
    }
}