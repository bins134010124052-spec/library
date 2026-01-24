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
  - Email: `admin@thuviensach.shop`
  - Họ tên: `Quản Trị Viên`
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

## Code Design (Thiết Kế Mã)

### Kiến Trúc Hệ Thống

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT (BROWSER)                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────────┐  │
│  │  HTML/CSS    │  │  Bootstrap 5 │  │  JavaScript (AJAX)   │  │
│  └──────────────┘  └──────────────┘  └──────────────────────┘  │
└────────────────────────────┬──────────────────────────────────┘
                             │ HTTP Requests
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                      WEB SERVER (APACHE)                        │
└────────────────────────────┬──────────────────────────────────┘
                             │
                    ┌────────▼────────┐
                    │  PHP Router     │
                    └────────┬────────┘
                             │
        ┌────────────────────┼────────────────────┐
        │                    │                    │
    ┌───▼─────┐         ┌────▼────┐         ┌────▼─────┐
    │ includes│         │  admin/ │         │  user/   │
    │(Shared) │         │ (Admin) │         │(Customer)│
    └─────────┘         └─────────┘         └──────────┘
        │                    │                    │
        └────────────────────┼────────────────────┘
                             │
                    ┌────────▼────────┐
                    │  PDO Database   │
                    │     Layer       │
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │  MySQL Server   │
                    │  (wepsach DB)   │
                    └─────────────────┘
```

### Mô Hình MVC (Model-View-Controller)

Ứng dụng tuân theo nguyên tắc MVC dù sử dụng PHP thuần:

#### **Model (Dữ liệu)**
- `includes/config.php` - Cấu hình kết nối database
- `includes/db_connect.php` - Kết nối PDO
- Các bảng trong MySQL: `books`, `orders`, `order_items`, `admin_users`

#### **View (Giao diện)**
- Frontend: `index.php`, `books.php`, `book_detail.php`, `cart.php`, `checkout.php`
- Admin: `admin/dashboard.php`, `admin/books.php`, `admin/orders.php`
- Shared templates: `includes/header.php`, `includes/footer.php`

#### **Controller (Logic xử lý)**
- `add_to_cart.php`, `update_cart.php`, `remove_from_cart.php` - Giỏ hàng
- `admin/add_book.php`, `admin/edit_book.php`, `admin/delete_book.php` - Sách
- `admin/update_order_status.php` - Đơn hàng
- `includes/functions.php` - Hàm tiện ích

### Sơ Đồ Cơ Sở Dữ Liệu (Database Schema)

```
┌─────────────────────┐
│      ADMIN_USERS    │
├─────────────────────┤
│ id (PK)            │
│ username           │
│ password (hash)    │
│ email              │
│ created_at         │
└─────────────────────┘

┌─────────────────────┐
│       BOOKS         │
├─────────────────────┤
│ id (PK)            │
│ title              │
│ author             │
│ price              │
│ description        │
│ cover_image        │
│ stock              │
│ created_at         │
│ updated_at         │
└─────────────────────┘

┌─────────────────────┐          ┌──────────────────┐
│      ORDERS         │◄─────────┤  ORDER_ITEMS     │
├─────────────────────┤          ├──────────────────┤
│ id (PK)            │          │ id (PK)         │
│ order_code         │          │ order_id (FK)   │
│ customer_name      │          │ book_id (FK)    │
│ customer_email     │          │ quantity        │
│ customer_phone     │          │ price           │
│ customer_address   │          │ subtotal        │
│ total_amount       │          └──────────────────┘
│ status             │
│ created_at         │
│ updated_at         │
└─────────────────────┘
```

**Quan hệ giữa các bảng:**
- `ORDERS` (1) ---→ (N) `ORDER_ITEMS`
- `BOOKS` (1) ---→ (N) `ORDER_ITEMS`
- Một đơn hàng chứa nhiều item sách

### Luồng Dữ Liệu (Data Flow)

#### **Luồng Tìm Kiếm & Xem Sách**
```
User Browser
    │
    ▼
GET /books.php?search=...
    │
    ▼
PHP File (books.php)
    │
    ├─→ functions.php (validate input)
    │
    ├─→ db_connect.php (get PDO connection)
    │
    ├─→ Query: SELECT * FROM books WHERE title LIKE ?
    │
    ▼
MySQL Database
    │
    ▼
Fetch Results (Array)
    │
    ▼
Render HTML + Bootstrap CSS
    │
    ▼
User Browser (Display)
```

#### **Luồng Thêm vào Giỏ Hàng**
```
Click "Add to Cart" Button
    │
    ▼
JavaScript (script.js)
    │
    ├─→ Validate book_id
    │
    ▼
POST /add_to_cart.php?book_id=...
    │
    ▼
PHP File (add_to_cart.php)
    │
    ├─→ Session Start
    │
    ├─→ Validate book_id
    │
    ├─→ Get book details from database
    │
    ├─→ Add to $_SESSION['cart']
    │
    ▼
JSON Response (Success/Error)
    │
    ▼
JavaScript Update UI
    │
    ▼
User sees updated cart
```

#### **Luồng Thanh Toán**
```
User fills checkout form
    │
    ▼
POST /checkout.php
    │
    ▼
PHP File (checkout.php)
    │
    ├─→ Validate customer info
    │
    ├─→ Validate cart items
    │
    ├─→ BEGIN TRANSACTION
    │
    ├─→ INSERT INTO orders (...)
    │
    ├─→ GET last insert id
    │
    ├─→ INSERT INTO order_items (...) for each book
    │
    ├─→ COMMIT TRANSACTION
    │
    ├─→ Clear $_SESSION['cart']
    │
    ▼
Database (Orders & Order_items saved)
    │
    ▼
PHP Display Success Message
    │
    ▼
User receives confirmation
```

### Các Design Patterns Sử Dụng

#### **1. Singleton Pattern (cơ sở dữ liệu)**
```php
// Database connection được khởi tạo một lần
$pdo = new PDO($dsn, $user, $pass);
// được tái sử dụng trong toàn ứng dụng
```

#### **2. Repository Pattern**
```php
// functions.php chứa các hàm truy vấn
function getBooks($search = '') { ... }
function getBookById($id) { ... }
function getOrders() { ... }
```

#### **3. Session Management Pattern**
```php
// Giỏ hàng lưu trong session
$_SESSION['cart'] = [
    'book_id' => 1,
    'quantity' => 2,
    ...
];
```

#### **4. Middleware Pattern (không chính thức)**
```php
// Kiểm tra quyền admin trước khi cho vào trang
if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}
```

### Cấu Trúc File & Trách Nhiệm

| File | Trách Nhiệm |
|------|-----------|
| `includes/config.php` | Cấu hình kết nối DB, constants |
| `includes/db_connect.php` | Khởi tạo kết nối PDO |
| `includes/functions.php` | Helper functions, business logic |
| `includes/header.php` | Navigation, layout top |
| `includes/footer.php` | Footer, scripts |
| `index.php` | Trang chủ, hiển thị sách nổi bật |
| `books.php` | Danh sách sách với tìm kiếm |
| `book_detail.php` | Chi tiết một cuốn sách |
| `cart.php` | Hiển thị giỏ hàng |
| `checkout.php` | Xử lý thanh toán, tạo đơn hàng |
| `add_to_cart.php` | AJAX endpoint: thêm sách |
| `update_cart.php` | AJAX endpoint: cập nhật số lượng |
| `remove_from_cart.php` | AJAX endpoint: xóa sách |
| `admin/login.php` | Xác thực admin |
| `admin/dashboard.php` | Bảng điều khiển admin |
| `admin/books.php` | Danh sách sách (admin) |
| `admin/add_book.php` | Thêm sách mới |
| `admin/edit_book.php` | Chỉnh sửa sách |
| `admin/delete_book.php` | Xóa sách |
| `admin/orders.php` | Danh sách đơn hàng |
| `admin/order_detail.php` | Chi tiết đơn hàng |
| `admin/update_order_status.php` | Cập nhật trạng thái |

### Xử Lý Lỗi & Bảo Mật

#### **SQL Injection Prevention**
```php
// ❌ Nguy hiểm (không sử dụng)
$query = "SELECT * FROM books WHERE id = " . $_GET['id'];

// ✅ Đúng cách (sử dụng Prepared Statements)
$query = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$query->execute([$_GET['id']]);
```

#### **XSS Prevention**
```php
// ❌ Nguy hiểm
echo $book['title'];

// ✅ Đúng cách
echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8');
```

#### **Password Hashing**
```php
// Tạo password hash
$hashed = password_hash('admin123', PASSWORD_DEFAULT);

// Xác minh password
if (password_verify($input_password, $hashed)) {
    // Đúng password
}
```

### Endpoints Chính

#### **Customer Endpoints**
| Method | URL | Mô Tả |
|--------|-----|-------|
| GET | `/index.php` | Trang chủ |
| GET | `/books.php` | Danh sách sách |
| GET | `/book_detail.php?id={id}` | Chi tiết sách |
| GET | `/search.php?q={query}` | Tìm kiếm |
| GET | `/cart.php` | Xem giỏ |
| POST | `/add_to_cart.php` | Thêm vào giỏ |
| POST | `/update_cart.php` | Cập nhật giỏ |
| POST | `/remove_from_cart.php` | Xóa khỏi giỏ |
| POST | `/checkout.php` | Thanh toán |

#### **Admin Endpoints**
| Method | URL | Mô Tả |
|--------|-----|-------|
| GET | `/admin/login.php` | Đăng nhập |
| GET | `/admin/dashboard.php` | Dashboard |
| GET | `/admin/books.php` | Danh sách sách |
| POST | `/admin/add_book.php` | Thêm sách |
| POST | `/admin/edit_book.php` | Chỉnh sửa sách |
| POST | `/admin/delete_book.php` | Xóa sách |
| GET | `/admin/orders.php` | Danh sách đơn |
| GET | `/admin/order_detail.php?id={id}` | Chi tiết đơn |
| POST | `/admin/update_order_status.php` | Cập nhật trạng thái |

### Quy Ước Mã (Code Conventions)

#### **Naming Conventions**
- **Variables**: `$snake_case` - `$book_title`, `$customer_name`
- **Functions**: `camelCase()` - `getBookById()`, `validateEmail()`
- **Constants**: `UPPER_SNAKE_CASE` - `DB_HOST`, `MAX_FILE_SIZE`
- **Database**: lowercase - `books`, `admin_users`, `order_items`

#### **File Organization**
```
wepsach/
├── includes/          # Shared code
├── admin/             # Admin section
├── user/              # User profiles (tương lai)
├── uploads/           # User-uploaded files
├── css/               # Stylesheets
├── js/                # Scripts
├── sql/               # Database files
└── [page].php         # Main pages
```

#### **Comment Style**
```php
// Single line comment

/**
 * Multi-line comment for functions
 * @param type $variable Description
 * @return type Description
 */
function example($variable) {
    // Implementation
}
```

### Performance Optimization

#### **Database Optimization**
- Sử dụng indexes trên cột `id`, `title`, `book_id`
- Limit kết quả với LIMIT/OFFSET cho phân trang

#### **Frontend Optimization**
- Bootstrap 5 CDN (cached)
- Minified CSS/JS (nếu có)
- Lazy loading cho ảnh (có thể thêm)

#### **Session Management**
- Session timeout để tránh session bloat
- Clear cart sau checkout

---

