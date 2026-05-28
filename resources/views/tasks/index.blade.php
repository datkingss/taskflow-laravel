<x-app-layout>
    <x-slot name="header">
        Quản lý công việc (Kanban Board)
    </x-slot>

    <div class="max-w-[95%] mx-auto h-[calc(100vh-140px)] flex flex-col py-6">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Tất cả công việc</h2>
            <button @click="$dispatch('open-modal', 'create-task')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                + Thêm công việc
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-1 min-h-0">
            
            <div class="bg-gray-100/70 rounded-xl p-4 border border-gray-200 flex flex-col h-full">
                <div class="flex items-center mb-4 pb-2 border-b border-gray-200 shrink-0">
                    <div class="w-3 h-3 rounded-full bg-gray-400 mr-3"></div>
                    <h4 class="font-bold text-gray-700 text-base flex-1">Chờ xử lý</h4>
                    <span class="bg-gray-200 text-gray-600 text-xs font-bold px-2.5 py-1 rounded-full">{{ $pendingTasks->count() }}</span>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-3">
                    @forelse($pendingTasks as $task)
                    <div x-data='{ taskData: @json($task) }' @click="$dispatch('open-edit-modal', taskData)" class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer hover:border-indigo-400 hover:shadow-md transition-all">
                        <h5 class="text-sm font-semibold text-gray-800 mb-3">{{ $task->title }}</h5>
                        <div class="flex justify-between items-center text-xs font-medium mt-4">
                            <span class="bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-md">Task</span>
                            <span class="text-gray-500 flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Chưa có' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-sm text-gray-400 py-8 border-2 border-dashed border-gray-200 rounded-lg">Chưa có công việc nào</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-gray-100/70 rounded-xl p-4 border border-gray-200 flex flex-col h-full">
                <div class="flex items-center mb-4 pb-2 border-b border-gray-200 shrink-0">
                    <div class="w-3 h-3 rounded-full bg-orange-400 mr-3"></div>
                    <h4 class="font-bold text-gray-700 text-base flex-1">Đang làm</h4>
                    <span class="bg-orange-100 text-orange-600 text-xs font-bold px-2.5 py-1 rounded-full">{{ $inProgressTasks->count() }}</span>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-3">
                    @forelse($inProgressTasks as $task)
                    <div x-data='{ taskData: @json($task) }' @click="$dispatch('open-edit-modal', taskData)" class="bg-white p-4 rounded-lg shadow-sm border border-orange-100 border-l-4 border-l-orange-400 cursor-pointer hover:shadow-md transition-all">
                        <h5 class="text-sm font-semibold text-gray-800 mb-3">{{ $task->title }}</h5>
                        <div class="flex justify-between items-center text-xs font-medium mt-4">
                            <span class="bg-orange-50 text-orange-700 px-2.5 py-1 rounded-md">Task</span>
                            <span class="text-gray-500">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Chưa có' }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-sm text-gray-400 py-8 border-2 border-dashed border-gray-200 rounded-lg">Chưa có công việc nào</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-gray-100/70 rounded-xl p-4 border border-gray-200 flex flex-col h-full">
                <div class="flex items-center mb-4 pb-2 border-b border-gray-200 shrink-0">
                    <div class="w-3 h-3 rounded-full bg-green-400 mr-3"></div>
                    <h4 class="font-bold text-gray-700 text-base flex-1">Hoàn thành</h4>
                    <span class="bg-green-100 text-green-600 text-xs font-bold px-2.5 py-1 rounded-full">{{ $completedTasks->count() }}</span>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-3">
                    @forelse($completedTasks as $task)
                    <div x-data='{ taskData: @json($task) }' @click="$dispatch('open-edit-modal', taskData)" class="bg-white p-4 rounded-lg shadow-sm border border-green-100 border-l-4 border-l-green-400 cursor-pointer hover:shadow-md transition-all opacity-80">
                        <h5 class="text-sm font-semibold text-gray-800 line-through mb-3">{{ $task->title }}</h5>
                        <div class="flex justify-between items-center text-xs font-medium mt-4">
                            <span class="bg-green-50 text-green-700 px-2.5 py-1 rounded-md">Done</span>
                            <span class="text-gray-500">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Chưa có' }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-sm text-gray-400 py-8 border-2 border-dashed border-gray-200 rounded-lg">Chưa có công việc nào</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
    <x-task-modals />
</x-app-layout>