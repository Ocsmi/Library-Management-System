-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 01:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmins`
--

CREATE TABLE `tbladmins` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_level` enum('superadmin','librarian') DEFAULT 'librarian'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin_notifications`
--

CREATE TABLE `tbladmin_notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblbooks`
--

CREATE TABLE `tblbooks` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `status` enum('available','borrowed') NOT NULL DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Publisher` varchar(255) DEFAULT NULL,
  `ISBN` varchar(20) DEFAULT NULL,
  `edition` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbooks`
--

INSERT INTO `tblbooks` (`book_id`, `title`, `author`, `genre`, `status`, `created_at`, `Publisher`, `ISBN`, `edition`) VALUES
(11, 'The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Allen & Unwin', '978-0048231500', '1st'),
(12, 'Pride and Prejudice', 'Jane Austen', 'Romance', 'available', '2025-03-20 15:48:20', 'T. Egerton', '978-0141439518', '1st'),
(13, 'To Kill a Mockingbird', 'Harper Lee', 'Classic', 'available', '2025-03-20 15:48:20', 'J. B. Lippincott & Co.', '978-0446310789', '1st'),
(14, '1984', 'George Orwell', 'Dystopian', 'available', '2025-03-20 15:48:20', 'Secker & Warburg', '978-0451524935', '1st'),
(15, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', 'available', '2025-03-20 15:48:20', 'Charles Scribner\'s Sons', '978-0743273565', '1st'),
(16, 'Moby Dick', 'Herman Melville', 'Adventure', 'available', '2025-03-20 15:48:20', 'Richard Bentley', '978-0143052144', '1st'),
(17, 'Jane Eyre', 'Charlotte Brontë', 'Gothic', 'available', '2025-03-20 15:48:20', 'Smith, Elder & Co.', '978-0141441146', '1st'),
(18, 'Wuthering Heights', 'Emily Brontë', 'Gothic', 'available', '2025-03-20 15:48:20', 'Thomas Cautley Newby', '978-0141441153', '1st'),
(19, 'One Hundred Years of Solitude', 'Gabriel García Márquez', 'Magical Realism', 'available', '2025-03-20 15:48:20', 'Editorial Sudamericana', '978-0307474728', '1st'),
(20, 'The Catcher in the Rye', 'J.D. Salinger', 'Classic', 'available', '2025-03-20 15:48:20', 'Little, Brown and Company', '978-0316769174', '1st'),
(21, 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 'available', '2025-03-20 15:48:20', 'George Allen & Unwin', '978-0547928227', '1st'),
(22, 'Little Women', 'Louisa May Alcott', 'Classic', 'available', '2025-03-20 15:48:20', 'Roberts Brothers', '978-0140350765', '1st'),
(23, 'Crime and Punishment', 'Fyodor Dostoevsky', 'Psychological Thriller', 'available', '2025-03-20 15:48:20', 'The Russian Messenger', '978-0679734502', '1st'),
(24, 'David Copperfield', 'Charles Dickens', 'Classic', 'available', '2025-03-20 15:48:20', 'Bradbury and Evans', '978-0141439549', '1st'),
(25, 'Alice\'s Adventures in Wonderland', 'Lewis Carroll', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Macmillan and Co.', '978-0141439242', '1st'),
(26, 'The Adventures of Huckleberry Finn', 'Mark Twain', 'Classic', 'available', '2025-03-20 15:48:20', 'Chatto & Windus', '978-0140350413', '1st'),
(27, 'Anna Karenina', 'Leo Tolstoy', 'Romance', 'available', '2025-03-20 15:48:20', 'The Russian Messenger', '978-0140449179', '1st'),
(28, 'The Odyssey', 'Homer', 'Epic Poetry', 'available', '2025-03-20 15:48:20', 'Various', '978-0143039954', 'Various'),
(29, 'The Iliad', 'Homer', 'Epic Poetry', 'available', '2025-03-20 15:48:20', 'Various', '978-0143039015', 'Various'),
(30, 'The Picture of Dorian Gray', 'Oscar Wilde', 'Gothic', 'available', '2025-03-20 15:48:20', 'Ward, Lock, and Company', '978-0141439570', '1st'),
(31, 'Frankenstein', 'Mary Shelley', 'Gothic', 'available', '2025-03-20 15:48:20', 'Lackington, Hughes, Harding, Mavor, & Jones', '978-0141439471', '1st'),
(32, 'Dracula', 'Bram Stoker', 'Gothic', 'available', '2025-03-20 15:48:20', 'Archibald Constable and Company', '978-0141439532', '1st'),
(33, 'The Count of Monte Cristo', 'Alexandre Dumas', 'Adventure', 'available', '2025-03-20 15:48:20', 'Pétion', '978-0140449261', '1st'),
(34, 'Les Misérables', 'Victor Hugo', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'A. Lacroix, Verboeckhoven et Cie', '978-0140449223', '1st'),
(35, 'War and Peace', 'Leo Tolstoy', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'The Russian Messenger', '978-0140449797', '1st'),
(36, 'Don Quixote', 'Miguel de Cervantes', 'Classic', 'available', '2025-03-20 15:48:20', 'Francisco de Robles', '978-0060934347', '1st'),
(37, 'The Divine Comedy', 'Dante Alighieri', 'Epic Poetry', 'available', '2025-03-20 15:48:20', 'Various', '978-0140444907', 'Various'),
(38, 'Hamlet', 'William Shakespeare', 'Tragedy', 'available', '2025-03-20 15:48:20', 'Various', '978-0743477123', 'Various'),
(39, 'Macbeth', 'William Shakespeare', 'Tragedy', 'available', '2025-03-20 15:48:20', 'Various', '978-0743477109', 'Various'),
(40, 'Romeo and Juliet', 'William Shakespeare', 'Tragedy', 'available', '2025-03-20 15:48:20', 'Various', '978-0743477116', 'Various'),
(41, 'King Lear', 'William Shakespeare', 'Tragedy', 'available', '2025-03-20 15:48:20', 'Various', '978-0743477086', 'Various'),
(42, 'Othello', 'William Shakespeare', 'Tragedy', 'available', '2025-03-20 15:48:20', 'Various', '978-0743477093', 'Various'),
(43, 'A Midsummer Night\'s Dream', 'William Shakespeare', 'Comedy', 'available', '2025-03-20 15:48:20', 'Various', '978-0743477062', 'Various'),
(44, 'The Tempest', 'William Shakespeare', 'Comedy', 'available', '2025-03-20 15:48:20', 'Various', '978-0743477079', 'Various'),
(45, 'The Brothers Karamazov', 'Fyodor Dostoevsky', 'Philosophical', 'available', '2025-03-20 15:48:20', 'The Russian Messenger', '978-0374528372', '1st'),
(46, 'The Trial', 'Franz Kafka', 'Dystopian', 'available', '2025-03-20 15:48:20', 'Verlag Die Schmiede', '978-0805210680', '1st'),
(47, 'The Metamorphosis', 'Franz Kafka', 'Absurdist', 'available', '2025-03-20 15:48:20', 'Die Weißen Bücher', '978-0553213690', '1st'),
(48, 'Catch-22', 'Joseph Heller', 'Satire', 'available', '2025-03-20 15:48:20', 'Simon & Schuster', '978-0440237445', '1st'),
(49, 'Slaughterhouse-Five', 'Kurt Vonnegut', 'Science Fiction', 'available', '2025-03-20 15:48:20', 'Delacorte Press', '978-0586033283', '1st'),
(50, 'Brave New World', 'Aldous Huxley', 'Dystopian', 'available', '2025-03-20 15:48:20', 'Chatto & Windus', '978-0099477606', '1st'),
(51, 'Fahrenheit 451', 'Ray Bradbury', 'Dystopian', 'available', '2025-03-20 15:48:20', 'Ballantine Books', '978-0345342966', '1st'),
(52, 'The Handmaid\'s Tale', 'Margaret Atwood', 'Dystopian', 'available', '2025-03-20 15:48:20', 'McClelland and Stewart', '978-0385490818', '1st'),
(53, 'The Road', 'Cormac McCarthy', 'Post-Apocalyptic', 'available', '2025-03-20 15:48:20', 'Alfred A. Knopf', '978-0307387890', '1st'),
(54, 'The Book Thief', 'Markus Zusak', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Picador', '978-0375831003', '1st'),
(55, 'The Color Purple', 'Alice Walker', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Harcourt Brace Jovanovich', '978-0151191530', '1st'),
(56, 'Beloved', 'Toni Morrison', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Alfred A. Knopf', '978-1400033416', '1st'),
(57, 'The Kite Runner', 'Khaled Hosseini', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Riverhead Books', '978-1594480003', '1st'),
(58, 'A Thousand Splendid Suns', 'Khaled Hosseini', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Riverhead Books', '978-1594489501', '1st'),
(59, 'Life of Pi', 'Yann Martel', 'Adventure', 'available', '2025-03-20 15:48:20', 'Knopf Canada', '978-0156027343', '1st'),
(60, 'The Old Man and the Sea', 'Ernest Hemingway', 'Classic', 'available', '2025-03-20 15:48:20', 'Charles Scribner\'s Sons', '978-0684801223', '1st'),
(61, 'For Whom the Bell Tolls', 'Ernest Hemingway', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Charles Scribner\'s Sons', '978-0684803388', '1st'),
(62, 'A Farewell to Arms', 'Ernest Hemingway', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Charles Scribner\'s Sons', '978-0684801469', '1st'),
(63, 'The Sun Also Rises', 'Ernest Hemingway', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Charles Scribner\'s Sons', '978-0684801476', '1st'),
(64, 'The Bell Jar', 'Sylvia Plath', 'Autobiographical', 'available', '2025-03-20 15:48:20', 'William Heinemann', '978-0060837020', '1st'),
(65, 'The Remains of the Day', 'Kazuo Ishiguro', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Faber and Faber', '978-0679731761', '1st'),
(66, 'Never Let Me Go', 'Kazuo Ishiguro', 'Science Fiction', 'available', '2025-03-20 15:48:20', 'Faber and Faber', '978-1400078776', '1st'),
(67, 'The God of Small Things', 'Arundhati Roy', 'Literary Fiction', 'available', '2025-03-20 15:48:20', 'HarperCollins', '978-0060977496', '1st'),
(68, 'Midnight\'s Children', 'Salman Rushdie', 'Magical Realism', 'available', '2025-03-20 15:48:20', 'Jonathan Cape', '978-0330259393', '1st'),
(69, 'The Satanic Verses', 'Salman Rushdie', 'Magical Realism', 'available', '2025-03-20 15:48:20', 'Viking Penguin', '978-0670825360', '1st'),
(70, 'White Teeth', 'Zadie Smith', 'Contemporary Fiction', 'available', '2025-03-20 15:48:20', 'Hamish Hamilton', '978-0375701399', '1st'),
(71, 'The Namesake', 'Jhumpa Lahiri', 'Contemporary Fiction', 'available', '2025-03-20 15:48:20', 'Houghton Mifflin', '978-0618056742', '1st'),
(72, 'The Brief Wondrous Life of Oscar Wao', 'Junot Díaz', 'Magical Realism', 'available', '2025-03-20 15:48:20', 'Riverhead Books', '978-1594489587', '1st'),
(73, 'The Corrections', 'Jonathan Franzen', 'Contemporary Fiction', 'available', '2025-03-20 15:48:20', 'Farrar, Straus and Giroux', '978-0374130091', '1st'),
(74, 'Freedom', 'Jonathan Franzen', 'Contemporary Fiction', 'available', '2025-03-20 15:48:20', 'Farrar, Straus and Giroux', '978-0374159474', '1st'),
(75, 'The Amazing Adventures of Kavalier & Clay', 'Michael Chabon', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Random House', '978-0375700507', '1st'),
(76, 'Cloud Atlas', 'David Mitchell', 'Science Fiction', 'available', '2025-03-20 15:48:20', 'Sceptre', '978-0340822774', '1st'),
(77, 'The Time Traveler\'s Wife', 'Audrey Niffenegger', 'Science Fiction', 'available', '2025-03-20 15:48:20', 'MacAdam/Cage', '978-1932100571', '1st'),
(78, 'The Shadow of the Wind', 'Carlos Ruiz Zafón', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'Planeta', '978-0143034874', '1st'),
(79, 'The Pillars of the Earth', 'Ken Follett', 'Historical Fiction', 'available', '2025-03-20 15:48:20', 'William Morrow and Company', '978-0451166896', '1st'),
(80, 'A Game of Thrones', 'George R.R. Martin', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Bantam Books', '978-0553103540', '1st'),
(81, 'A Clash of Kings', 'George R.R. Martin', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Bantam Books', '978-0553099547', '1st'),
(82, 'A Storm of Swords', 'George R.R. Martin', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Bantam Books', '978-0553106619', '1st'),
(83, 'A Feast for Crows', 'George R.R. Martin', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Bantam Books', '978-0553071345', '1st'),
(84, 'A Dance with Dragons', 'George R.R. Martin', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Bantam Books', '978-0553099509', '1st'),
(85, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Bloomsbury', '978-0747532699', '1st'),
(86, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Bloomsbury', '978-0747538493', '1st'),
(87, 'Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', 'Fantasy', 'available', '2025-03-20 15:48:20', 'Bloomsbury', '976-0938372623', '2nd'),
(88, 'Harry Potter and the Goblet of Fire', 'J.K. Rowling', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Bloomsbury', '978-0747546344', '1st'),
(89, 'Harry Potter and the Order of the Phoenix', 'J.K. Rowling', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Bloomsbury', '978-0747551003', '1st'),
(90, 'Harry Potter and the Half-Blood Prince', 'J.K. Rowling', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Bloomsbury', '978-0747581081', '1st'),
(91, 'Harry Potter and the Deathly Hallows', 'J.K. Rowling', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Bloomsbury', '978-0747591059', '1st'),
(92, 'The Da Vinci Code', 'Dan Brown', 'Thriller', 'available', '2025-03-20 15:53:49', 'Doubleday', '978-0385504201', '1st'),
(93, 'Angels & Demons', 'Dan Brown', 'Thriller', 'available', '2025-03-20 15:53:49', 'Atria Books', '978-1416524793', '1st'),
(94, 'Inferno', 'Dan Brown', 'Thriller', 'available', '2025-03-20 15:53:49', 'Doubleday', '978-0385537858', '1st'),
(95, 'Origin', 'Dan Brown', 'Thriller', 'available', '2025-03-20 15:53:49', 'Doubleday', '978-0385542685', '1st'),
(96, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', 'Thriller', 'available', '2025-03-20 15:53:49', 'Norstedts Förlag', '978-0307277651', '1st'),
(97, 'The Girl Who Played with Fire', 'Stieg Larsson', 'Thriller', 'available', '2025-03-20 15:53:49', 'Norstedts Förlag', '978-0307277675', '1st'),
(98, 'The Girl Who Kicked the Hornets\' Nest', 'Stieg Larsson', 'Thriller', 'available', '2025-03-20 15:53:49', 'Norstedts Förlag', '978-0307277699', '1st'),
(99, 'Gone Girl', 'Gillian Flynn', 'Thriller', 'available', '2025-03-20 15:53:49', 'Crown Publishing Group', '978-0307588360', '1st'),
(100, 'Sharp Objects', 'Gillian Flynn', 'Thriller', 'available', '2025-03-20 15:53:49', 'Shaye Areheart Books', '978-0307341576', '1st'),
(101, 'Dark Places', 'Gillian Flynn', 'Thriller', 'available', '2025-03-20 15:53:49', 'Shaye Areheart Books', '978-0307341590', '1st'),
(102, 'The Silent Patient', 'Alex Michaelides', 'Thriller', 'available', '2025-03-20 15:53:49', 'Celadon Books', '978-1250301690', '1st'),
(103, 'The Guest List', 'Lucy Foley', 'Thriller', 'available', '2025-03-20 15:53:49', 'William Morrow', '978-0062868858', '1st'),
(104, 'The Hunting Party', 'Lucy Foley', 'Thriller', 'available', '2025-03-20 15:53:49', 'William Morrow', '978-0062868834', '1st'),
(105, 'Where the Crawdads Sing', 'Delia Owens', 'Mystery', 'available', '2025-03-20 15:53:49', 'G.P. Putnam\'s Sons', '978-0735219090', '1st'),
(106, 'The Lincoln Highway', 'Amor Towles', 'Historical Fiction', 'available', '2025-03-20 15:53:49', 'Viking', '978-0735222359', '1st'),
(107, 'Lessons in Chemistry', 'Bonnie Garmus', 'Historical Fiction', 'available', '2025-03-20 15:53:49', 'Doubleday', '978-0385547345', '1st'),
(108, 'Tomorrow, and Tomorrow, and Tomorrow', 'Gabrielle Zevin', 'Contemporary Fiction', 'available', '2025-03-20 15:53:49', 'Alfred A. Knopf', '978-0593312081', '1st'),
(109, 'The Night Circus', 'Erin Morgenstern', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Doubleday', '978-0385671654', '1st'),
(110, 'The Song of Achilles', 'Madeline Miller', 'Historical Fiction', 'available', '2025-03-20 15:53:49', 'Ecco', '978-0062060961', '1st'),
(111, 'Circe', 'Madeline Miller', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Little, Brown and Company', '978-0316556343', '1st'),
(112, 'The Seven Husbands of Evelyn Hugo', 'Taylor Jenkins Reid', 'Historical Fiction', 'available', '2025-03-20 15:53:49', 'Atria Books', '978-1501161925', '1st'),
(113, 'Daisy Jones & The Six', 'Taylor Jenkins Reid', 'Historical Fiction', 'available', '2025-03-20 15:53:49', 'Ballantine Books', '978-1524798628', '1st'),
(114, 'Little Fires Everywhere', 'Celeste Ng', 'Contemporary Fiction', 'available', '2025-03-20 15:53:49', 'Penguin Press', '978-0735224292', '1st'),
(115, 'Everything I Never Told You', 'Celeste Ng', 'Contemporary Fiction', 'available', '2025-03-20 15:53:49', 'Penguin Press', '978-1594205135', '1st'),
(116, 'Normal People', 'Sally Rooney', 'Contemporary Fiction', 'available', '2025-03-20 15:53:49', 'Faber & Faber', '978-1524763138', '1st'),
(117, 'Conversations with Friends', 'Sally Rooney', 'Contemporary Fiction', 'available', '2025-03-20 15:53:49', 'Faber & Faber', '978-1786881724', '1st'),
(118, 'Eleanor Oliphant Is Completely Fine', 'Gail Honeyman', 'Contemporary Fiction', 'available', '2025-03-20 15:53:49', 'Pamela Dorman Books', '978-0735220621', '1st'),
(119, 'Where\'d You Go, Bernadette', 'Maria Semple', 'Humor', 'available', '2025-03-20 15:53:49', 'Little, Brown and Company', '978-0316204244', '1st'),
(120, 'The Martian', 'Andy Weir', 'Science Fiction', 'available', '2025-03-20 15:53:49', 'Crown', '978-0804139021', '1st'),
(121, 'Project Hail Mary', 'Andy Weir', 'Science Fiction', 'available', '2025-03-20 15:53:49', 'Ballantine Books', '978-0593135204', '1st'),
(122, 'Ready Player One', 'Ernest Cline', 'Science Fiction', 'available', '2025-03-20 15:53:49', 'Crown Publishing Group', '978-0307887435', '1st'),
(123, 'The Hunger Games', 'Suzanne Collins', 'Dystopian', 'available', '2025-03-20 15:53:49', 'Scholastic Press', '978-0439023528', '1st'),
(124, 'Catching Fire', 'Suzanne Collins', 'Dystopian', 'available', '2025-03-20 15:53:49', 'Scholastic Press', '978-0439023535', '1st'),
(125, 'Mockingjay', 'Suzanne Collins', 'Dystopian', 'available', '2025-03-20 15:53:49', 'Scholastic Press', '978-0439023542', '1st'),
(126, 'Divergent', 'Veronica Roth', 'Dystopian', 'available', '2025-03-20 15:53:49', 'Katherine Tegen Books', '978-0062024022', '1st'),
(127, 'Insurgent', 'Veronica Roth', 'Dystopian', 'available', '2025-03-20 15:53:49', 'Katherine Tegen Books', '978-0062024039', '1st'),
(128, 'Allegiant', 'Veronica Roth', 'Dystopian', 'available', '2025-03-20 15:53:49', 'Katherine Tegen Books', '978-0062024046', '1st'),
(129, 'The Fault in Our Stars', 'John Green', 'Young Adult', 'available', '2025-03-20 15:53:49', 'Dutton Books', '978-0525478816', '1st'),
(130, 'Looking for Alaska', 'John Green', 'Young Adult', 'available', '2025-03-20 15:53:49', 'Dutton Books', '978-0525476881', '1st'),
(131, 'Paper Towns', 'John Green', 'Young Adult', 'available', '2025-03-20 15:53:49', 'Dutton Books', '978-0525478182', '1st'),
(132, 'The Book Thief', 'Markus Zusak', 'Historical Fiction', 'available', '2025-03-20 15:53:49', 'Picador', '978-0375831003', '1st'),
(133, 'The Alchemist', 'Paulo Coelho', 'Fiction', 'available', '2025-03-20 15:53:49', 'HarperOne', '978-0062315007', '1st'),
(134, 'The Little Prince', 'Antoine de Saint-Exupéry', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Reynal & Hitchcock', '978-0156012195', '1st'),
(135, 'Animal Farm', 'George Orwell', 'Satire', 'available', '2025-03-20 15:53:49', 'Secker & Warburg', '978-0451526342', '1st'),
(136, 'The Road', 'Cormac McCarthy', 'Post-Apocalyptic', 'available', '2025-03-20 15:53:49', 'Alfred A. Knopf', '978-0307387890', '1st'),
(137, 'No Country for Old Men', 'Cormac McCarthy', 'Thriller', 'available', '2025-03-20 15:53:49', 'Alfred A. Knopf', '978-0307386282', '1st'),
(138, 'The Shining', 'Stephen King', 'Horror', 'available', '2025-03-20 15:53:49', 'Doubleday', '978-0385121753', '1st'),
(139, 'It', 'Stephen King', 'Horror', 'available', '2025-03-20 15:53:49', 'Viking Press', '978-0670404467', '1st'),
(140, 'The Stand', 'Stephen King', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Doubleday', '978-0385199514', '1st'),
(141, '11/22/63', 'Stephen King', 'Science Fiction', 'available', '2025-03-20 15:53:49', 'Scribner', '978-1451627265', '1st'),
(142, 'The Green Mile', 'Stephen King', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Scribner', '978-0684859439', '1st'),
(143, 'The Girl on the Train', 'Paula Hawkins', 'Thriller', 'available', '2025-03-20 15:53:49', 'Riverhead Books', '978-1594633631', '1st'),
(144, 'Before I Go to Sleep', 'S.J. Watson', 'Thriller', 'available', '2025-03-20 15:53:49', 'Doubleday', '978-0385667565', '1st'),
(145, 'The Woman in Cabin 10', 'Ruth Ware', 'Thriller', 'available', '2025-03-20 15:53:49', 'Gallery Books', '978-1501132956', '1st'),
(146, 'The Silent Patient', 'Alex Michaelides', 'Thriller', 'available', '2025-03-20 15:53:49', 'Celadon Books', '978-1250301690', '1st'),
(147, 'The Nightingale', 'Kristin Hannah', 'Historical Fiction', 'available', '2025-03-20 15:53:49', 'St. Martin\'s Press', '978-0312577223', '1st'),
(148, 'The Great Alone', 'Kristin Hannah', 'Historical Fiction', 'available', '2025-03-20 15:53:49', 'St. Martin\'s Press', '978-1250113590', '1st'),
(149, 'Where the Crawdads Sing', 'Delia Owens', 'Mystery', 'available', '2025-03-20 15:53:49', 'G.P. Putnam\'s Sons', '978-0735219090', '1st'),
(150, 'Eleanor Oliphant Is Completely Fine', 'Gail Honeyman', 'Contemporary Fiction', 'available', '2025-03-20 15:53:49', 'Pamela Dorman Books', '978-0735220621', '1st'),
(151, 'Anxious People', 'Fredrik Backman', 'Humor', 'available', '2025-03-20 15:53:49', 'Atria Books', '978-1501160836', '1st'),
(152, 'A Man Called Ove', 'Fredrik Backman', 'Humor', 'available', '2025-03-20 15:53:49', 'Atria Books', '978-1476738015', '1st'),
(153, 'The Midnight Library', 'Matt Haig', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Viking', '978-0593316409', '1st'),
(154, 'The Invisible Life of Addie Larue', 'V.E. Schwab', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Tor Books', '978-0765387561', '1st'),
(155, 'A Court of Thorns and Roses', 'Sarah J. Maas', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Bloomsbury Publishing', '978-1623165631', '1st'),
(156, 'A Court of Mist and Fury', 'Sarah J. Maas', 'Fantasy', 'available', '2025-03-20 15:53:49', 'Bloomsbury Publishing', '978-1623165648', '1st');

-- --------------------------------------------------------

--
-- Table structure for table `tblborrow`
--

CREATE TABLE `tblborrow` (
  `borrow_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `return_date` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','returned','approved_return') DEFAULT 'pending',
  `penalty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblborrow`
--

INSERT INTO `tblborrow` (`borrow_id`, `user_id`, `book_id`, `borrow_date`, `return_date`, `status`, `penalty_id`) VALUES
(28, 16, 11, '2025-03-20 17:14:54', '2025-03-27 06:39:01', 'approved_return', NULL),
(29, 16, 22, '2025-03-28 11:22:58', '2025-03-28 11:26:09', 'approved_return', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblborrowed_books`
--

CREATE TABLE `tblborrowed_books` (
  `borrow_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `borrowed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `return_due_date` date NOT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `penalty` decimal(10,2) DEFAULT 0.00,
  `is_approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcontacts`
--

CREATE TABLE `tblcontacts` (
  `contact_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblgenres`
--

CREATE TABLE `tblgenres` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblnotifications`
--

CREATE TABLE `tblnotifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblnotifications`
--

INSERT INTO `tblnotifications` (`notification_id`, `user_id`, `message`, `status`, `created_at`) VALUES
(3, 15, 'Greetings!', 'read', '2025-03-14 21:20:25'),
(4, 16, 'Hello!', 'read', '2025-03-15 10:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `tblpenalties`
--

CREATE TABLE `tblpenalties` (
  `penalty_id` int(11) NOT NULL,
  `borrow_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid` tinyint(1) DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `status` enum('Pending','Paid','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpenalties`
--

INSERT INTO `tblpenalties` (`penalty_id`, `borrow_id`, `amount`, `paid`, `user_id`, `status`) VALUES
(8, 28, 50.00, 0, 16, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `tblreplies`
--

CREATE TABLE `tblreplies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `reply_message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblreplies`
--

INSERT INTO `tblreplies` (`id`, `user_id`, `notification_id`, `reply_message`, `created_at`) VALUES
(1, 7, 1, 'Not really!', '2025-03-14 14:42:21'),
(2, 7, 1, 'Not really!', '2025-03-14 14:43:01'),
(3, 15, 3, 'Greetings too!', '2025-03-14 18:21:00'),
(4, 16, 4, 'Hello too!', '2025-03-15 07:31:53'),
(5, 16, 4, 'hello too!', '2025-03-15 09:19:31'),
(6, 16, 4, 'hello too!', '2025-03-15 09:20:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbltransactions`
--

CREATE TABLE `tbltransactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `borrow_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `mpesa_code` varchar(50) NOT NULL,
  `status` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone_number` varchar(15) NOT NULL,
  `date` datetime NOT NULL,
  `penalty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltransactions`
--

INSERT INTO `tbltransactions` (`transaction_id`, `user_id`, `borrow_id`, `amount`, `mpesa_code`, `status`, `created_at`, `phone_number`, `date`, `penalty_id`) VALUES
(7, 16, 28, 50.00, '', 'Completed', '2025-03-28 09:23:07', '0700335419', '2025-03-28 12:23:07', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`user_id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$YoggRrXdKN4Q3ICs.YgXcuxsBJRJjvdJBsaumzFKr3w4RDRdRr9IO', 'admin', '2025-01-20 07:46:08'),
(10, 'daggie', '$2y$10$Ct27vKDuzk/WTbY0gB81nOsDiE3U2Mz5idkCrk.MSgFNrAhZYDCW.', 'student', '2025-03-14 17:45:03'),
(13, 'manu', '$2y$10$O08BtAQxfpE2.zy1i.qm8uNlN44AlbBGrKddHJKle17jARcHDQWu2', 'admin', '2025-03-14 17:59:00'),
(15, 'Bonass', '$2y$10$vrb4QjAoRn1fa8i5UbgI4uvnuM01hxO/tY4oG1NSmtoqVDjfYmBLu', 'student', '2025-03-14 18:17:09'),
(16, 'Claire', '$2y$10$A8ZR46Xg69NqRJUIMOxXW.iQ6ntb/y72ry8r/Wo6gCec9dpfkkAA.', 'student', '2025-03-15 07:21:10'),
(18, 'sylvia', '$2y$10$ZWKEt3PwzW3JXbxWBogviO24eCKtx/B0qG9eavGvMATH8fooujEv6', 'student', '2025-03-27 06:16:53'),
(19, 'alvin', '$2y$10$xlLShTDWoJ.3YqFCxW4XzezQbC1e78YH7Bhbdu5nt3PD72s7gvzfq', 'student', '2025-03-27 06:18:20'),
(20, 'maina', '$2y$10$Jsj1wCKqSvRPfabyn68fmuEaUHH7zr4OkB3gKZz6sZot27zpojyES', 'student', '2025-03-27 06:23:25'),
(21, 'blessing', '$2y$10$rUXmm.7ojBquyEr5VSnGTesQV.9zGhiJD9tmEz47FSisLZQunyZzS', 'student', '2025-03-27 06:25:26'),
(22, 'mitchell', '$2y$10$rLSF9r5eEYoGnUAfNhRwy.FyMBOD6m0gRnObd68DtY78OTDdJKKa2', 'student', '2025-03-27 09:35:56'),
(23, 'joseph', '$2y$10$aXmEHJX8.91tvsVCBQ87susVfCFX0lxoDehJZo45FMVGkhpND2R5S', 'student', '2025-03-27 09:39:14'),
(24, 'sheila', '$2y$10$8l.rBCqtFqpYaPUjfRybn.MGnMAZP2hRrURCvfYlToI15UmIO/jLe', 'student', '2025-03-27 09:42:30'),
(25, 'milly', '$2y$10$ROZxiiN1qw6Hgwit0KtvYOLDhMASkOsmq9rINElIjF/FULDEkNrLq', 'student', '2025-03-28 08:40:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmins`
--
ALTER TABLE `tbladmins`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbladmin_notifications`
--
ALTER TABLE `tbladmin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooks`
--
ALTER TABLE `tblbooks`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `tblborrow`
--
ALTER TABLE `tblborrow`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `penalty_id` (`penalty_id`),
  ADD KEY `tblborrow_ibfk_1` (`user_id`);

--
-- Indexes for table `tblborrowed_books`
--
ALTER TABLE `tblborrowed_books`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tblcontacts`
--
ALTER TABLE `tblcontacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `tblgenres`
--
ALTER TABLE `tblgenres`
  ADD PRIMARY KEY (`genre_id`),
  ADD UNIQUE KEY `genre_name` (`genre_name`);

--
-- Indexes for table `tblnotifications`
--
ALTER TABLE `tblnotifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `tblnotifications_ibfk_1` (`user_id`);

--
-- Indexes for table `tblpenalties`
--
ALTER TABLE `tblpenalties`
  ADD PRIMARY KEY (`penalty_id`),
  ADD KEY `tblpenalties_ibfk_1` (`borrow_id`);

--
-- Indexes for table `tblreplies`
--
ALTER TABLE `tblreplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltransactions`
--
ALTER TABLE `tbltransactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tbltransactions_ibfk_2` (`borrow_id`),
  ADD KEY `FK_penalty_id` (`penalty_id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmins`
--
ALTER TABLE `tbladmins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbladmin_notifications`
--
ALTER TABLE `tbladmin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblbooks`
--
ALTER TABLE `tblbooks`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `tblborrow`
--
ALTER TABLE `tblborrow`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tblborrowed_books`
--
ALTER TABLE `tblborrowed_books`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcontacts`
--
ALTER TABLE `tblcontacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblgenres`
--
ALTER TABLE `tblgenres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnotifications`
--
ALTER TABLE `tblnotifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblpenalties`
--
ALTER TABLE `tblpenalties`
  MODIFY `penalty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblreplies`
--
ALTER TABLE `tblreplies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbltransactions`
--
ALTER TABLE `tbltransactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbladmins`
--
ALTER TABLE `tbladmins`
  ADD CONSTRAINT `tbladmins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblborrow`
--
ALTER TABLE `tblborrow`
  ADD CONSTRAINT `tblborrow_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblborrow_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `tblbooks` (`book_id`),
  ADD CONSTRAINT `tblborrow_ibfk_3` FOREIGN KEY (`penalty_id`) REFERENCES `tblpenalties` (`penalty_id`) ON DELETE SET NULL;

--
-- Constraints for table `tblborrowed_books`
--
ALTER TABLE `tblborrowed_books`
  ADD CONSTRAINT `tblborrowed_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `tblbooks` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblborrowed_books_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblnotifications`
--
ALTER TABLE `tblnotifications`
  ADD CONSTRAINT `tblnotifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblpenalties`
--
ALTER TABLE `tblpenalties`
  ADD CONSTRAINT `tblpenalties_ibfk_1` FOREIGN KEY (`borrow_id`) REFERENCES `tblborrow` (`borrow_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbltransactions`
--
ALTER TABLE `tbltransactions`
  ADD CONSTRAINT `FK_penalty_id` FOREIGN KEY (`penalty_id`) REFERENCES `tblpenalties` (`penalty_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tbltransactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`),
  ADD CONSTRAINT `tbltransactions_ibfk_2` FOREIGN KEY (`borrow_id`) REFERENCES `tblborrow` (`borrow_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
