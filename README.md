
## Giới thiệu nhanh

- Dự án được xây dựng bằng **Laravel** (PHP) - một framework phổ biến để làm web
- Giao diện sử dụng **Bootstrap** - bộ công cụ thiết kế web của Twitter
- Dữ liệu được lưu trong **MySQL** - hệ quản trị cơ sở dữ liệu
- Chạy trên máy cá nhân thông qua **Laragon** hoặc lệnh `php artisan serve`

---

## Cách cài đặt và chạy project

Thực hiện lần lượt từng bước dưới đây trong cửa sổ Terminal (Command Prompt):

**Bước 1: Tải project về máy**

```
git clone https://github.com/datkingss/taskflow-laravel.git
cd taskflow-laravel
```

**Bước 2: Cài đặt các thư viện cần thiết**

```
composer install
npm install
```

**Bước 3: Tạo file cấu hình môi trường**

```
copy .env.example .env
php artisan key:generate
```

Sau đó mở file `.env` và điền thông tin database:
- `DB_DATABASE` = tên database (ví dụ: taskflow)
- `DB_USERNAME` = tên tài khoản MySQL (thường là `root`)
- `DB_PASSWORD` = mật khẩu MySQL (để trống nếu dùng Laragon)

**Bước 4: Import dữ liệu mẫu của nhóm**

Thay vì chạy seeder ngẫu nhiên, hãy import thẳng file database của nhóm để dùng đúng tài khoản và công việc đã có sẵn:

1. Mở **phpMyAdmin** tại địa chỉ: `http://localhost/phpmyadmin`
2. Tạo một database mới tên là `taskflow`
3. Chọn database `taskflow` vừa tạo
4. Bấm tab **Import** (Nhập)
5. Chọn file `database/taskflow_backup.sql` trong thư mục project
6. Bấm **Go** (hoặc **Thực hiện**) để import

Sau khi import xong, bạn đã có đầy đủ tài khoản và 20 công việc mẫu của nhóm.

> Lưu ý: Nếu đã tạo database rồi thì bỏ qua bước 1-2, chỉ cần vào Import trực tiếp.

**Bước 5: Khởi động ứng dụng**

Mở 2 cửa sổ Terminal, chạy mỗi lệnh trong một cửa sổ:

```
php artisan serve
```

```
npm run dev
```

Truy cập ứng dụng tại địa chỉ: **http://localhost:8000**

---

## Tài khoản đăng nhập mẫu

| Vai trò | Họ tên | Email | Mật khẩu |
|---|---|---|---|
| Quản trị viên (Admin) | Admin User | admin@example.com | password |
| Người dùng thường | Nguyen Van Thanh | xuanpq359@gmail.com | 11111111 |
| Người dùng thường | Dat | dat@gmail.com | 11111111 |
| Người dùng thường | Nghia | nghia@gmail.com | 11111111 |
| Người dùng thường | Ngoc Toan | ngoctoan@gmail.com | 11111111 |

---


Xem thêm tài liệu chi tiết trong thư mục `docs/`:
- `docs/CHUC_NANG.md` - Mô tả chi tiết từng tính năng
- `docs/DATABASE.md` - Mô tả cơ sở dữ liệu

