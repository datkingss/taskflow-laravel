<x-app-layout>
    <x-slot name="header">
        Trang chủ
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8 py-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Tổng task</div>
                <div class="text-4xl font-bold text-gray-800">{{ $totalTasks }}</div>
                <div class="text-sm text-green-500 mt-2 font-medium">+8 tuần này</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Đang thực hiện</div>
                <div class="text-4xl font-bold text-gray-800">{{ $inProgressTasks }}</div>
                <div class="text-sm text-gray-400 mt-2 font-medium">{{ $inProgressPercent }}% tổng số</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Hoàn thành</div>
                <div class="text-4xl font-bold text-gray-800">{{ $completedTasks }}</div>
                <div class="text-sm text-green-500 mt-2 font-medium">{{ $completedPercent }}%</div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">Quá hạn</div>
                <div class="text-4xl font-bold text-red-500">{{ $overdueTasks }}</div>
                <div class="text-sm text-red-500 mt-2 font-medium">Cần xử lý ngay</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div>
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg font-bold text-gray-800">Bảng quản lý công việc</h3>
                        <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">Xem tất cả &rarr;</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-100/50 rounded-xl p-4 border border-gray-200/60 flex flex-col max-h-[500px] overflow-y-auto custom-scrollbar">
                            <div class="flex items-center mb-4 sticky top-0 bg-gray-100/90 pb-2 z-10">
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-400 mr-2"></div>
                                <h4 class="font-semibold text-gray-700 text-sm">Chờ xử lý ({{ $pendingTasksCount }})</h4>
                            </div>
                            @forelse($pendingTasksList as $task)
                            <div x-data='{ taskData: @json($task) }' @click="$dispatch('open-edit-modal', taskData)" class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-3 cursor-pointer hover:border-indigo-300 hover:shadow-md transition-all">
                                <h5 class="text-sm font-semibold text-gray-800 mb-3 line-clamp-2" title="{{ $task->title }}">{{ $task->title }}</h5>
                                <div class="flex justify-between items-center text-xs font-medium">
                                    <span class="bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-md">Task</span>
                                    <span class="text-gray-500">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m') : 'N/A' }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-sm text-gray-400 py-4">Không có task</div>
                            @endforelse
                        </div>

                        <div class="bg-gray-100/50 rounded-xl p-4 border border-gray-200/60 flex flex-col max-h-[500px] overflow-y-auto custom-scrollbar">
                            <div class="flex items-center mb-4 sticky top-0 bg-gray-100/90 pb-2 z-10">
                                <div class="w-2.5 h-2.5 rounded-full bg-orange-400 mr-2"></div>
                                <h4 class="font-semibold text-gray-700 text-sm">Đang làm ({{ $inProgressTasks }})</h4>
                            </div>
                            @forelse($inProgressTasksList as $task)
                            <div x-data='{ taskData: @json($task) }' @click="$dispatch('open-edit-modal', taskData)" class="bg-white p-4 rounded-lg shadow-sm border border-orange-100 border-b-2 border-b-orange-400 mb-3 cursor-pointer hover:shadow-md transition-all">
                                <h5 class="text-sm font-semibold text-gray-800 mb-3 line-clamp-2" title="{{ $task->title }}">{{ $task->title }}</h5>
                                <div class="flex justify-between items-center text-xs font-medium">
                                    <span class="bg-orange-50 text-orange-700 px-2.5 py-1 rounded-md">Task</span>
                                    <span class="text-gray-500">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m') : 'N/A' }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-sm text-gray-400 py-4">Không có task</div>
                            @endforelse
                        </div>

                        <div class="bg-gray-100/50 rounded-xl p-4 border border-gray-200/60 flex flex-col max-h-[500px] overflow-y-auto custom-scrollbar">
                            <div class="flex items-center mb-4 sticky top-0 bg-gray-100/90 pb-2 z-10">
                                <div class="w-2.5 h-2.5 rounded-full bg-green-400 mr-2"></div>
                                <h4 class="font-semibold text-gray-700 text-sm">Hoàn thành ({{ $completedTasks }})</h4>
                            </div>
                            @forelse($completedTasksList as $task)
                            <div x-data='{ taskData: @json($task) }' @click="$dispatch('open-edit-modal', taskData)" class="bg-white p-4 rounded-lg shadow-sm border border-green-100 border-b-2 border-b-green-400 mb-3 cursor-pointer hover:shadow-md transition-all">
                                <h5 class="text-sm font-semibold text-gray-800 mb-3 line-clamp-2" title="{{ $task->title }}">{{ $task->title }}</h5>
                                <div class="flex justify-between items-center text-xs font-medium">
                                    <span class="bg-green-50 text-green-700 px-2.5 py-1 rounded-md">Done</span>
                                    <span class="text-gray-500">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m') : 'N/A' }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-sm text-gray-400 py-4">Không có task</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg font-bold text-gray-800">Hoạt động gần đây</h3>
                        <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">Xem tất cả &rarr;</a>
                    </div>
                    
                    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm space-y-5">
                        @forelse($recentActivities as $activity)
                            <div class="flex items-center">
                                @php
                                    $colorClass = 'bg-indigo-100 border-indigo-200';
                                    if(isset($activity->data['action'])) {
                                        if($activity->data['action'] == 'cập nhật') $colorClass = 'bg-orange-100 border-orange-200';
                                        if($activity->data['action'] == 'xóa') $colorClass = 'bg-red-100 border-red-200';
                                    }
                                @endphp
                                
                                <div class="w-9 h-9 rounded-full flex-shrink-0 border {{ $colorClass }}"></div>
                                
                                <div class="ml-4 flex-1">
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold text-gray-900">{{ Auth::user()->name }}</span> 
                                        vừa {{ $activity->data['action'] ?? 'thao tác' }} task 
                                        <span class="font-medium text-indigo-600">{{ $activity->data['title'] ?? '' }}</span>
                                    </p>
                                </div>
                                <span class="text-xs font-medium text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="text-center text-sm text-gray-400 py-4">Chưa có hoạt động nào gần đây.</div>
                        @endforelse
                    </div>
                </div>

            </div> <div class="space-y-6">
                <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-800 mb-4">Tiến độ theo tuần</h3>
                    <div class="relative h-48 w-full">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-base font-bold text-gray-800 mb-4">Thống kê trạng thái công việc</h3>
                    <div class="relative h-48 w-full flex justify-center">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div> </div> </div>

    <x-task-modals />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Biểu đồ cột
            const ctxBar = document.getElementById('weeklyChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: @json($chartBarLabels),
                    datasets: [{
                        label: 'Task mới',
                        data: @json($chartBarData),
                        backgroundColor: '#4f46e5',
                        borderRadius: 4,
                        barThickness: 24
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Biểu đồ tròn
            const ctxPie = document.getElementById('distributionChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Hoàn thành', 'Đang làm', 'Quá hạn'],
                    datasets: [{
                        data: @json($chartPieData), 
                        backgroundColor: [
                            '#4ade80', // Xanh lá
                            '#fb923c', // Cam
                            '#ef4444'  // Đỏ
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%', 
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let total = context.chart._metasets[context.datasetIndex].total;
                                    let percentage = total > 0 ? Math.round((value / total) * 100) + '%' : '0%';
                                    
                                    return `${label}: ${value} task (${percentage})`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>