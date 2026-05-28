<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskFlow') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased flex h-screen overflow-hidden bg-gray-50">
        
        <aside class="w-64 bg-[#1e1e2d] text-white flex flex-col hidden md:flex shrink-0">
            <div class="h-16 flex items-center px-6 border-b border-gray-700/50">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg mr-3 shadow-lg shadow-indigo-500/30"></div>
                <span class="text-xl font-bold tracking-wide">TaskFlow</span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
                
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 mt-2 px-2">Tổng quan</div>
                
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg group transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-400' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    <span class="font-medium">Trang chủ</span>
                </a>

                <a href="{{ route('tasks.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-lg group transition-colors mt-1 {{ request()->routeIs('tasks.*') ? 'bg-indigo-600/20 text-indigo-400' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    <span class="font-medium">Công việc</span>
                    <span class="bg-indigo-600 text-white text-xs px-2 py-0.5 rounded-full">Toàn bộ</span>
                </a>

                <a href="{{ route('calendar.index') }}" class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mt-1 {{ request()->routeIs('calendar.*') ? 'bg-indigo-600/20 text-indigo-400' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    <span class="font-medium">Lịch</span>
                </a>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 mt-6 px-2">Quản lý</div>
                
                <a href="{{ route('teams.index') }}" class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mt-1 {{ request()->routeIs('teams.*') ? 'bg-indigo-600/20 text-indigo-400' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    <span class="font-medium">Nhóm</span>
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2.5 rounded-lg group transition-colors mt-1 {{ request()->routeIs('reports.*') ? 'bg-indigo-600/20 text-indigo-400' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    <span class="font-medium">Báo cáo</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-lg group transition-colors mt-1 {{ request()->routeIs('notifications.*') ? 'bg-indigo-600/20 text-indigo-400' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}">
                    <span class="font-medium">Thông báo</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="bg-indigo-600 text-white text-xs px-2 py-0.5 rounded-full shadow-sm">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 mt-6 px-2">Hệ thống</div>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-gray-400 hover:bg-gray-800 hover:text-gray-200 rounded-lg group transition-colors">
                    <span class="font-medium">Cài đặt</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-700/50">
                <div class="flex items-center px-2">
                    <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-sm shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">Admin</p> 
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full text-left px-2 text-xs text-gray-500 hover:text-red-400 transition-colors">Đăng xuất</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 bg-white">
            
            <header class="h-16 border-b border-gray-100 flex items-center justify-between px-8 shrink-0 bg-white">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ $header ?? 'Dashboard' }}
                    </h2>
                </div>
                
                <div class="flex items-center">
                    <a href="{{ route('notifications.index') }}" class="relative p-2 mr-4 text-gray-400 hover:text-indigo-600 transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>

                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border-2 border-white"></span>
                            </span>
                        @endif
                    </a>

                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-task')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm shadow-indigo-600/30">
                        Tạo task
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50/50">
                {{ $slot }}
            </main>
        </div>
        
    </body>
</html>