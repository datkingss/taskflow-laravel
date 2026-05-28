<x-app-layout>
    <x-slot name="header">
        Phòng làm việc nhóm: {{ $team->name }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h2 class="text-xl font-bold text-gray-800">{{ $team->name }}</h2>
                    <span class="text-xs font-mono bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-md font-bold">Mã Nhóm (ID): {{ $team->id }}</span>
                </div>
                <p class="text-sm text-gray-500">{{ $team->description ?? 'Chưa có mô tả mục tiêu nhóm.' }}</p>
            </div>
            <a href="{{ route('teams.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 bg-gray-100 px-4 py-2 rounded-lg transition-colors shrink-0">&larr; Quay lại</a>
        </div>

        @if($team->created_by === auth()->id())
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm h-fit">
                <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wide">Mời thành viên mới</h3>
                <form action="{{ route('teams.invite', $team->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="email" name="email" placeholder="Nhập email người muốn mời..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm" required>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg text-sm font-semibold transition-colors">Gửi lời mời</button>
                </form>
                @if(session('success')) <p class="text-xs text-green-600 mt-2 font-medium">{{ session('success') }}</p> @endif
                @if(session('error')) <p class="text-xs text-red-600 mt-2 font-medium">{{ session('error') }}</p> @endif
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm lg:col-span-2 flex flex-col min-h-[160px]">
                <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wide">Yêu cầu gia nhập chờ phê duyệt ({{ $pendingRequests->count() }})</h3>
                <div class="divide-y divide-gray-100 flex-1">
                    @forelse($pendingRequests as $user)
                    <div class="py-3 flex justify-between items-center first:pt-0 last:pb-0">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $user->email }}</p>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('teams.approve', [$team->id, $user->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg">Duyệt</button>
                            </form>
                            <form action="{{ route('teams.remove', [$team->id, $user->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold px-3 py-1.5 rounded-lg">Từ chối</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-xs text-gray-400 py-6 my-auto">Chưa có ai gửi yêu cầu xin gia nhập nhóm này.</div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden lg:col-span-2">
                <div class="p-4 bg-gray-50/50 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Thành viên chính thức ({{ $members->count() }})</h3>
                </div>
                <div class="divide-y divide-gray-100 p-6 pt-0">
                    @foreach($members as $member)
                    <div class="py-4 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center text-sm font-bold text-gray-600">
                                {{ substr($member->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $member->name }}</p>
                                <p class="text-xs text-gray-400">{{ $member->email }}</p>
                            </div>
                        </div>
                        <div>
                            @if($member->id === $team->created_by)
                                <span class="bg-indigo-50 text-indigo-600 text-xs px-2.5 py-1 rounded-md font-bold">Trưởng nhóm</span>
                            @else
                                @if($team->created_by === auth()->id())
                                <form action="{{ route('teams.remove', [$team->id, $member->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn kích thành viên này khỏi nhóm?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700">Trục xuất</button>
                                </form>
                                @else
                                <span class="text-xs font-medium text-gray-400">Thành viên</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($team->created_by === auth()->id())
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                <div class="p-4 bg-gray-50/50 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Lời mời đang chờ phản hồi ({{ $sentInvites->count() }})</h3>
                </div>
                <div class="divide-y divide-gray-100 p-6 pt-0 flex-1 flex flex-col justify-center">
                    @forelse($sentInvites as $invitedUser)
                    <div class="py-3 flex justify-between items-center">
                        <div class="truncate mr-2">
                            <p class="text-sm font-medium text-gray-700 truncate">{{ $invitedUser->email }}</p>
                            <p class="text-xs text-gray-400">Chờ đồng ý...</p>
                        </div>
                        <form action="{{ route('teams.remove', [$team->id, $invitedUser->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-gray-400 hover:text-red-500 font-semibold">Hủy mời</button>
                        </form>
                    </div>
                    @empty
                    <div class="text-center text-xs text-gray-400 my-auto py-6">Không có lời mời treo nào.</div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>