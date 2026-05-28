<x-app-layout>
    <x-slot name="header">
        Quản lý Thành viên
    </x-slot>

    <div class="container-fluid">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card Container -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="mb-0 text-dark fw-bold">Danh sách người dùng</h5>
                
                <!-- Search Form -->
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex" style="max-width: 350px;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" placeholder="Tìm theo tên, email, vai trò..." value="{{ $search ?? '' }}">
                        @if($search)
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
                            Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            <tr>
                                <th class="px-4 py-3 text-muted">ID</th>
                                <th class="py-3 text-muted">Họ và tên</th>
                                <th class="py-3 text-muted">Email</th>
                                <th class="py-3 text-muted text-center">Vai trò</th>
                                <th class="py-3 text-muted">Ngày đăng ký</th>
                                <th class="px-4 py-3 text-muted text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $u)
                                <tr>
                                    <td class="px-4 fw-semibold text-muted">#{{ $u->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center fw-bold me-3" style="width: 32px; height: 32px;">
                                                {{ strtoupper(substr($u->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark">{{ $u->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $u->email }}</td>
                                    <td class="text-center">
                                        @if($u->role === 'admin')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded text-uppercase" style="font-size: 0.7rem; font-weight: 700;">
                                                <i class="fa-solid fa-user-shield me-1"></i> Admin
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2.5 py-1.5 rounded text-uppercase" style="font-size: 0.7rem; font-weight: 700;">
                                                <i class="fa-solid fa-user me-1"></i> User
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $u->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 text-end">
                                        @if($u->id !== Auth::id() && $u->id !== 1)
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thành viên {{ $u->name }} khỏi hệ thống? Hành động này không thể hoàn tác!');" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-2">
                                                    <i class="fa-solid fa-trash-can"></i> Xóa
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">Không được phép</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-users-slash d-block fs-1 mb-3 text-secondary opacity-50"></i>
                                        Không tìm thấy người dùng nào phù hợp.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Footer Pagination -->
            @if($users->hasPages())
                <div class="card-footer bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Hiển thị <strong>{{ $users->firstItem() }}</strong> đến <strong>{{ $users->lastItem() }}</strong> trong tổng số <strong>{{ $users->total() }}</strong> thành viên
                        </div>
                        <div>
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
