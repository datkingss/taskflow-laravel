<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-dark" id="createTaskModalLabel">Tạo công việc mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold small text-muted">Tiêu đề công việc</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="VD: Thiết kế giao diện..." required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold small text-muted">Mô tả</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Chi tiết công việc..."></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold small text-muted">Trạng thái</label>
                            <select id="status" name="status" class="form-select">
                                <option value="pending">Chờ xử lý</option>
                                <option value="in_progress">Đang làm</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="due_date" class="form-label fw-semibold small text-muted">Hạn chót</label>
                            <input type="date" id="due_date" name="due_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-primary">Lưu công việc</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark" id="editTaskModalLabel">Chi tiết công việc</h5>
                @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="d-flex align-items-center gap-2 ms-auto me-2">
                    <!-- Delete Form inside header -->
                    <form id="deleteTaskForm" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa công việc này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fa-regular fa-trash-can"></i> Xóa
                        </button>
                    </form>
                </div>
                @endif
                <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTaskForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label fw-semibold small text-muted">Tiêu đề công việc</label>
                        <input type="text" id="edit_title" name="title" class="form-control" required @if(auth()->user()->role !== 'admin') readonly @endif>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label fw-semibold small text-muted">Mô tả</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="3" @if(auth()->user()->role !== 'admin') readonly @endif></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_status" class="form-label fw-semibold small text-muted">Trạng thái</label>
                            <select id="edit_status" name="status" class="form-select">
                                <option value="pending">Chờ xử lý</option>
                                <option value="in_progress">Đang làm</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_due_date" class="form-label fw-semibold small text-muted">Hạn chót</label>
                            <input type="date" id="edit_due_date" name="due_date" class="form-control" @if(auth()->user()->role !== 'admin') readonly disabled @endif>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS helper to open edit modal and fill fields -->
<script>
    function openEditTaskModal(task) {
        document.getElementById('editTaskForm').action = '/tasks/' + task.id;
        const deleteForm = document.getElementById('deleteTaskForm');
        if (deleteForm) {
            deleteForm.action = '/tasks/' + task.id;
        }
        
        // Populate inputs
        document.getElementById('edit_title').value = task.title;
        document.getElementById('edit_description').value = task.description || '';
        document.getElementById('edit_status').value = task.status;
        if (task.due_date) {
            const dateOnly = task.due_date.split(' ')[0].split('T')[0];
            document.getElementById('edit_due_date').value = dateOnly;
        } else {
            document.getElementById('edit_due_date').value = '';
        }
        
        // Show modal using Bootstrap JS API
        const editModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
        editModal.show();
    }

    // Add support for window event listener (used by calendar event clicks)
    window.addEventListener('open-edit-modal', function(e) {
        const taskData = e.detail;
        if (taskData) {
            openEditTaskModal(taskData);
        }
    });
</script>