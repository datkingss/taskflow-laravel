<x-app-layout>
    <x-slot name="header">
        Lịch công việc
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div id="calendar" class="min-h-[650px] text-gray-800"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'vi', 
                firstDay: 1,  
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    // Đã thay đổi: Dùng dayGridWeek thay vì timeGridWeek để bỏ chia khung giờ
                    right: 'dayGridMonth,dayGridWeek,listMonth'
                },
                buttonText: {
                    today: 'Hôm nay',
                    month: 'Tháng',
                    week: 'Tuần',
                    list: 'Danh sách'
                },
                
                // Thêm dòng này: Ẩn luôn chữ "08:00" hiển thị trên tên công việc cho gọn
                displayEventTime: false, 

                events: @json($events), 

                eventClick: function(info) {
                    const taskData = {
                        id: info.event.id,
                        title: info.event.title,
                        description: info.event.extendedProps.description,
                        status: info.event.extendedProps.status,
                        due_date: info.event.startStr
                    };

                    window.dispatchEvent(new CustomEvent('open-edit-modal', { detail: taskData }));
                }
            });
            
            calendar.render();
        });
    </script>
    
    <x-task-modals />
</x-app-layout>