<x-app-layout>
    <x-slot name="header">
        Báo cáo tổng hợp
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 space-y-6 px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="text-sm font-semibold text-gray-500 mb-1">Tổng công việc</div>
                <div class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="text-sm font-semibold text-gray-500 mb-1">Hoàn thành</div>
                <div class="text-3xl font-bold text-green-600">{{ $stats['completed'] }}</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="text-sm font-semibold text-gray-500 mb-1">Đang thực hiện</div>
                <div class="text-3xl font-bold text-orange-500">{{ $stats['in_progress'] }}</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="text-sm font-semibold text-gray-500 mb-1">Chờ xử lý</div>
                <div class="text-3xl font-bold text-indigo-600">{{ $stats['pending'] }}</div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-gray-50/50 gap-4">
                <h3 class="text-base font-bold text-gray-800">Chi tiết tất cả công việc</h3>
                
                <a href="{{ route('reports.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Xuất file CSV (Excel)
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                            <th class="p-4 font-bold">Tên công việc</th>
                            <th class="p-4 font-bold text-center">Trạng thái</th>
                            <th class="p-4 font-bold text-center">Hạn chót</th>
                            <th class="p-4 font-bold text-right">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="p-4 text-sm font-semibold text-gray-800">{{ $task->title }}</td>
                                <td class="p-4 text-center">
                                    @if($task->status == 'completed')
                                        <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded font-bold">Hoàn thành</span>
                                    @elseif($task->status == 'in_progress')
                                        <span class="bg-orange-100 text-orange-700 text-xs px-2.5 py-1 rounded font-bold">Đang làm</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded font-bold">Chờ xử lý</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center text-sm text-gray-500">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y H:i') : '--' }}</td>
                                <td class="p-4 text-right text-sm text-gray-500">{{ $task->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-8 text-center text-gray-400 text-sm">Chưa có dữ liệu công việc nào.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</x-app-layout>