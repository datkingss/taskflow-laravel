<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskActivityNotification;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // CHỈ hiển thị những công việc được gán cho chính User đang đăng nhập
        $query = Task::where('assigned_to', Auth::id());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Lấy và phân trang công việc độc lập theo trạng thái (tối đa 5 task mỗi trang)
        $pendingTasks = (clone $query)->where('status', 'pending')->latest()->paginate(5, ['*'], 'pending_page')->withQueryString();
        $inProgressTasks = (clone $query)->where('status', 'in_progress')->latest()->paginate(5, ['*'], 'in_progress_page')->withQueryString();
        $completedTasks = (clone $query)->where('status', 'completed')->latest()->paginate(5, ['*'], 'completed_page')->withQueryString();

        return view('tasks.index', compact('pendingTasks', 'inProgressTasks', 'completedTasks', 'search'));
    }

    public function store(Request $request)
    {
        // Chặn người dùng thường tạo công việc
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền tạo công việc mới.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'created_by' => Auth::id(),
            'assigned_to' => $validated['assigned_to'] ?? Auth::id(),
        ]);

        Auth::user()->notify(new TaskActivityNotification($task, 'tạo mới'));

        return redirect()->back()->with('success', 'Đã tạo công việc mới thành công!');
    }

    public function update(Request $request, Task $task)
    {
        // Kiểm tra quyền sở hữu công việc trước khi cho phép sửa
        if ($task->assigned_to !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không được giao công việc này.');
        }

        if (Auth::user()->role !== 'admin') {
            // USER thường CHỈ ĐƯỢC phép sửa cột trạng thái (status)
            $validated = $request->validate([
                'status' => 'required|in:pending,in_progress,completed',
            ]);

            $task->update([
                'status' => $validated['status'],
            ]);

            Auth::user()->notify(new TaskActivityNotification($task, 'cập nhật trạng thái'));

            return redirect()->back()->with('success', 'Đã cập nhật trạng thái công việc thành công!');
        }

        // ADMIN được sửa toàn bộ trường
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);

        Auth::user()->notify(new TaskActivityNotification($task, 'cập nhật'));

        return redirect()->back()->with('success', 'Đã cập nhật công việc thành công!');
    }

    public function destroy(Task $task)
    {
        // Chặn người dùng thường xóa công việc
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa công việc.');
        }

        Auth::user()->notify(new TaskActivityNotification($task, 'xóa'));

        $task->delete();

        return redirect()->back()->with('success', 'Đã xóa công việc!');
    }

    public function clearStatus(Request $request)
    {
        // Chặn người dùng thường dọn dẹp cột công việc
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền dọn dẹp công việc.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        Task::where('status', $validated['status'])->delete();

        return redirect()->back()->with('success', 'Đã xóa toàn bộ công việc trong cột!');
    }
}