Markdown
# 🚀 TaskFlow - Hệ thống Quản lý Công việc & Cộng tác Nhóm

TaskFlow là một ứng dụng web mạnh mẽ được xây dựng bằng Laravel, giúp cá nhân và tổ chức quản lý dự án, theo dõi tiến độ công việc và cộng tác nhóm một cách trực quan, hiệu quả.

## ✨ Tính năng nổi bật

* **Bảng Kanban (Kanban Board):** Trực quan hóa tiến độ công việc theo các cột trạng thái (Chờ xử lý, Đang làm, Hoàn thành).
* **Lịch công việc (Calendar):** Tích hợp FullCalendar giúp theo dõi deadline dưới dạng lưới thời gian (Tháng/Tuần).
* **Quản lý Nhóm (Team Workspace):** * Khởi tạo phòng làm việc cho từng dự án.
    * Mời thành viên qua Email hoặc xin gia nhập bằng ID nhóm.
    * Hệ thống phê duyệt/từ chối lời mời chặt chẽ.
* **Báo cáo & Thống kê (Reports):** Tự động tổng hợp số liệu công việc và hỗ trợ xuất báo cáo ra file Excel (CSV).
* **Hệ thống Thông báo (Notifications):** Thông báo theo thời gian thực khi có lời mời, phê duyệt nhóm hoặc báo cáo mới.

## 🛠️ Công nghệ sử dụng

* **Backend:** [Laravel](https://laravel.com/) (PHP)
* **Frontend:** [Tailwind CSS](https://tailwindcss.com/) & [Alpine.js](https://alpinejs.dev/)
* **Database:** MySQL
* **Libraries:** FullCalendar (Giao diện lịch)

## ⚙️ Hướng dẫn cài đặt (Local Development)

Làm theo các bước sau để chạy dự án trên máy tính của bạn:

**1. Clone dự án về máy:**
```bash
git clone [https://github.com/datkingss/taskflow-laravel.git](https://github.com/datkingss/taskflow-laravel.git)
cd taskflow-laravel
2. Cài đặt các thư viện cần thiết:

Bash
composer install
npm install
3. Thiết lập môi trường:

Copy file .env.example thành .env:

Bash
cp .env.example .env
Mở file .env và cấu hình kết nối Database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

Tạo khóa bảo mật cho ứng dụng:

Bash
php artisan key:generate
4. Khởi tạo Cơ sở dữ liệu:

Bash
php artisan migrate
5. Khởi động Server:
Mở 2 cửa sổ Terminal và chạy song song 2 lệnh sau:

Bash
php artisan serve
Bash
npm run dev
Ứng dụng sẽ hoạt động tại địa chỉ: http://localhost:8000

👨‍💻 Tác giả
Hoàng Quảng Đạt - Fullstack Developer
