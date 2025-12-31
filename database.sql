CREATE DATABASE IF NOT EXISTS wepsach;
USE wepsach;

-- Table: admins
DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert sample admin
INSERT INTO admins (username, email, password) VALUES ('admin', 'admin@example.com', '$2y$10$FqfdCPqVDyKoEWgpFImUW.T8R5o98GTTmn.fSPifCMxRvEVJeTt1W'); -- Password: admin123 (hashed)

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
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255),
    year INT,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_path VARCHAR(255)
);

-- Insert sample books (20 books)
INSERT INTO books (title, author, publisher, year, price, description, image_path) VALUES
('To Kill a Mockingbird', 'Harper Lee', 'J.B. Lippincott & Co.', 1960, 15.99, 'A classic novel about racial injustice and childhood innocence.', 'uploads/book1.jpg'),
('1984', 'George Orwell', 'Secker & Warburg', 1949, 12.99, 'A dystopian novel about totalitarianism and surveillance.', 'uploads/book2.jpg'),
('The Great Gatsby', 'F. Scott Fitzgerald', 'Charles Scribner\'s Sons', 1925, 14.99, 'A story of the Jazz Age and the American Dream.', 'uploads/book3.jpg'),
('Pride and Prejudice', 'Jane Austen', 'T. Egerton', 1813, 13.99, 'A romantic novel about manners and marriage.', 'uploads/book4.jpg'),
('The Catcher in the Rye', 'J.D. Salinger', 'Little, Brown and Company', 1951, 16.99, 'A coming-of-age story about teenage angst.', 'uploads/book5.jpg'),
('Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Bloomsbury', 1997, 18.99, 'The first book in the Harry Potter series.', 'uploads/book6.jpg'),
('The Lord of the Rings', 'J.R.R. Tolkien', 'George Allen & Unwin', 1954, 25.99, 'An epic fantasy adventure.', 'uploads/book7.jpg'),
('The Hobbit', 'J.R.R. Tolkien', 'George Allen & Unwin', 1937, 19.99, 'A fantasy adventure story.', 'uploads/book8.jpg'),
('Dune', 'Frank Herbert', 'Chilton Books', 1965, 22.99, 'A science fiction epic about a desert planet.', 'uploads/book9.jpg'),
('Neuromancer', 'William Gibson', 'Ace Books', 1984, 17.99, 'A cyberpunk novel about hackers and AI.', 'uploads/book10.jpg'),
('The Hitchhiker\'s Guide to the Galaxy', 'Douglas Adams', 'Pan Books', 1979, 14.99, 'A comedic science fiction series.', 'uploads/book11.jpg'),
('Ender\'s Game', 'Orson Scott Card', 'Tor Books', 1985, 16.99, 'A military science fiction novel.', 'uploads/book12.jpg'),
('Foundation', 'Isaac Asimov', 'Gnome Press', 1951, 20.99, 'A science fiction novel about the fall of the Galactic Empire.', 'uploads/book13.jpg'),
('Brave New World', 'Aldous Huxley', 'Chatto & Windus', 1932, 15.99, 'A dystopian novel about a future society.', 'uploads/book14.jpg'),
('Fahrenheit 451', 'Ray Bradbury', 'Ballantine Books', 1953, 13.99, 'A novel about censorship and book burning.', 'uploads/book15.jpg'),
('The Alchemist', 'Paulo Coelho', 'HarperCollins', 1988, 12.99, 'A philosophical novel about following dreams.', 'uploads/book16.jpg'),
('Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Harper', 2014, 24.99, 'A book about the history of humanity.', 'uploads/book17.jpg'),
('Thinking, Fast and Slow', 'Daniel Kahneman', 'Farrar, Straus and Giroux', 2011, 21.99, 'A book about psychology and decision-making.', 'uploads/book18.jpg'),
('The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'HarperOne', 2016, 17.99, 'A self-help book about life priorities.', 'uploads/book19.jpg'),
('Educated', 'Tara Westover', 'Random House', 2018, 19.99, 'A memoir about education and family.', 'uploads/book20.jpg');

-- Table: order_details
DROP TABLE IF EXISTS order_details;

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

CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    book_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_purchase DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);