# Báo cáo tổng quan mã nguồn — cinema-management

Ngày tạo: 2026-02-03

## 1. Tổng quan
- Loại dự án: Laravel web application (skeleton từ `laravel/laravel`).
- Mục tiêu: Hệ thống quản lý rạp chiếu phim — quản lý phim, rạp, phòng, suất chiếu, đặt vé, hỗ trợ.

## 2. Thư mục chính
- `app/` — mã nguồn chính (Controllers, Models, Providers, View Components).
- `routes/` — định nghĩa route: `web.php`, `auth.php`, `console.php`.
- `resources/views/` — giao diện Blade, gồm layout, partials, components, pages.
- `database/migrations/` — migration tạo các bảng (movies, theaters, rooms, showtimes, bookings, comments, support_tickets/replies, sessions...).
- `database/seeders/` — seed dữ liệu mẫu (UserSeeder, MovieSeeder, TheaterSeeder, RoomSeeder, ShowtimeSeeder, CommentSeeder, BookingSeeder, DatabaseSeeder).
- `public/` — assets tĩnh (css, js, img, fonts).
- `tests/` — chứa test skeleton.

## 3. Dependencies chính
- PHP >= 8.2
- Laravel framework `^12.0`
- `barryvdh/laravel-dompdf` (PDF xuất vé)
- `simplesoftwareio/simple-qrcode` (QR code cho vé)
- Dev: `fakerphp/faker`, `laravel/breeze`, `laravel/pint`, `phpunit/phpunit` 等
(Chi tiết trong `composer.json`.)

## 4. Models (tồn tại trong `app/Models`)
- `Movie`
- `Room`
- `Showtime`
- `News`
- `Comment`
- `Booking`
- `User`
- `Theater`
- `SupportTicket`
- `SupportReply`

Những model này phản ánh domain chính: phim → rạp → phòng → suất chiếu → đặt vé; kèm comment và hệ thống support.

## 5. Controllers (chính)
Các controller nằm ở `app/Http/Controllers/` bao gồm (chỉ liệt kê file chính):
- `HomeController`, `DashboardController`, `ProfileController`, `MovieController`, `TheaterController`, `RoomController`, `ShowtimeController`, `BookingController`, `CommentController`, `AboutmeController`
- `SupportTicketController`, `SupportReplyController`
- Admin namespace: `Admin\StaffAccountController`
- Auth controllers (register/login/password/email verification) trong `Auth`.

Chức năng chính: CRUD cho movies/theaters/rooms/showtimes, booking flow (choose → create → payment preview → store), xuất vé QR/PDF, support tickets, user profile, admin/staff dashboards.

## 6. Routes chính (`routes/web.php`)
Tóm tắt các nhóm route chính:
- Public: `/` (home), `/movies`, `/movies/{movie}`, `/theaters`, `/theaters/{theater}`, `/showtimes`, `/showtimes/{showtime}`, `/about`.
- Authenticated users (`middleware: auth`): `/dashboard`, profile routes, booking flow (`/bookings/choose`, `/bookings/create/{showtime}`, `/bookings`), user history `/my-bookings`, `/my-bookings/{id}/qr`, `/my-bookings/{id}/pdf`, post comment `/movies/{movie}/comments`.
- Admin (`middleware: auth, admin`, prefix `admin`): admin dashboard, revenue, resource controllers for `movies`, `theaters`, `rooms`, `showtimes`, `bookings` (view/manage), `comments`, `staffs`.
- Staff (`middleware: auth, staff`, prefix `staff`): staff dashboard, bookings management, confirm booking action (`POST /staff/bookings/{booking}/confirm`), scan QR (`GET /staff/scan/{booking_code}`).
- Support (`prefix support`): ticket creation, listing, reply.

Routes theo tên (route names) đều đặt rõ ràng (`movies.index`, `bookings.create`, `admin.movies.*`, v.v.).

## 7. Database (migrations & seeders)
- Migrations chính có trong `database/migrations/` tạo các bảng: users, movies, theaters, rooms, showtimes, bookings, comments, sessions, support_tickets, support_replies, plus một số migration bổ sung (status, seat_layout, total_rooms).
- Seeders: `DatabaseSeeder`, `UserSeeder`, `MovieSeeder`, `TheaterSeeder`, `RoomSeeder`, `ShowtimeSeeder`, `CommentSeeder`, `BookingSeeder` — cho phép khởi tạo dữ liệu demo để testing.

## 8. Views & frontend
- Blade layouts: `layouts/app.blade.php`, `layouts/navigation`, `layouts/guest`.
- Components tái sử dụng nằm trong `resources/views/components/` (buttons, inputs, nav-link, modal...).
- Views theo chức năng: movies, showtimes, rooms, bookings (bao gồm QR / PDF / payment), profile, support, staff/admin pages.
- Public assets (`public/css`, `public/js`, `public/img`, `public/fonts`) chứa CSS tĩnh và hình ảnh phim.
- Frontend build config: `vite.config.js`, `package.json` tồn tại cho npm tasks.

## 9. Tests
- Thư mục `tests/` có `TestCase.php` và skeleton cho `Feature` / `Unit`. (Chưa thấy nhiều test cụ thể trong scan.)

## 10. Scripts & cách chạy (local)
Các lệnh cơ bản để bật dev env (suất chạy trên Windows / WSL / Linux):

```bash
composer install
cp .env.example .env
php artisan key:generate
# Thiết lập DB (ví dụ .env chỉnh DB), sau đó:
php artisan migrate
php artisan db:seed
npm install
npm run dev
php artisan serve
```

Hoặc dùng script `composer run dev` (xem `composer.json` -> script `dev`) để chạy nhiều tiến trình đồng thời.

## 11. Ghi chú kỹ thuật & khuyến nghị
- Xác thực/Phân quyền: Có 3 role chính `admin`, `staff`, `auth user` — kiểm tra middleware `admin`/`staff` để đảm bảo an toàn.
- Xuất vé: sử dụng `barryvdh/laravel-dompdf` + `simple-qrcode`; kiểm tra giới hạn kích thước PDF và encoding cho tên phim/tiếng Việt.
- Dữ liệu phòng/chỗ ngồi: migration `add_seat_layout_to_rooms_table` cho thấy có cấu trúc ghế; review logic reserve seat để tránh race conditions (dùng transaction, row locking khi book).
- Tests: hiện tại ít test — nên thêm test quan trọng cho booking flow (concurrency), payment preview, QR scan/validation.
- Env & secrets: đảm bảo `.env` không lên repo; cấu hình mail, queue, storage (public) cho tính năng xuất vé và gửi email xác nhận.

## 12. Các tập tin đáng chú ý để review tiếp
- [routes/web.php](routes/web.php) — routing chính và flow.
- [composer.json](composer.json) — dependencies.
- `app/Models/*` và `app/Http/Controllers/*` — domain logic.
- `database/migrations/*` và `database/seeders/*` — cấu trúc DB và dữ liệu demo.

---
Báo cáo này là tóm tắt hành chính dựa trên phân tích cấu trúc file. Nếu bạn muốn, tôi có thể:
- sinh một bản báo cáo chi tiết hơn với danh sách method cho mỗi controller và các thuộc tính/quan hệ cho mỗi model;
- chạy static analysis (phát hiện security issues) hoặc tạo checklist để nâng cao chất lượng code.

Bạn muốn tôi tiếp tục với bước nào?