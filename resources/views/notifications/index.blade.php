<x-app-layout>
    <x-slot name="header">
        Thông báo của bạn
    </x-slot>

    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-800">Tất cả thông báo</h2>
                
                @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-4 py-2 rounded-lg transition-colors">
                        Đánh dấu đã đọc tất cả
                    </button>
                </form>
                @endif
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                <div class="p-4 flex items-start {{ $notification->unread() ? 'bg-indigo-50/30' : 'bg-white' }} hover:bg-gray-50 transition-colors">
                    
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $notification->unread() ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    
                    <div class="ml-4 flex-1">
                        <p class="text-sm text-gray-800 {{ $notification->unread() ? 'font-bold' : 'font-medium' }}">
                            {{ $notification->data['message'] }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>

                    @if($notification->unread())
                        <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full mt-2 ml-2"></div>
                    @endif
                </div>
                @empty
                <div class="p-12 text-center text-gray-500 flex flex-col items-center">
                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    Bạn không có thông báo nào.
                </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $notifications->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>