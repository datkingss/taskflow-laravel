<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. TẠO TÀI KHOẢN CỐ ĐỊNH
        // =============================================

        // Tài khoản Admin
        $admin = User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Tài khoản User thường - mật khẩu: 11111111
        $thanh = User::factory()->create([
            'name'     => 'Nguyen Van Thanh',
            'email'    => 'xuanpq359@gmail.com',
            'password' => Hash::make('11111111'),
            'role'     => 'user',
        ]);

        $dat = User::factory()->create([
            'name'     => 'Dat',
            'email'    => 'dat@gmail.com',
            'password' => Hash::make('11111111'),
            'role'     => 'user',
        ]);

        $nghia = User::factory()->create([
            'name'     => 'Nghia',
            'email'    => 'nghia@gmail.com',
            'password' => Hash::make('11111111'),
            'role'     => 'user',
        ]);

        $toan = User::factory()->create([
            'name'     => 'Ngoc Toan',
            'email'    => 'ngoctoan@gmail.com',
            'password' => Hash::make('11111111'),
            'role'     => 'user',
        ]);

        // =============================================
        // 2. TẠO CÔNG VIỆC CỐ ĐỊNH (20 tasks)
        // =============================================

        $tasks = [
            // --- Công việc giao cho Nguyen Van Thanh ---
            [
                'title'       => 'Thiết kế giao diện trang chủ',
                'description' => 'Vẽ wireframe và thiết kế giao diện Figma cho toàn bộ trang chủ của ứng dụng.',
                'status'      => 'in_progress',
                'due_date'    => '2026-06-01 17:00:00',
                'assigned_to' => $thanh->id,
            ],
            [
                'title'       => 'Phát triển Frontend trang Dashboard',
                'description' => 'Cắt HTML/CSS và ghép giao diện Bootstrap cho trang Dashboard chính.',
                'status'      => 'completed',
                'due_date'    => '2026-06-05 18:00:00',
                'assigned_to' => $thanh->id,
            ],
            [
                'title'       => 'Xây dựng cơ sở dữ liệu',
                'description' => 'Viết code cơ sở dữ liệu và viết các file migration cho toàn bộ hệ thống.',
                'status'      => 'pending',
                'due_date'    => '2026-06-03 18:00:00',
                'assigned_to' => $thanh->id,
            ],
            [
                'title'       => 'Viết tài liệu hướng dẫn',
                'description' => 'Viết file README.md và tài liệu đặc tả API cho toàn bộ hệ thống.',
                'status'      => 'pending',
                'due_date'    => '2026-06-10 09:00:00',
                'assigned_to' => $thanh->id,
            ],
            [
                'title'       => 'Kiểm tra giao diện mobile',
                'description' => 'Kiểm tra độ tương thích của giao diện trên các thiết bị di động khác nhau.',
                'status'      => 'pending',
                'due_date'    => '2026-06-12 17:00:00',
                'assigned_to' => $thanh->id,
            ],

            // --- Công việc giao cho Dat ---
            [
                'title'       => 'Tích hợp cổng thanh toán',
                'description' => 'Kết nối hệ thống với cổng thanh toán VNPay để xử lý giao dịch trực tuyến.',
                'status'      => 'pending',
                'due_date'    => '2026-06-04 15:00:00',
                'assigned_to' => $dat->id,
            ],
            [
                'title'       => 'Tối ưu hiệu năng truy vấn SQL',
                'description' => 'Kiểm tra các câu lệnh index và tối ưu các truy vấn lớn trong hệ thống.',
                'status'      => 'pending',
                'due_date'    => '2026-06-07 14:00:00',
                'assigned_to' => $dat->id,
            ],
            [
                'title'       => 'Cấu hình Mail Server',
                'description' => 'Thiết lập dịch vụ gửi email thông báo qua Amazon SES hoặc SMTP.',
                'status'      => 'pending',
                'due_date'    => '2026-06-07 14:00:00',
                'assigned_to' => $dat->id,
            ],
            [
                'title'       => 'Kiểm tra bảo mật hệ thống',
                'description' => 'Quét các lỗi bảo mật SQL Injection, XSS và các lỗ hổng phổ biến khác.',
                'status'      => 'pending',
                'due_date'    => '2026-06-07 14:00:00',
                'assigned_to' => $dat->id,
            ],
            [
                'title'       => 'Phân tích yêu cầu khách hàng',
                'description' => 'Họp với đội tác để chốt các yêu cầu năng cần phát triển trong giai đoạn 2.',
                'status'      => 'pending',
                'due_date'    => '2026-06-28 11:00:00',
                'assigned_to' => $dat->id,
            ],

            // --- Công việc giao cho Nghia ---
            [
                'title'       => 'Xây dựng module chat thời gian thực',
                'description' => 'Sử dụng Laravel Reverb hoặc Pusher để phát triển tính năng chat nội bộ.',
                'status'      => 'pending',
                'due_date'    => '2026-06-08 17:00:00',
                'assigned_to' => $nghia->id,
            ],
            [
                'title'       => 'Quản lý phân quyền với Spatie',
                'description' => 'Cài đặt và thiết lập Roles/Permissions cho từng nhóm người dùng trong hệ thống.',
                'status'      => 'pending',
                'due_date'    => '2026-05-29 17:00:00',
                'assigned_to' => $nghia->id,
            ],
            [
                'title'       => 'Deploy ứng dụng lên VPS',
                'description' => 'Cấu hình Nginx, SSL, Let\'s Encrypt và triển khai ứng dụng lên máy chủ VPS.',
                'status'      => 'pending',
                'due_date'    => '2026-06-08 17:00:00',
                'assigned_to' => $nghia->id,
            ],
            [
                'title'       => 'Viết Unit Test cho Module Auth',
                'description' => 'Viết các ca kiểm thử tự động cho chức năng xác thực người dùng.',
                'status'      => 'pending',
                'due_date'    => '2026-06-11 17:00:00',
                'assigned_to' => $nghia->id,
            ],
            [
                'title'       => 'Backup dữ liệu tự động',
                'description' => 'Viết cronjob tự động sao lưu database hàng ngày và lưu trữ lên cloud storage.',
                'status'      => 'pending',
                'due_date'    => '2026-05-27 23:00:00',
                'assigned_to' => $nghia->id,
            ],

            // --- Công việc giao cho Ngoc Toan ---
            [
                'title'       => 'Tích hợp Firebase Notification',
                'description' => 'Cấu hình gửi thông báo đẩy (push notification) qua Firebase Cloud Messaging.',
                'status'      => 'pending',
                'due_date'    => '2026-06-09 10:00:00',
                'assigned_to' => $toan->id,
            ],
            [
                'title'       => 'Xây dựng API cho ứng dụng di động',
                'description' => 'Thiết kế các router API và controller trả về dữ liệu JSON cho app mobile.',
                'status'      => 'pending',
                'due_date'    => '2026-05-30 16:00:00',
                'assigned_to' => $toan->id,
            ],
            [
                'title'       => 'Import/Export file Excel',
                'description' => 'Sử dụng Laravel Excel để xuất báo cáo công việc ra file .xlsx.',
                'status'      => 'pending',
                'due_date'    => '2026-06-06 16:00:00',
                'assigned_to' => $toan->id,
            ],
            [
                'title'       => 'Setup môi trường Docker',
                'description' => 'Viết file docker-compose.yml thiết lập môi trường phát triển đồng nhất cho toàn nhóm.',
                'status'      => 'pending',
                'due_date'    => '2026-06-05 13:00:00',
                'assigned_to' => $toan->id,
            ],
            [
                'title'       => 'Nghiệm thu dự án giai đoạn 1',
                'description' => 'Bàn giao các tài liệu kỹ thuật và chạy thử nghiệm toàn bộ hệ thống với khách hàng.',
                'status'      => 'pending',
                'due_date'    => '2026-05-29 09:00:00',
                'assigned_to' => $toan->id,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create([
                'title'       => $task['title'],
                'description' => $task['description'],
                'status'      => $task['status'],
                'due_date'    => $task['due_date'],
                'assigned_to' => $task['assigned_to'],
                'created_by'  => $admin->id,
            ]);
        }
    }
}