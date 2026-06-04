<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
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
                    <div class="mt-3">
                        <label for="attachment" class="form-label fw-semibold small text-muted">File đính kèm (PDF, DOCX, JPG, PNG - tối đa 2MB)</label>
                        <input type="file" id="attachment" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
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
            <form id="editTaskForm" method="POST" enctype="multipart/form-data">
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
                            <select id="edit_status" name="status" class="form-select" onchange="updateStatusViaAjax()">
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
                    @if(auth()->user()->role === 'admin')
                    <div class="mt-3">
                        <label for="edit_attachment" class="form-label fw-semibold small text-muted">File đính kèm (PDF, DOCX, JPG, PNG - tối đa 2MB)</label>
                        <input type="file" id="edit_attachment" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div id="currentAttachment" class="mt-2 small text-muted"></div>
                    </div>
                    @else
                    <div id="userCurrentAttachment" class="mt-3" style="display:none;">
                        <label class="form-label fw-semibold small text-muted">File đính kèm</label>
                        <a href="#" id="userAttachmentLink" class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fa-solid fa-download me-1"></i> <span id="userAttachmentName"></span>
                        </a>
                    </div>
                    @endif
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateTask">Cập nhật</button>
                    <span id="statusUpdateSpinner" class="ms-2 d-none">
                        <span class="spinner-border spinner-border-sm text-success" role="status" style="width:14px;height:14px;"></span>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS helper to open edit modal and fill fields -->
<script>
    let currentTaskId = null;

    function openEditTaskModal(task) {
        currentTaskId = task.id;
        document.getElementById('editTaskForm').action = '/tasks/' + task.id;
        const deleteForm = document.getElementById('deleteTaskForm');
        if (deleteForm) {
            deleteForm.action = '/tasks/' + task.id;
        }
        
        // Populate inputs
        document.getElementById('edit_title').value = task.title;
        document.getElementById('edit_description').value = task.description || '';
        document.getElementById('edit_status').value = task.status;
        document.getElementById('edit_status').setAttribute('data-original-status', task.status);
        if (task.due_date) {
            const dateOnly = task.due_date.split(' ')[0].split('T')[0];
            document.getElementById('edit_due_date').value = dateOnly;
        } else {
            document.getElementById('edit_due_date').value = '';
        }
        
        // Hiển thị file đính kèm hiện tại (nếu có)
        const attachDiv = document.getElementById('currentAttachment');
        if (attachDiv) {
            if (task.attachment_name) {
                attachDiv.innerHTML = '<i class="fa-solid fa-paperclip me-1"></i> File hiện tại: <a href="/tasks/' + task.id + '/download" class="text-primary fw-semibold">' + task.attachment_name + '</a>';
            } else {
                attachDiv.innerHTML = '';
            }
        }
        // Hiển thị link tải file cho user thường
        const userAttachDiv = document.getElementById('userCurrentAttachment');
        const userAttachLink = document.getElementById('userAttachmentLink');
        const userAttachName = document.getElementById('userAttachmentName');
        if (userAttachDiv && task.attachment_name) {
            userAttachDiv.style.display = 'block';
            userAttachLink.href = '/tasks/' + task.id + '/download';
            userAttachName.textContent = task.attachment_name;
        } else if (userAttachDiv) {
            userAttachDiv.style.display = 'none';
        }
        
        // Show modal using Bootstrap JS API
        const editModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
        editModal.show();
    }

    // AJAX: Cập nhật trạng thái task không reload trang
    function updateStatusViaAjax() {
        const statusSelect = document.getElementById('edit_status');
        const newStatus = statusSelect.value;
        const originalStatus = statusSelect.getAttribute('data-original-status');
        
        if (newStatus === originalStatus || !currentTaskId) return;
        
        const spinner = document.getElementById('statusUpdateSpinner');
        const btn = document.getElementById('btnUpdateTask');
        
        spinner.classList.remove('d-none');
        btn.disabled = true;
        
        fetch('/tasks/' + currentTaskId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusSelect.setAttribute('data-original-status', newStatus);
                // Hiển thị toast thông báo
                showToast(data.message, 'success');
                // Reload trang sau 1.5s để cập nhật Kanban board
                setTimeout(() => location.reload(), 1500);
            } else {
                statusSelect.value = originalStatus;
                showToast(data.message || 'Có lỗi xảy ra!', 'danger');
            }
        })
        .catch(error => {
            statusSelect.value = originalStatus;
            showToast('Lỗi kết nối! Vui lòng thử lại.', 'danger');
        })
        .finally(() => {
            spinner.classList.add('d-none');
            btn.disabled = false;
        });
    }

    // Toast notification helper
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = 'alert alert-' + type + ' position-fixed top-0 end-0 m-3 shadow-sm py-2 px-3';
        toast.style.zIndex = '9999';
        toast.style.fontSize = '0.8rem';
        toast.style.transition = 'all 0.5s';
        toast.innerHTML = message + '<button type="button" class="btn-close btn-close-sm ms-2" data-bs-dismiss="alert"></button>';
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500);
        }, 2000);
    }

    // Add support for window event listener (used by calendar event clicks)
    window.addEventListener('open-edit-modal', function(e) {
        const taskData = e.detail;
        if (taskData) {
            openEditTaskModal(taskData);
        }
    });
</script>