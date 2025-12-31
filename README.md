# Ứng dụng Bán Sách Trực Tuyến

Ứng dụng web bán sách trực tuyến đơn giản, được xây dựng bằng PHP thuần, sử dụng MySQL, PDO và Bootstrap 5 để tạo giao diện responsive.

## Mục lục
- [Tính năng](#tính-năng)
- [Công nghệ sử dụng](#công-nghệ-sử-dụng)
- [Cài đặt](#cài-đặt)
- [Cách sử dụng](#cách-sử-dụng)
- [Cấu trúc thư mục](#cấu-trúc-thư-mục)
- [Bảo mật](#bảo-mật)
- [Lưu ý](#lưu-ý)

## Tính năng

### Phần Khách hàng:
- **Trang chủ**: Hiển thị danh sách sách nổi bật.
- **Danh sách sách**: Xem tất cả sách với phân trang.
- **Chi tiết sách**: Xem thông tin chi tiết của từng cuốn sách.
- **Tìm kiếm**: Tìm sách theo tên hoặc tác giả.
- **Giỏ hàng**: Thêm, xóa, cập nhật số lượng sách (lưu bằng session, không cần đăng nhập).
- **Thanh toán**: Nhập thông tin khách hàng và lưu đơn hàng.

### Phần Admin:
- **Đăng nhập**: Tài khoản admin để quản lý.
- **Quản lý sách**: Thêm, sửa, xóa sách (bao gồm upload ảnh).
- **Quản lý đơn hàng**: Xem danh sách đơn hàng, chi tiết và cập nhật trạng thái.

## Công nghệ sử dụng
- **Backend**: PHP thuần (không framework)
- **Database**: MySQL với PDO
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
- **Server**: XAMPP hoặc server PHP/MySQL tương tự

## Cài đặt

1. **Cài đặt môi trường**:
   - Tải và cài đặt [XAMPP](https://www.apachefriends.org/) hoặc server PHP/MySQL khác.

2. **Tạo database**:
   - Mở phpMyAdmin (thường tại `http://localhost/phpmyadmin`).
   - Tạo database mới tên `wepsach`.
   - Import file `database.sql` vào database vừa tạo để tạo bảng và dữ liệu mẫu.

3. **Cấu hình dự án**:
   - Sao chép thư mục dự án vào `htdocs` của XAMPP (ví dụ: `d:\xampp\htdocs\wepsach`).
   - Kiểm tra file `includes/config.php` để đảm bảo thông tin kết nối database chính xác (host: localhost, user: root, password: trống nếu mặc định).

4. **Thiết lập quyền thư mục**:
   - Đảm bảo thư mục `uploads` có quyền ghi (trên Windows, thường không cần thay đổi).

5. **Khởi chạy**:
   - Khởi động Apache và MySQL trong XAMPP.
   - Truy cập trang web tại: `http://localhost/wepsach/`

## Cách sử dụng

### Cho Khách hàng:
- Truy cập `http://localhost/wepsach/` để xem trang chủ.
- Duyệt sách, thêm vào giỏ hàng và thanh toán.

### Cho Admin:
- Truy cập `http://localhost/wepsach/admin/login.php`.
- Đăng nhập với tài khoản mẫu:
  - Username: `admin`
  - Password: `admin123`
- Quản lý sách và đơn hàng từ dashboard.

## Cấu trúc thư mục
```
wepsach/
├── includes/           # Các file chung
│   ├── config.php      # Cấu hình database
│   ├── functions.php   # Hàm tiện ích
│   ├── header.php      # Header của trang
│   └── footer.php      # Footer của trang
├── admin/              # Phần quản trị
│   ├── login.php
│   ├── dashboard.php
│   ├── books.php
│   ├── add_book.php
│   ├── edit_book.php
│   ├── delete_book.php
│   ├── orders.php
│   ├── order_detail.php
│   ├── update_order_status.php
│   ├── logout.php
│   ├── header.php
│   └── footer.php
├── uploads/            # Thư mục lưu ảnh sách
├── css/
│   └── style.css       # CSS tùy chỉnh
├── js/
│   └── script.js       # JavaScript tùy chỉnh
├── index.php           # Trang chủ
├── books.php           # Danh sách sách
├── book_detail.php     # Chi tiết sách
├── search.php          # Trang tìm kiếm
├── cart.php            # Giỏ hàng
├── checkout.php        # Thanh toán
├── add_to_cart.php     # Thêm vào giỏ
├── update_cart.php     # Cập nhật giỏ
├── remove_from_cart.php # Xóa khỏi giỏ
├── login.php           # Đăng nhập khách (nếu có)
├── register.php        # Đăng ký (nếu có)
├── logout.php          # Đăng xuất
├── database.sql        # File SQL tạo database
└── README.md           # Tài liệu này
```

## Bảo mật
- Mật khẩu admin được mã hóa bằng `password_hash`.
- Sử dụng PDO để ngăn chặn SQL injection.
- Validate và sanitize tất cả input từ người dùng.
- Kiểm tra file upload (định dạng ảnh, kích thước tối đa).

## Lưu ý
- Ứng dụng sử dụng session cho giỏ hàng, không yêu cầu đăng nhập khách hàng.
- Phân trang được áp dụng cho danh sách sách và đơn hàng.
- Giao diện responsive, tương thích với thiết bị di động.
- Nếu gặp lỗi, kiểm tra log lỗi của PHP hoặc MySQL.

## Đóng góp
Nếu bạn muốn cải thiện dự án, hãy fork và tạo pull request. Mọi góp ý đều được chào đón!

## Giấy phép
Dự án này là mã nguồn mở, sử dụng dưới giấy phép MIT.