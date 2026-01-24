CREATE DATABASE IF NOT EXISTS wepsach;
USE wepsach;

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Table: admins
DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    full_name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample admin
INSERT INTO admins (email, full_name, password) VALUES ('admin@thuviensach.shop', 'Quản Trị Viên', '$2y$10$FqfdCPqVDyKoEWgpFImUW.T8R5o98GTTmn.fSPifCMxRvEVJeTt1W');

-- Table: users
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: books
DROP TABLE IF EXISTS books;
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255),
    year INT,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert sample books (20 books)
INSERT INTO books (user_id, title, author, publisher, year, price, description, image_path, status) VALUES
(NULL, 'To Kill a Mockingbird', 'Harper Lee', 'J.B. Lippincott & Co.', 1960, 15.99, 'A classic novel about racial injustice and childhood innocence.', 'uploads/6943ca53d0996.jpg', 'approved'),
(NULL, '1984', 'George Orwell', 'Secker & Warburg', 1949, 12.99, 'A dystopian novel about totalitarianism and surveillance.', 'uploads/6943cb9a56eac.jpg', 'approved'),
(NULL, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Charles Scribner\'s Sons', 1925, 14.99, 'A story of the Jazz Age and the American Dream.', 'uploads/6943cd59077e1.jpg', 'approved'),
(NULL, 'Pride and Prejudice', 'Jane Austen', 'T. Egerton', 1813, 13.99, 'A romantic novel about manners and marriage.', 'uploads/6943cdb197e1b.jpg', 'approved'),
(NULL, 'The Catcher in the Rye', 'J.D. Salinger', 'Little, Brown and Company', 1951, 16.99, 'A coming-of-age story about teenage angst.', 'uploads/6944bae168fdc.jpg', 'approved'),
(NULL, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Bloomsbury', 1997, 18.99, 'The first book in the Harry Potter series.', 'uploads/6944bb34b16b4.jpg', 'approved'),
(NULL, 'The Lord of the Rings', 'J.R.R. Tolkien', 'George Allen & Unwin', 1954, 25.99, 'An epic fantasy adventure.', 'uploads/6944bb76a0b12.jpg', 'approved'),
(NULL, 'The Hobbit', 'J.R.R. Tolkien', 'George Allen & Unwin', 1937, 19.99, 'A fantasy adventure story.', 'uploads/6944bba1f2add.jpg', 'approved'),
(NULL, 'Dune', 'Frank Herbert', 'Chilton Books', 1965, 22.99, 'A science fiction epic about a desert planet.', 'uploads/6944bbc6ee829.jpg', 'approved'),
(NULL, 'Neuromancer', 'William Gibson', 'Ace Books', 1984, 17.99, 'A cyberpunk novel about hackers and AI.', 'uploads/6944bbe4e2367.jpg', 'approved'),
(NULL, 'The Hitchhiker\'s Guide to the Galaxy', 'Douglas Adams', 'Pan Books', 1979, 14.99, 'A comedic science fiction series.', 'uploads/6944bc62c13b0.jpg', 'approved'),
(NULL, 'Ender\'s Game', 'Orson Scott Card', 'Tor Books', 1985, 16.99, 'A military science fiction novel.', 'uploads/6944bc7d8eb90.jpg', 'approved'),
(NULL, 'Foundation', 'Isaac Asimov', 'Gnome Press', 1951, 20.99, 'A science fiction novel about the fall of the Galactic Empire.', 'uploads/69493e9b67f56.jpg', 'approved'),
(NULL, 'Brave New World', 'Aldous Huxley', 'Chatto & Windus', 1932, 15.99, 'A dystopian novel about a future society.', 'uploads/69493ec98f3ca.jpg', 'approved'),
(NULL, 'Fahrenheit 451', 'Ray Bradbury', 'Ballantine Books', 1953, 13.99, 'A novel about censorship and book burning.', 'uploads/69493f0458997.jpg', 'approved'),
(NULL, 'The Alchemist', 'Paulo Coelho', 'HarperCollins', 1988, 12.99, 'A philosophical novel about following dreams.', 'uploads/69493f3cc04b3.jpg', 'approved'),
(NULL, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Harper', 2014, 24.99, 'A book about the history of humanity.', 'uploads/69493f81daadb.jpg', 'approved'),
(NULL, 'Thinking, Fast and Slow', 'Daniel Kahneman', 'Farrar, Straus and Giroux', 2011, 21.99, 'A book about psychology and decision-making.', 'uploads/6949402197040.jpg', 'approved'),
(NULL, 'The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'HarperOne', 2016, 17.99, 'A self-help book about life priorities.', 'uploads/694940515dd61.jpg', 'approved'),
(NULL, 'Educated', 'Tara Westover', 'Random House', 2018, 19.99, 'A memoir about education and family.', 'uploads/694940801953e.jpg', 'approved');

-- Table: orders
DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    customer_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Đang xử lý', 'Đã giao', 'Hoàn thành') DEFAULT 'Đang xử lý',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Table: order_details
DROP TABLE IF EXISTS order_details;
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_purchase DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- Enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;
