<x-app-layout>
    <x-slot name="header">
        Quản lý Nhóm làm việc
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 space-y-8 px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-center bg-white border border-gray-100 rounded-xl p-4 shadow-sm gap-4">
            <form action="{{ route('teams.join') }}" method="POST" class="flex items-center w-full sm:w-auto gap-2">
                @csrf
                <input type="number" name="team_id" placeholder="Nhập ID Nhóm muốn xin vào..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm bg-gray-50/50 w-full sm:w-64" required>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-semibold hover:bg-gray-900 transition-colors shrink-0">Xin gia nhập</button>
            </form>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-team')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center shrink-0 w-full sm:w-auto justify-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tạo nhóm mới
            </button>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg text-sm font-medium">{{ session('error') }}</div>
        @endif
        @if(session('with_id_success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg text-sm font-medium">{{ session('with_id_success') }}</div>
        @endif

        @if($pendingInvites->count() > 0)
        <div class="bg-orange-50/60 border border-orange-200 rounded-xl p-6 animate-pulse-once">
            <h3 class="text-base font-bold text-orange-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                Bạn nhận được lời mời vào nhóm ({{ $pendingInvites->count() }})
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($pendingInvites as $team)
                <div class="bg-white rounded-xl p-4 shadow-sm border border-orange-100 flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">{{ $team->name }}</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Mời bởi: <span class="font-medium text-gray-700">{{ $team->creator->name }}</span></p>
                    </div>
                    <div class="flex space-x-2">
                        <form action="{{ route('teams.accept', $team->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition-colors">Đồng ý</button>
                        </form>
                        <form action="{{ route('teams.remove', [$team->id, auth()->id()]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-lg transition-colors">Từ chối</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center justify-between border-b pb-2">
                    <span>Nhóm do tôi quản lý</span>
                    <span class="text-xs font-semibold bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full">{{ $myTeams->count() }} nhóm</span>
                </h3>
                <div class="space-y-4">
                    @forelse($myTeams as $team)
                    <div onclick="window.location='{{ route('teams.show', $team->id) }}'" class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-indigo-100 transition-all cursor-pointer group">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-base font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $team->name }}</h4>
                            <span class="text-xs font-mono text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded">ID: {{ $team->id }}</span>
                        </div>
                        <p class="text-xs text-gray-500 line-clamp-2 mb-4 h-8">{{ $team->description ?? 'Chưa có mô tả mục tiêu.' }}</p>
                        <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-50">
                            <span class="text-gray-400">Thành viên: <strong class="text-gray-700">{{ $team->members()->wherePivot('status', 'active')->count() }}</strong></span>
                            <span class="text-indigo-600 font-semibold group-hover:underline">Quản lý thành viên &rarr;</span>
                        </div>
                    </div>
                    @empty
                    <div class="bg-gray-50/50 rounded-xl border border-dashed border-gray-200 p-8 text-center text-sm text-gray-400">Bạn chưa lập nhóm nào.</div>
                    @endforelse
                </div>
            </div>

            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center justify-between border-b pb-2">
                    <span>Nhóm tôi đã gia nhập</span>
                    <span class="text-xs font-semibold bg-green-50 text-green-600 px-2 py-0.5 rounded-full">{{ $joinedTeams->count() }} nhóm</span>
                </h3>
                <div class="space-y-4">
                    @forelse($joinedTeams as $team)
                    <div onclick="window.location='{{ route('teams.show', $team->id) }}'" class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md hover:border-green-100 transition-all cursor-pointer group">
                        <h4 class="text-base font-bold text-gray-800 group-hover:text-green-600 transition-colors mb-2">{{ $team->name }}</h4>
                        <p class="text-xs text-gray-500 line-clamp-2 mb-4 h-8">{{ $team->description ?? 'Chưa có mô tả.' }}</p>
                        <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-50">
                            <span class="text-gray-400">Trưởng nhóm: <strong class="text-gray-700">{{ $team->creator->name }}</strong></span>
                            <span class="text-green-600 font-semibold group-hover:underline">Vào phòng làm việc &rarr;</span>
                        </div>
                    </div>
                    @empty
                    <div class="bg-gray-50/50 rounded-xl border border-dashed border-gray-200 p-8 text-center text-sm text-gray-400">Bạn chưa là thành viên của nhóm bên ngoài nào.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <x-modal name="create-team" focusable>
        <form method="post" action="{{ route('teams.store') }}" class="p-6 bg-white rounded-xl">
            @csrf
            <h2 class="text-lg font-bold text-gray-800 mb-4">Khởi tạo nhóm làm việc mới</h2>
            <div class="space-y-4">
                <div>
                    <x-input-label for="name" value="Tên nhóm / Tên dự án" class="text-gray-700" />
                    <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm text-gray-900 bg-white" placeholder="Ví dụ: Nhóm đồ án tốt nghiệp" required>
                </div>
                <div>
                    <x-input-label for="description" value="Mô tả mục tiêu ngắn gọn" class="text-gray-700" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm text-gray-900" rows="3" placeholder="Ghi chú phân công công việc chính..."></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-lg">Hủy</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">Khởi tạo</button>
            </div>
        </form>
    </x-modal>
</x-app-layout>