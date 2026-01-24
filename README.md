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

## Chức năng hiện có

### Chức năng cho Khách hàng:
- **Xem và tìm kiếm sách**: Duyệt qua danh sách sách, xem chi tiết từng cuốn và tìm kiếm theo tên hoặc tác giả.
- **Quản lý giỏ hàng**: Thêm sách vào giỏ, cập nhật số lượng và xóa sản phẩm khỏi giỏ hàng mà không cần đăng nhập (sử dụng session).
- **Thanh toán đơn hàng**: Hoàn tất quá trình mua sắm bằng cách cung cấp thông tin giao hàng và tạo đơn hàng.

### Chức năng cho Admin:
- **Đăng nhập an toàn**: Truy cập vào khu vực quản trị với tài khoản admin được bảo mật.
- **Quản lý sách toàn diện**: Thêm sách mới, chỉnh sửa thông tin sách hiện có, xóa sách và quản lý hình ảnh bìa sách.
- **Quản lý đơn hàng hiệu quả**: Xem tất cả các đơn hàng, kiểm tra chi tiết từng đơn và cập nhật trạng thái xử lý của đơn hàng.

## Hoạt động của Hệ thống

Hệ thống hoạt động theo mô hình client-server với hai luồng chính:

### Luồng Khách hàng:
1. Khách hàng truy cập trang chủ, duyệt danh sách sách hoặc tìm kiếm
2. Xem chi tiết sách, thêm sách vào giỏ hàng (lưu trong Session)
3. Xem giỏ hàng, cập nhật số lượng hoặc xóa sách
4. Điền thông tin giao hàng và thanh toán
5. Đơn hàng được lưu vào database, giỏ hàng được xóa

### Luồng Admin:
1. Admin đăng nhập vào khu vực quản trị với tài khoản được bảo mật
2. Từ dashboard, admin có thể:
   - **Quản lý sách**: Thêm sách mới (kèm upload ảnh), chỉnh sửa thông tin, xóa sách khỏi hệ thống
   - **Quản lý đơn hàng**: Xem danh sách đơn hàng từ khách hàng, xem chi tiết, cập nhật trạng thái (chờ xử lý, đang giao, đã giao, v.v.)
3. Dữ liệu được cập nhật trong database MySQL ngay lập tức

### Lưu trữ Dữ liệu:
- **Books table**: Lưu thông tin sách (tiêu đề, tác giả, giá, mô tả, hình ảnh)
- **Orders table**: Lưu thông tin đơn hàng (ngày, trạng thái, thông tin khách)
- **Order items table**: Lưu chi tiết sách trong từng đơn hàng (sách nào, số lượng, giá)
- **Session**: Giỏ hàng được lưu tạm thời trong session của khách hàng

## Proposed System (Hệ Thống Đề Xuất)

Hệ thống được đề xuất sẽ tích hợp thêm các tính năng nâng cao để tối ưu hóa trải nghiệm người dùng:

### Tính năng Đề xuất/Gợi ý Sách:
- **Hiển thị sách liên quan**: Dựa trên thể loại sách mà khách hàng đang xem
- **Sách bán chạy nhất**: Hiển thị top sách được mua nhiều nhất
- **Sách mới nhất**: Hiển thị các sách vừa được thêm gần đây
- **Sách được xếp hạng cao**: Dựa trên đánh giá của khách hàng

### Hệ Thống Đánh Giá & Bình Luận:
- Khách hàng có thể đánh giá sách (1-5 sao) sau khi mua
- Khách hàng có thể viết bình luận, chia sẻ trải nghiệm về sách
- Hiển thị trung bình điểm và số lượng đánh giá trên trang chi tiết sách

### Chức Năng Tài Khoản Khách Hàng:
- **Tạo tài khoản**: Khách hàng có thể đăng ký tài khoản để theo dõi đơn hàng
- **Lịch sử mua hàng**: Xem lại các đơn hàng đã mua, tình trạng giao hàng
- **Danh sách yêu thích**: Lưu những sách mà khách hàng quan tâm để mua sau

### Cải Tiến cho Admin:
- **Thống kê báo cáo**: Xem doanh số bán hàng, sách bán chạy, doanh thu theo tháng/năm
- **Quản lý danh mục**: Thêm/sửa/xóa danh mục sách (Văn học, Kinh tế, Lịch sử, v.v.)
- **Quản lý người dùng**: Xem danh sách khách hàng, quản lý tài khoản

### Nâng Cao Bảo Mật:
- **Two-Factor Authentication (2FA)**: Bảo mật tài khoản admin
- **Mã hóa SSL/TLS**: Bảo vệ giao dịch thanh toán
- **Backup Database**: Sao lưu dữ liệu định kỳ
- **Giám sát hoạt động**: Ghi nhật ký hoạt động admin

### Tích Hợp Thanh Toán:
- **Thanh toán trực tuyến**: Tích hợp PayPal, Stripe, hoặc cổng thanh toán địa phương
- **Quản lý hóa đơn**: Tự động tạo và gửi hóa đơn điện tử cho khách hàng

