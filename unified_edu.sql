-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 10:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unified_edu`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `message`, `link`, `is_read`, `created_at`) VALUES
(1, 'New Kindergarten lesson added: Puzzles (Pending Approval)', 'admin/approve_lessons.php', 0, '2026-01-29 05:22:50'),
(2, 'New Kindergarten Book Added: Creative book', 'admin/approve_books.php', 0, '2026-01-29 05:52:55'),
(4, 'New Kindergarten Book Added: Alphabets', 'admin/approve_books.php', 0, '2026-01-29 09:29:49'),
(5, 'New Kindergarten Quiz Added: Numbers (Pending Approval)', 'approve_quizzes.php', 0, '2026-01-29 09:45:36'),
(6, 'New Kindergarten Quiz Added: Fun with numbers (Pending Approval)', 'approve_quizzes.php', 0, '2026-01-29 09:50:54'),
(7, 'New Kindergarten Project Topic Added (Pending Approval)', 'admin/approve_projects.php', 0, '2026-01-30 04:36:45'),
(8, 'New Kindergarten Project Topic Added (Pending Approval)', 'admin/approve_projects.php', 0, '2026-01-30 04:39:27'),
(9, 'New Kindergarten Project Topic Added (Pending Approval)', 'admin/approve_projects.php', 0, '2026-01-30 04:40:29'),
(10, 'New Kindergarten Project Topic Added (Pending Approval)', 'admin/approve_projects.php', 0, '2026-01-30 04:40:35'),
(11, 'New Kindergarten Project Topic Added (Pending Approval)', 'admin/approve_projects.php', 0, '2026-01-30 04:43:30'),
(12, 'New Kindergarten Project Topic Added (Pending Approval)', 'admin/approve_projects.php', 0, '2026-01-30 04:49:31'),
(13, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-01-30 05:23:03'),
(14, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-01-30 05:30:52'),
(15, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-01-30 05:46:43'),
(16, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-01-30 05:50:24'),
(17, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-01-30 05:51:33'),
(18, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-01-30 05:58:44'),
(19, 'New Kindergarten Quiz Added: Alphabet Quiz (Pending Approval)', 'approve_quizzes.php', 0, '2026-02-06 05:24:21'),
(20, 'New Kindergarten lesson added: Drawing (Pending Approval)', 'admin/approve_lessons.php', 0, '2026-03-04 04:10:36'),
(21, 'New Kindergarten Book Added: Drawing book', 'admin/approve_books.php', 0, '2026-03-04 04:33:37'),
(22, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-03-04 05:27:04'),
(23, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-03-04 05:29:57'),
(24, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-03-04 05:33:09'),
(25, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-03-11 05:04:51'),
(26, 'New Primary Lesson Submitted', 'admin/lesson_approval.php', 0, '2026-03-11 05:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `admin_quizzes`
--

CREATE TABLE `admin_quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `level` enum('kindergarten','primary','secondary','highschool','undergraduate','postgraduate') NOT NULL,
  `created_by` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_by_role` enum('admin','teacher') DEFAULT 'teacher',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_quizzes`
--

INSERT INTO `admin_quizzes` (`id`, `title`, `level`, `created_by`, `subject`, `status`, `created_by_role`, `created_at`) VALUES
(1, 'Numbers 1–10', 'kindergarten', 0, 'Math', 'approved', 'teacher', '2026-02-06 04:23:27'),
(2, 'Basic Shapes', 'kindergarten', 0, 'Math', 'pending', 'teacher', '2026-02-06 04:23:27'),
(3, 'Plants', 'primary', 0, 'Science', 'approved', 'teacher', '2026-02-06 04:23:27'),
(4, 'Fractions', 'primary', 0, 'Math', 'rejected', 'teacher', '2026-02-06 04:23:27'),
(5, 'Chemical Reactions', 'secondary', 0, 'Chemistry', 'approved', 'teacher', '2026-02-06 04:23:27'),
(6, 'Data Structures', 'undergraduate', 0, 'Computer Science', 'approved', 'admin', '2026-02-06 04:23:27'),
(7, 'Alphabet Quiz', 'kindergarten', 0, 'English', 'pending', 'teacher', '2026-02-06 05:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `level` enum('kindergarten','primary','secondary','highschool','undergraduate','postgraduate') DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `created_by_role` enum('admin','teacher') DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `title`, `description`, `level`, `subject`, `created_by_role`, `status`, `created_at`, `created_by`) VALUES
(1, 'Color the Numbers', 'Color numbers from 1–10', 'kindergarten', 'Math', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(2, 'Draw Your Family', 'Draw and explain your family', 'kindergarten', 'EVS', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(3, 'Math Worksheet', 'Solve addition problems', 'primary', 'Math', 'admin', 'rejected', '2026-01-22 04:28:34', NULL),
(4, 'Water Cycle Chart', 'Draw and label water cycle', 'primary', 'Science', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(5, 'Digestive System Diagram', 'Label digestive organs', 'secondary', 'Biology', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(6, 'Ray Diagram', 'Draw reflection ray diagrams', 'secondary', 'Physics', 'admin', 'rejected', '2026-01-22 04:28:34', NULL),
(7, 'Physics Numericals', 'Solve numerical problems', 'highschool', 'Physics', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(8, 'Website Creation', 'Create simple HTML website', 'highschool', 'Computer', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(9, 'Linked List Implementation', 'Implement linked list in C', 'undergraduate', 'CS', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(10, 'CPU Scheduling', 'Compare scheduling algorithms', 'undergraduate', 'OS', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(11, 'ML Mini Project', 'Implement classification model', 'postgraduate', 'AI', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(12, 'Cloud Architecture', 'Design cloud infrastructure', 'postgraduate', 'Cloud', 'admin', 'approved', '2026-01-22 04:28:34', NULL),
(13, 'Maths Puzzle', 'Students are asked to match the given maths puzzles', 'secondary', 'Mathematics', 'admin', 'approved', '2026-02-04 10:09:31', NULL),
(14, 'Alphabet Tracing A–E', 'Trace letters A to E using crayons', 'kindergarten', 'English', 'admin', 'approved', '2026-02-06 05:06:33', NULL),
(15, 'Match the Shapes', 'Match circles, squares and triangles', 'kindergarten', 'Math', 'admin', 'approved', '2026-02-06 05:06:33', NULL),
(16, 'Color the Animals', 'Color pictures of animals using bright colors', 'kindergarten', 'EVS', 'admin', 'approved', '2026-02-06 05:06:33', NULL),
(17, 'Count the Toys', 'Count toys from 1 to 10 and circle the correct number', 'kindergarten', 'Math', 'admin', 'approved', '2026-02-06 05:06:33', NULL),
(18, 'My Favorite Fruit', 'Draw and color your favorite fruit', 'kindergarten', 'EVS', 'admin', 'approved', '2026-02-06 05:06:33', NULL),
(19, 'Sing the Rhymes', 'Practice nursery rhymes with actions', 'kindergarten', 'English', 'admin', 'approved', '2026-02-06 05:06:33', NULL),
(21, 'Addition Worksheet', 'Solve the given 20 addition problems in your notebook.', 'primary', 'Mathematics', NULL, 'approved', '2026-02-28 07:23:16', NULL),
(22, 'My Family Essay', 'Write 10 sentences about your family.', 'primary', 'English', NULL, 'approved', '2026-02-28 07:23:16', NULL),
(23, 'Parts of Plant Diagram', 'Draw and label the parts of a plant.', 'primary', 'Science', NULL, 'approved', '2026-02-28 07:23:16', NULL),
(24, 'Multiplication Table Practice', 'Write tables from 2 to 10 three times.', 'primary', 'Mathematics', NULL, 'approved', '2026-02-28 07:23:16', NULL),
(25, 'Skip Counting Practice', 'Write skip counting by 2s, 5s and 10s up to 100.', 'primary', 'Mathematics', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(26, 'Synonyms and Antonyms', 'Write 5 synonyms and 5 antonyms for the given words.', 'primary', 'English', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(27, 'Solar System Model', 'Create a simple model of the solar system using chart paper.', 'primary', 'Science', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(28, 'States and Capitals', 'Write the capitals of 10 Indian states.', 'primary', 'Social Science', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(29, 'Picture Composition', 'Write 8–10 sentences based on the given picture.', 'primary', 'English', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(30, 'Time Practice', 'Draw clocks showing 3:00, 6:30, 9:45 and 12:15.', 'primary', 'Mathematics', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(31, 'Healthy Habits Chart', 'Prepare a chart showing 5 healthy habits.', 'primary', 'EVS', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(32, 'Types of Animals', 'Classify animals as domestic and wild with examples.', 'primary', 'Science', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(33, 'Roman Numerals', 'Write Roman numerals from 1 to 50.', 'primary', 'Mathematics', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(34, 'Short Story Writing', 'Write a short story with a moral in 10 sentences.', 'primary', 'English', NULL, 'approved', '2026-02-28 08:04:45', NULL),
(35, 'Algebra Practice Worksheet', 'Solve the given linear equations and simplify the expressions. Show all steps clearly.', 'secondary', 'Mathematics', 'admin', 'approved', '2026-03-01 06:03:39', 2),
(36, 'Shakespeare Essay Writing', 'Write a 500-word essay on the theme of ambition in Macbeth.', 'secondary', 'English', 'admin', 'approved', '2026-03-01 06:03:39', 2),
(37, 'Photosynthesis Diagram Assignment', 'Draw and label the process of photosynthesis. Explain each stage briefly.', 'secondary', 'Biology', 'admin', 'approved', '2026-03-01 06:03:39', 3),
(38, 'World War II Research Task', 'Prepare a short report on the causes and consequences of World War II.', 'secondary', 'History', 'admin', 'approved', '2026-03-01 06:03:39', 3),
(39, 'Chemical Reactions Worksheet', 'Balance the following chemical equations and identify the type of reaction.', 'secondary', 'Chemistry', 'admin', 'approved', '2026-03-01 06:03:39', 2),
(40, 'Computer Programming Basics', 'Write a C program to check whether a number is prime or not.', 'secondary', 'Computer Science', 'admin', 'approved', '2026-03-01 06:03:39', 4),
(41, 'Environmental Awareness Project', 'Create a poster explaining ways to reduce plastic pollution.', 'secondary', 'Geography', 'admin', 'approved', '2026-03-01 06:03:39', 3),
(42, 'Quadratic Equations Practice', 'Solve the given quadratic equations using factorization and quadratic formula method.', 'secondary', 'Mathematics', 'admin', 'approved', '2026-03-01 06:13:56', 2),
(43, 'Statistics Data Analysis', 'Calculate mean, median and mode for the given data sets.', 'secondary', 'Mathematics', 'admin', 'approved', '2026-03-01 06:13:56', 2),
(44, 'Letter Writing Assignment', 'Write a formal letter to the principal requesting permission for a study tour.', 'secondary', 'English', 'admin', 'approved', '2026-03-01 06:13:56', 3),
(45, 'Poetry Analysis', 'Analyze the theme and literary devices used in the given poem.', 'secondary', 'English', 'admin', 'approved', '2026-03-01 06:13:56', 3),
(46, 'Newton’s Laws Experiment Report', 'Explain the three laws of motion with real-life examples and diagrams.', 'secondary', 'Physics', 'admin', 'approved', '2026-03-01 06:13:56', 4),
(47, 'Acids and Bases Worksheet', 'Identify acids and bases and write their properties with examples.', 'secondary', 'Chemistry', 'admin', 'approved', '2026-03-01 06:13:56', 4),
(48, 'Human Digestive System', 'Draw and label the human digestive system and explain its functions.', 'secondary', 'Biology', 'admin', 'approved', '2026-03-01 06:13:56', 4),
(49, 'Indian Constitution Project', 'Prepare a short report on the fundamental rights and duties in the Constitution.', 'secondary', 'History', 'admin', 'approved', '2026-03-01 06:13:56', 3),
(50, 'Climate Change Presentation', 'Create a presentation explaining the causes and effects of climate change.', 'secondary', 'Geography', 'admin', 'approved', '2026-03-01 06:13:56', 3),
(51, 'HTML Webpage Design', 'Create a simple webpage using HTML with headings, images and links.', 'secondary', 'Computer Science', 'admin', 'approved', '2026-03-01 06:13:56', 5),
(52, 'C Programming Loop Practice', 'Write a C program to print Fibonacci series using loops.', 'secondary', 'Computer Science', 'admin', 'approved', '2026-03-01 06:13:56', 5),
(53, 'Algebraic Expressions & Quadratic Equations', 'Solve quadratic equations using factorization and quadratic formula. Include real-life application word problems and graph the solutions.', 'highschool', 'Mathematics', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(54, 'Trigonometry Identities & Applications', 'Prove trigonometric identities and solve problems involving heights and distances using sine, cosine, and tangent.', 'highschool', 'Mathematics', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(55, 'Chemical Reactions & Balancing Equations', 'Write and balance chemical equations. Classify reactions into synthesis, decomposition, single and double displacement.', 'highschool', 'Science', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(56, 'Newton’s Laws of Motion Project', 'Explain Newton’s three laws with real-world examples. Create a mini practical experiment demonstrating inertia.', 'highschool', 'Science', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(57, 'Shakespeare Literature Analysis', 'Analyze themes and character development from a selected Shakespeare play. Write a 500-word critical essay.', 'highschool', 'English', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(58, 'Formal Letter & Report Writing', 'Write a formal complaint letter and prepare a structured analytical report on a given topic.', 'highschool', 'English', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(59, 'World War II Research Assignment', 'Prepare a research report explaining causes, major events, and consequences of World War II.', 'highschool', 'Social Studies', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(60, 'Indian Constitution & Fundamental Rights', 'Explain key features of the Constitution and analyze the importance of Fundamental Rights with examples.', 'highschool', 'Social Studies', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(61, 'Introduction to Database Management', 'Explain DBMS concepts, normalization, primary and foreign keys. Design a simple student database schema.', 'highschool', 'Computer Science', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(62, 'HTML & CSS Mini Website Project', 'Create a 3-page responsive website using HTML and CSS including navigation, images, and forms.', 'highschool', 'Computer Science', 'admin', 'approved', '2026-03-03 10:39:22', 13),
(63, 'Math Assignments', 'Counting, addition & subtraction, shapes, patterns, and simple word problems.', 'primary', 'Mathematics', 'admin', 'approved', '2026-03-05 07:07:22', 13),
(64, 'English Assignments', 'Alphabet tracing, sight words, sentence formation, and reading exercises.', 'primary', 'English', 'admin', 'approved', '2026-03-05 07:07:22', 13),
(65, 'Science Assignments', 'Plants, animals, seasons, weather, and simple hands-on experiments.', 'primary', 'Science', 'admin', 'approved', '2026-03-05 07:07:22', 13),
(66, 'Art & Craft', 'Drawing, coloring, paper crafts, clay modeling, and creative projects.', 'primary', 'Art', 'admin', 'approved', '2026-03-05 07:07:22', 13),
(67, 'Life Skills', 'Good habits, daily routines, community awareness, and basic etiquette.', 'primary', 'General', 'admin', 'approved', '2026-03-05 07:07:22', 13),
(72, 'sample', 'test', NULL, 'Science', NULL, 'rejected', '2026-03-10 08:59:26', 33),
(73, 'sample', 'sample', 'primary', 'Mathematics', 'teacher', 'rejected', '2026-04-04 08:44:20', 30),
(74, 'sample', 'sample', 'highschool', 'sample', 'teacher', 'rejected', '2026-04-06 10:37:33', 40),
(77, 'test', 'sample', 'undergraduate', 'cs', 'teacher', 'rejected', '2026-04-07 05:54:41', 41),
(78, 'test', 'sample', 'postgraduate', 'cs', 'teacher', 'rejected', '2026-04-07 07:04:18', 39);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `author` varchar(150) DEFAULT NULL,
  `level` enum('kindergarten','primary','secondary','highschool','undergraduate','postgraduate') DEFAULT NULL,
  `description` text NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `category`, `author`, `level`, `description`, `file_path`, `pdf_file`, `status`, `created_by`, `created_at`) VALUES
(1, 'Dictionary', NULL, 'Unknown', 'primary', 'This book help students learn new words with their meaning', 'uploads/books/1769756120_PROJECTREPORTHemadocx.pdf', '1769756120_PROJECTREPORTHemadocx.pdf', 'approved', 8, '2026-01-30 12:25:20'),
(7, 'Art and Craft', NULL, 'Unknown', 'kindergarten', '', 'uploads/books/1770196999_1770194623_1769666111_numbers.pdf', '', 'approved', 13, '0000-00-00 00:00:00'),
(8, 'sample', NULL, 'nil', '', '', 'uploads/books/1770647338_Altered_PROJECT_REPORT_Hema.docx__1_.pdf', '', 'rejected', 13, '0000-00-00 00:00:00'),
(9, 'Drawing book', NULL, NULL, 'kindergarten', 'Students enjoy drawing', NULL, '1772598817_soc_class8.pdf', 'rejected', 7, '2026-03-04 05:33:37'),
(10, 'Picture Story Books', NULL, 'Kindergarten Team', 'kindergarten', 'A collection of colorful picture story books that help children improve imagination and listening skills.', NULL, '', 'approved', 1, '2026-03-04 10:07:22'),
(11, 'Moral Story Collection', NULL, 'Kindergarten Team', 'kindergarten', 'Short moral stories that teach good values and positive behavior.', NULL, '', 'approved', 1, '2026-03-04 10:07:22'),
(12, 'Alphabet Rhymes & Phonics', NULL, 'Early Learning Dept', 'kindergarten', 'Fun alphabet rhymes and phonics sound practice books for early reading skills.', NULL, '', 'approved', 1, '2026-03-04 10:07:22'),
(13, 'Tracing & Number Workbook', NULL, 'Early Learning Dept', 'kindergarten', 'Practice workbook for tracing alphabets, numbers and improving handwriting skills.', NULL, '', 'approved', 1, '2026-03-04 10:07:22'),
(14, 'Coloring & Creative Activity Book', NULL, 'Creative Learning Team', 'kindergarten', 'Creative coloring and drawing books to improve motor skills and creativity.', NULL, '', 'approved', 1, '2026-03-04 10:07:22'),
(16, 'Alphabet Fun', NULL, 'A. Reader', 'primary', 'Colorful alphabet storybook with letters and simple words.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(17, 'Numbers & Counting', NULL, 'N. Counter', 'primary', 'Interactive counting book for numbers 1–20 with illustrations.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(18, 'Animals Around Us', NULL, 'A. Wildlife', 'primary', 'Learn about animals, habitats, and sounds with fun pictures.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(19, 'My First Colors', NULL, 'C. Painter', 'primary', 'Vibrant coloring book introducing primary colors.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(20, 'Good Habits', NULL, 'H. Helper', 'primary', 'Simple stories to teach hygiene, manners, and daily routines.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(21, 'Stories & Rhymes', NULL, 'S. Teller', 'primary', 'Rhymes and short stories to improve vocabulary and listening skills.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(22, 'Shapes & Patterns', NULL, 'P. Designer', 'primary', 'Learning basic shapes, patterns, and simple puzzles.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(23, 'Seasons & Weather', NULL, 'W. Sky', 'primary', 'Books explaining seasons, weather, and changes in nature.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(24, 'Plants & Gardening', NULL, 'G. Green', 'primary', 'Simple guides about plants, trees, and how to grow small plants.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(25, 'Healthy Eating', NULL, 'N. Nutrition', 'primary', 'Fun books about fruits, vegetables, and balanced meals.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(26, 'Music & Movement', NULL, 'M. Melody', 'primary', 'Books to encourage songs, dance, and rhythm activities.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(27, 'Cultural Stories', NULL, 'C. Culture', 'primary', 'Stories about festivals, family, and community traditions.', NULL, '', 'approved', 1, '2026-03-04 11:16:13'),
(32, 'sample', 'science', 'Nil', 'secondary', 'tets', NULL, '../uploads/books/1773138686_HEMA-D-Participant-Certificate.pdf', 'pending', 33, '2026-03-10 16:01:26'),
(33, 'sample', 'Rhymes & Phonics', 'Kindergarten Team', 'kindergarten', 'sample', NULL, '', 'pending', 38, '2026-04-04 09:46:22'),
(34, 'sample', 'maths', 'sample', 'highschool', 'sample', '../uploads/books/1775376882_1846_OCTOBER_2025 (1).pdf', '1846_OCTOBER_2025 (1).pdf', 'pending', 40, '2026-04-05 13:44:42'),
(35, 'test', 'quiz', 'nil', 'undergraduate', 'saple', NULL, '', 'rejected', 41, '2026-04-06 20:47:26'),
(37, 'test', 'sample', 'nil', 'postgraduate', 'cs', NULL, 'Review2 ppt.pdf', 'rejected', 39, '2026-04-07 12:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `level` enum('kindergarten','primary','secondary','highschool','undergraduate','postgraduate') NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `status` enum('approved','pending','rejected') DEFAULT 'approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `category`, `description`, `level`, `created_by`, `status`, `created_at`) VALUES
(1, 'Alphabet World', NULL, 'Learn A–Z with pictures and sounds', 'kindergarten', 13, 'approved', '2026-01-21 23:47:19'),
(3, 'General Science', NULL, 'Introduction to science concepts', 'secondary', 13, 'approved', '2026-01-21 23:47:19'),
(4, 'Advanced Mathematics', NULL, 'Algebra and Geometry', 'highschool', 13, 'approved', '2026-01-21 23:47:19'),
(5, 'Data Structures', NULL, 'Arrays, stacks, queues', 'undergraduate', 13, 'approved', '2026-01-21 23:47:19'),
(6, 'Artificial Intelligence', NULL, 'Advanced AI concepts', 'postgraduate', 13, 'approved', '2026-01-21 23:47:19'),
(7, 'Rhymes & Songs', NULL, 'Sing and learn with joyful rhymes', 'kindergarten', 7, 'approved', '2026-01-21 23:47:34'),
(8, 'English Grammar', NULL, 'Basic grammar rules', 'primary', 8, 'approved', '2026-01-21 23:47:34'),
(9, 'Physics Fundamentals', NULL, 'Motion, force and energy', 'secondary', 9, 'approved', '2026-01-21 23:47:34'),
(10, 'Chemistry Basics', NULL, 'Atoms and molecules', 'highschool', 10, 'approved', '2026-01-21 23:47:34'),
(11, 'Operating Systems', NULL, 'Process and memory management', 'undergraduate', 11, 'approved', '2026-01-21 23:47:34'),
(12, 'Machine Learning', NULL, 'Supervised and unsupervised learning', 'postgraduate', 12, 'approved', '2026-01-21 23:47:34'),
(13, 'Number Fun', NULL, 'Counting numbers with easy examples', 'kindergarten', 13, 'approved', '2026-01-27 04:11:14'),
(14, 'Shapes & Objects', NULL, 'Identify shapes around us', 'kindergarten', 13, 'approved', '2026-01-27 04:12:15'),
(15, 'Colors & Drawing', NULL, 'Learn colors with drawing fun', 'kindergarten', 13, 'approved', '2026-01-27 04:14:02'),
(16, 'Activities & Crafts', NULL, 'Paper craft, drawing & fun activities', 'kindergarten', 13, 'approved', '2026-01-27 04:14:02'),
(18, 'English Basics', NULL, 'Reading, writing, and basic grammar', 'primary', 13, 'approved', '2026-02-03 23:17:03'),
(19, 'Mathematics Basics', NULL, 'Numbers, addition, subtraction & problem solving', 'primary', 13, 'approved', '2026-02-03 23:17:03'),
(20, 'Environmental Studies', NULL, 'Nature, family, community, and surroundings', 'primary', 13, 'approved', '2026-02-03 23:17:03'),
(21, 'Science Explorer', NULL, 'Simple science experiments and observations', 'primary', 13, 'approved', '2026-02-03 23:17:03'),
(22, 'Art & Drawing', NULL, 'Drawing, coloring, and creative expression', 'primary', 13, 'approved', '2026-02-03 23:17:03'),
(23, 'Computer Basics', NULL, 'Introduction to computers and digital skills', 'primary', 13, 'approved', '2026-02-03 23:17:03'),
(24, 'Mathematics', NULL, 'Algebra, geometry, and basic problem solving', 'secondary', 13, 'approved', '2026-02-03 23:18:57'),
(25, 'Physics Fundamentals', NULL, 'Motion, force, energy, and real-life applications', 'secondary', 13, 'approved', '2026-02-03 23:18:57'),
(26, 'Chemistry Basics', NULL, 'Matter, reactions, and everyday chemistry', 'secondary', 13, 'approved', '2026-02-03 23:18:57'),
(27, 'Biology Essentials', NULL, 'Living organisms and life processes', 'secondary', 13, 'approved', '2026-02-03 23:18:57'),
(28, 'Social Studies', NULL, 'History, geography, civics, and culture', 'secondary', 13, 'approved', '2026-02-03 23:18:57'),
(29, 'Computer Science', NULL, 'Basics of programming and digital concepts', 'secondary', 13, 'approved', '2026-02-03 23:18:57'),
(30, 'Mathematics', NULL, 'Algebra, geometry, trigonometry, and problem solving', 'secondary', 13, 'approved', '2026-02-03 23:20:41'),
(31, 'Physics', NULL, 'Motion, force, work, energy, and basic electronics', 'secondary', 13, 'approved', '2026-02-03 23:20:41'),
(32, 'Chemistry', NULL, 'Matter, chemical reactions, acids, bases, and salts', 'secondary', 13, 'approved', '2026-02-03 23:20:41'),
(33, 'Biology', NULL, 'Life processes, human body systems, and environment', 'secondary', 13, 'approved', '2026-02-03 23:20:41'),
(34, 'Social Science', NULL, 'History, geography, civics, and economics', 'secondary', 13, 'approved', '2026-02-03 23:20:41'),
(35, 'Computer Science', NULL, 'Programming basics, algorithms, and digital literacy', 'secondary', 13, 'approved', '2026-02-03 23:20:41'),
(36, 'Advanced Mathematics', NULL, 'Algebra, trigonometry, coordinate geometry, and calculus basics', 'highschool', 13, 'approved', '2026-02-03 23:21:41'),
(37, 'Physics', NULL, 'Mechanics, waves, electricity, magnetism, and optics', 'highschool', 13, 'approved', '2026-02-03 23:21:41'),
(38, 'Chemistry', NULL, 'Atomic structure, chemical bonding, reactions, and thermodynamics', 'highschool', 13, 'approved', '2026-02-03 23:21:41'),
(39, 'Biology', NULL, 'Genetics, evolution, human physiology, and ecology', 'highschool', 13, 'approved', '2026-02-03 23:21:41'),
(40, 'Social Science', NULL, 'History, political science, geography, and economics', 'highschool', 13, 'approved', '2026-02-03 23:21:41'),
(41, 'Computer Science', NULL, 'Programming concepts, data structures basics, and computer systems', 'highschool', 13, 'approved', '2026-02-03 23:21:41'),
(42, 'Engineering Mathematics', NULL, 'Linear algebra, calculus, differential equations, and probability', 'undergraduate', 13, 'approved', '2026-02-03 23:22:24'),
(43, 'Programming in C', NULL, 'Fundamentals of C programming, logic building, and problem solving', 'undergraduate', 13, 'approved', '2026-02-03 23:22:24'),
(44, 'Data Structures', NULL, 'Arrays, stacks, queues, linked lists, trees, and graphs', 'undergraduate', 13, 'approved', '2026-02-03 23:22:24'),
(45, 'Operating Systems', NULL, 'Processes, memory management, file systems, and scheduling', 'undergraduate', 13, 'approved', '2026-02-03 23:22:24'),
(46, 'Database Management Systems', NULL, 'Relational databases, SQL, normalization, and transactions', 'undergraduate', 13, 'approved', '2026-02-03 23:22:24'),
(47, 'Computer Networks', NULL, 'Networking concepts, protocols, OSI model, and internet basics', 'undergraduate', 13, 'approved', '2026-02-03 23:22:24'),
(48, 'Advanced Algorithms', NULL, 'Design and analysis of advanced algorithms and optimization techniques', 'postgraduate', 13, 'approved', '2026-02-03 23:22:54'),
(49, 'Machine Learning', NULL, 'Supervised and unsupervised learning, models, and real-world applications', 'postgraduate', 13, 'approved', '2026-02-03 23:22:54'),
(50, 'Artificial Intelligence', NULL, 'Search techniques, knowledge representation, and intelligent systems', 'postgraduate', 13, 'approved', '2026-02-03 23:22:54'),
(51, 'Cloud Computing', NULL, 'Virtualization, cloud architectures, and distributed computing', 'postgraduate', 13, 'approved', '2026-02-03 23:22:54'),
(52, 'Big Data Analytics', NULL, 'Hadoop, Spark, and large-scale data processing techniques', 'postgraduate', 13, 'approved', '2026-02-03 23:22:54'),
(53, 'Cyber Security', NULL, 'Network security, cryptography, ethical hacking, and risk management', 'postgraduate', 13, 'approved', '2026-02-03 23:22:54'),
(54, 'Advanced Algebra', NULL, 'Covers quadratic equations, polynomials, and functions.', 'highschool', 1, 'approved', '2026-03-03 05:14:17'),
(55, 'Physics – Laws of Motion', NULL, 'Learn Newton’s Laws with practical examples and experiments.', 'highschool', 1, 'approved', '2026-03-03 05:14:17'),
(56, 'English Literature – Drama', NULL, 'Study classic drama texts and literary analysis.', 'highschool', 1, 'approved', '2026-03-03 05:14:17'),
(57, 'Computer Science – Programming Basics', NULL, 'Introduction to C++ and problem-solving techniques.', 'highschool', 1, 'approved', '2026-03-03 05:14:17'),
(58, 'sample', NULL, 'sample', 'primary', 27, 'approved', '2026-03-08 23:56:59'),
(0, 'Programming Fundamentals', 'computer_science', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'computer_science', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'computer_science', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'computer_science', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'computer_science', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'computer_science', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'mechanical', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'mechanical', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'mechanical', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'mechanical', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'civil', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'civil', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'civil', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'civil', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'ece', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'ece', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'ece', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'ece', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'medical', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'medical', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'medical', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'medical', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'management', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'management', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'management', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06'),
(0, 'Programming Fundamentals', 'management', 'Basics of programming using modern languages', 'undergraduate', 1, 'approved', '2026-03-12 10:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `description`, `category`, `level`, `created_by`, `status`, `created_at`) VALUES
(2, 'Alphabet Recognition (A–Z)', 'Students learn to recognize uppercase and lowercase letters from A to Z using visuals and repetition.', 'Language', 'kindergarten', 1, 'approved', '2026-03-04 04:00:24'),
(3, 'Letter Sounds', 'Introduction to phonics through simple letter sounds and pronunciation activities.', 'Language', 'kindergarten', 1, 'approved', '2026-03-04 04:00:24'),
(4, 'Simple Words', 'Formation and reading of simple 2-3 letter words using phonics.', 'Language', 'kindergarten', 1, 'approved', '2026-03-04 04:00:24'),
(5, 'Picture Identification', 'Children identify objects and associate them with correct words and letters.', 'Language', 'kindergarten', 1, 'approved', '2026-03-04 04:00:24'),
(6, 'Numbers 1–20', 'Learning number recognition from 1 to 20 using charts and visual objects.', 'Numeracy', 'kindergarten', 1, 'approved', '2026-03-04 04:00:44'),
(7, 'Counting Objects', 'Counting everyday objects to understand quantity and number value.', 'Numeracy', 'kindergarten', 1, 'approved', '2026-03-04 04:00:44'),
(8, 'Number Matching', 'Matching numbers with corresponding quantities using worksheets and games.', 'Numeracy', 'kindergarten', 1, 'approved', '2026-03-04 04:00:44'),
(9, 'Basic Comparison', 'Understanding concepts like more, less, bigger, and smaller.', 'Numeracy', 'kindergarten', 1, 'approved', '2026-03-04 04:00:44'),
(10, 'Basic Shapes', 'Identification of common shapes such as circle, square, triangle, and rectangle.', 'Shapes & Colors', 'kindergarten', 1, 'approved', '2026-03-04 04:01:01'),
(11, 'Primary Colors', 'Recognition of primary colors: red, blue, and yellow.', 'Shapes & Colors', 'kindergarten', 1, 'approved', '2026-03-04 04:01:01'),
(12, 'Color Sorting', 'Sorting objects based on color categories through playful activities.', 'Shapes & Colors', 'kindergarten', 1, 'approved', '2026-03-04 04:01:01'),
(13, 'Shape Drawing', 'Tracing and drawing basic shapes to improve motor skills.', 'Shapes & Colors', 'kindergarten', 1, 'approved', '2026-03-04 04:01:01'),
(14, 'Good Habits', 'Teaching daily habits such as brushing teeth and keeping surroundings clean.', 'Life Skills', 'kindergarten', 1, 'approved', '2026-03-04 04:01:37'),
(15, 'Sharing & Caring', 'Encouraging teamwork and empathy through group activities.', 'Life Skills', 'kindergarten', 1, 'approved', '2026-03-04 04:01:37'),
(16, 'Personal Hygiene', 'Understanding cleanliness and self-care routines.', 'Life Skills', 'kindergarten', 1, 'approved', '2026-03-04 04:01:37'),
(17, 'Classroom Manners', 'Learning respectful behavior and listening skills in class.', 'Life Skills', 'kindergarten', 1, 'approved', '2026-03-04 04:01:37'),
(22, 'Reading & Writing', 'Letter recognition, phonics, sight words, simple sentence writing, and story reading exercises.', 'Primary', 'primary', 1, 'approved', '2026-03-04 05:22:00'),
(23, 'Basic Math', 'Counting 1–20, basic addition and subtraction, number patterns, shapes, and fun number games.', 'Primary', 'primary', 1, 'approved', '2026-03-04 05:22:00'),
(24, 'Science & Nature', 'Learning about plants, animals, seasons, weather, and simple hands-on experiments.', 'Primary', 'primary', 1, 'approved', '2026-03-04 05:22:00'),
(25, 'Social Skills & Environment', 'Community helpers, good manners, festivals, cultural awareness, and taking care of surroundings.', 'Primary', 'primary', 1, 'approved', '2026-03-04 05:22:00'),
(26, 'Art & Craft', 'Drawing, coloring, paper crafts, clay modeling, and creative projects.', 'Primary', 'primary', 1, 'approved', '2026-03-04 05:22:00'),
(27, 'Music & Movement', 'Action rhymes, simple songs, dance steps, clapping games, and rhythm exploration.', 'Primary', 'primary', 1, 'approved', '2026-03-04 05:22:00'),
(28, 'Life Skills', 'Daily routines, hygiene, healthy habits, and cooperative play activities.', 'Primary', 'primary', 1, 'approved', '2026-03-04 05:22:00'),
(29, 'Storytelling & Drama', 'Role-play, puppet shows, dramatization of stories, and confidence building exercises.', 'Primary', 'primary', 1, 'approved', '2026-03-04 05:22:00'),
(38, 'sample', 'sample', 'Language', 'kindergarten', 38, 'pending', '2026-04-04 07:35:33'),
(3625, 'sample', 'sample', 'sample', 'highschool', 40, 'pending', '2026-04-05 06:12:09'),
(3626, 'test', 'sample', 'english', 'undergraduate', 41, 'pending', '2026-04-06 15:08:04'),
(3627, 'sample', 'test', 'cs', 'postgraduate', 39, 'pending', '2026-04-07 06:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_notes`
--

CREATE TABLE `lesson_notes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `level` enum('kindergarten','primary','secondary','highschool','undergraduate','postgraduate') NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_role` enum('teacher','admin') NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_notes`
--

INSERT INTO `lesson_notes` (`id`, `course_id`, `title`, `file_path`, `level`, `created_by`, `created_by_role`, `status`, `created_at`) VALUES
(5, 23, 'Class 10 Mathematics', 'uploads/notes/1770195391_Maths – Class 10.pdf', 'highschool', 13, 'admin', 'approved', '2026-02-04 08:56:31'),
(6, 19, 'Class 1 Mathematics', 'uploads/notes/Class1_Mathematics_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(7, 18, 'Class 1 English', 'uploads/notes/Class1_English_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(8, 21, 'Class 1 Science', 'uploads/notes/Class1_Science_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(9, 20, 'Class 1 EVS', 'uploads/notes/Class1_EVS_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(10, 19, 'Class 2 Mathematics', 'uploads/notes/Class2_Mathematics_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(11, 18, 'Class 2 English', 'uploads/notes/Class2_English_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(12, 21, 'Class 2 Science', 'uploads/notes/Class2_Science_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(13, 20, 'Class 2 EVS', 'uploads/notes/Class2_EVS_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(14, 19, 'Class 3 Mathematics', 'uploads/notes/Class3_Mathematics_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(15, 18, 'Class 3 English', 'uploads/notes/Class3_English_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(16, 21, 'Class 3 Science', 'uploads/notes/Class3_Science_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(17, 20, 'Class 3 EVS', 'uploads/notes/Class3_EVS_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(18, 19, 'Class 4 Mathematics', 'uploads/notes/Class4_Mathematics_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(19, 18, 'Class 4 English', 'uploads/notes/Class4_English_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(20, 21, 'Class 4 Science', 'uploads/notes/Class4_Science_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(21, 20, 'Class 4 EVS', 'uploads/notes/Class4_EVS_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(22, 19, 'Class 5 Mathematics', 'uploads/notes/Class5_Mathematics_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(23, 18, 'Class 5 English', 'uploads/notes/Class5_English_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(24, 21, 'Class 5 Science', 'uploads/notes/Class5_Science_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41'),
(25, 20, 'Class 5 EVS', 'uploads/notes/Class5_EVS_Notes.pdf', 'primary', 13, 'admin', 'approved', '2026-02-28 04:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `related_level` varchar(50) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `primary_lessons`
--

CREATE TABLE `primary_lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(10) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_topics`
--

CREATE TABLE `project_topics` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `level` enum('kindergarten','primary','secondary','highschool','undergraduate','postgraduate') NOT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `created_by_role` enum('admin','teacher') DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_topics`
--

INSERT INTO `project_topics` (`id`, `title`, `description`, `level`, `domain`, `created_by_role`, `created_by`, `created_at`, `status`) VALUES
(1, 'Rainwater Harvesting', 'Study water conservation', 'secondary', 'Environment', 'admin', NULL, '2026-01-22 04:30:06', 'pending'),
(2, 'Solar Energy Model', 'Working solar power model', 'highschool', 'Physics', 'admin', NULL, '2026-01-22 04:30:06', 'approved'),
(3, 'Library Management System', 'CRUD based project', 'undergraduate', 'Software', 'admin', NULL, '2026-01-22 04:30:06', 'pending'),
(4, 'Online Quiz System', 'Web based quiz application', 'undergraduate', 'Web', 'admin', NULL, '2026-01-22 04:30:06', 'approved'),
(5, 'AI Chatbot', 'NLP based chatbot', 'postgraduate', 'AI', 'admin', NULL, '2026-01-22 04:30:06', 'approved'),
(6, 'Smart Attendance System', 'Face recognition system', 'postgraduate', 'AI', 'admin', NULL, '2026-01-22 04:30:06', 'pending'),
(7, 'Learn with Colors', 'Children learn basic colors using pictures, toys, and activities.', 'kindergarten', 'Basics', NULL, NULL, '2026-01-27 10:01:59', 'pending'),
(8, 'Alphabet Fun', 'Learning alphabets through songs, rhymes, and flashcards.', 'kindergarten', 'Language', NULL, NULL, '2026-01-27 10:01:59', 'pending'),
(9, 'Daily Reading Habit', 'Encourages students to read short stories daily for better understanding.', 'kindergarten', 'Language', NULL, NULL, '2026-01-27 10:01:59', 'pending'),
(10, 'Math Using Objects', 'Learning addition and subtraction using real-life objects.', 'primary', 'Mathematics', NULL, NULL, '2026-01-27 10:01:59', 'pending'),
(11, 'Water Purification Model', 'Mini project explaining water filtration using simple materials.', 'secondary', 'Science', NULL, NULL, '2026-01-27 10:01:59', 'approved'),
(12, 'Traffic Light System', 'Basic electronics project using LEDs to simulate traffic signals.', 'secondary', 'Electronics', NULL, NULL, '2026-01-27 10:01:59', 'approved'),
(13, 'Solar Energy System', 'Study of solar panels and renewable energy generation.', 'highschool', 'Physics', NULL, NULL, '2026-01-27 10:01:59', 'pending'),
(14, 'Library Management System', 'Simple software project to manage books and students.', 'highschool', 'Computer Science', NULL, NULL, '2026-01-27 10:01:59', 'rejected'),
(15, 'Online Learning Platform', 'Web-based education system with courses, quizzes, and certificates.', 'undergraduate', 'Web Development', NULL, NULL, '2026-01-27 10:01:59', 'pending'),
(16, 'Student Attendance System', 'Database-driven application to track attendance.', 'undergraduate', 'Database', NULL, NULL, '2026-01-27 10:01:59', 'approved'),
(17, 'AI-Based Recommendation System', 'Machine learning project to suggest courses based on user behavior.', 'postgraduate', 'Artificial Intelligence', NULL, NULL, '2026-01-27 10:01:59', 'pending'),
(18, 'Smart Campus System', 'IoT-based solution for smart classrooms and resource management.', 'postgraduate', 'IoT', NULL, NULL, '2026-01-27 10:01:59', 'approved'),
(19, 'Learn with Colors', 'Children learn colors using toys and visuals.', 'kindergarten', 'Basics', NULL, NULL, '2026-01-27 10:04:41', 'pending'),
(20, 'Math Using Objects', 'Learning math with real-world examples.', 'primary', 'Mathematics', 'teacher', 8, '2026-01-27 10:04:41', 'approved'),
(23, 'Matching numbers', 'Interchanged numbers will be given and the student have to match the exact number', 'kindergarten', 'Maths', 'teacher', 7, '2026-01-30 04:36:45', 'approved'),
(29, 'My Favorite Color Chart', 'Children create a colorful chart using their favorite colors and identify them.', 'kindergarten', 'Art & Creativity', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(30, 'My Dream Drawing', 'Draw anything you imagine and explain it in simple words.', 'kindergarten', 'Art & Creativity', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(31, 'Paper Mask Making', 'Create a simple animal or superhero mask using paper.', 'kindergarten', 'Art & Creativity', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(32, 'My Family Drawing', 'Draw your family members and say one thing about each.', 'kindergarten', 'Family & Community', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(33, 'Community Helpers Chart', 'Create a chart showing helpers like doctor, teacher, police.', 'kindergarten', 'Family & Community', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(34, 'Places Around Me', 'Draw important places near your home.', 'kindergarten', 'Family & Community', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(35, 'Animals Around Me', 'Identify and draw animals you see around you.', 'kindergarten', 'Animals & Nature', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(36, 'Parts of a Tree', 'Draw a tree and label its parts: root, trunk, leaves.', 'kindergarten', 'Animals & Nature', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(37, 'Aquatic Animals', 'Draw fish and other animals that live in water.', 'kindergarten', 'Animals & Nature', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(38, 'Healthy Food Chart', 'Prepare a simple healthy vs junk food chart.', 'kindergarten', 'Health & Food', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(39, 'Fruits & Vegetables', 'Collect pictures of fruits and vegetables and paste them.', 'kindergarten', 'Health & Food', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(40, 'Importance of Water', 'Explain why water is important using drawings.', 'kindergarten', 'Health & Food', 'admin', NULL, '2026-03-04 05:04:36', 'approved'),
(43, 'sample', 'test', 'secondary', 'Maths', 'teacher', 33, '2026-03-10 09:05:08', 'pending'),
(44, 'sample', 'sample', 'kindergarten', 'sample', 'teacher', 38, '2026-04-04 08:22:33', 'pending'),
(45, 'test', 'alphabets', 'highschool', 'english', 'teacher', 40, '2026-04-06 14:58:30', 'pending'),
(46, 'test', 'sample', 'undergraduate', 'cs', 'teacher', 41, '2026-04-07 06:07:50', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `authors` varchar(255) DEFAULT NULL,
  `journal` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `abstract` text DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `citations` int(11) DEFAULT NULL,
  `doi_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publications`
--

INSERT INTO `publications` (`id`, `title`, `authors`, `journal`, `year`, `abstract`, `keywords`, `citations`, `doi_link`) VALUES
(1, 'Artificial Intelligence in Education: A Review', 'John Smith, Alice Brown', 'Computers & Education', 2023, 'This paper discusses AI applications in education...', 'AI, Education', 120, 'https://doi.org/xxxxx');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `admin_quiz_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `level` enum('kindergarten','primary','secondary','highschool','undergraduate','postgraduate') NOT NULL,
  `subject` varchar(100) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `total_questions` int(11) DEFAULT 0,
  `created_by_role` enum('admin','teacher') DEFAULT 'teacher',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `admin_quiz_id`, `title`, `level`, `subject`, `class`, `total_questions`, `created_by_role`, `created_by`, `created_at`) VALUES
(1, 1, 'Numbers 1–10', 'kindergarten', 'Math', NULL, 5, 'teacher', 0, '2026-02-05 22:53:27'),
(2, 2, 'Shapes', 'kindergarten', 'Shapes', NULL, 5, 'teacher', 0, '2026-02-05 22:53:27'),
(4, 4, 'Alphabet Quiz', 'kindergarten', 'English', NULL, 5, 'admin', 0, '2026-02-05 23:07:21'),
(5, 5, 'Class 1 Mathematics Quiz', 'primary', 'Mathematics', 'Class 1', 3, 'admin', 0, '2026-02-13 03:06:57'),
(6, 6, 'Class 2 Mathematics Quiz', 'primary', 'Mathematics', 'Class 2', 3, 'admin', 0, '2026-02-13 03:06:57'),
(7, 7, 'Class 3 Mathematics Quiz', 'primary', 'Mathematics', 'Class 3', 3, 'admin', 0, '2026-02-13 03:06:57'),
(8, 8, 'Class 4 Mathematics Quiz', 'primary', 'Mathematics', 'Class 4', 3, 'admin', 0, '2026-02-13 03:06:57'),
(9, 9, 'Class 5 Mathematics Quiz', 'primary', 'Mathematics', 'Class 5', 3, 'admin', 0, '2026-02-13 03:06:57'),
(10, 10, 'Class 1 English Quiz', 'primary', 'English', 'Class 1', 3, 'admin', 0, '2026-02-13 03:15:37'),
(11, 11, 'Class 2 English Quiz', 'primary', 'English', 'Class 2', 3, 'admin', 0, '2026-02-13 03:15:37'),
(12, 12, 'Class 3 English Quiz', 'primary', 'English', 'Class 3', 3, 'admin', 0, '2026-02-13 03:15:37'),
(13, 13, 'Class 4 English Quiz', 'primary', 'English', 'Class 4', 3, 'admin', 0, '2026-02-13 03:15:37'),
(14, 14, 'Class 5 English Quiz', 'primary', 'English', 'Class 5', 3, 'admin', 0, '2026-02-13 03:15:37'),
(15, 15, 'Class 1 Science Quiz', 'primary', 'Science', 'Class 1', 3, 'admin', 0, '2026-02-13 03:15:37'),
(16, 16, 'Class 2 Science Quiz', 'primary', 'Science', 'Class 2', 3, 'admin', 0, '2026-02-13 03:15:37'),
(17, 17, 'Class 3 Science Quiz', 'primary', 'Science', 'Class 3', 3, 'admin', 0, '2026-02-13 03:15:37'),
(18, 18, 'Class 4 Science Quiz', 'primary', 'Science', 'Class 4', 3, 'admin', 0, '2026-02-13 03:15:37'),
(19, 19, 'Class 5 Science Quiz', 'primary', 'Science', 'Class 5', 3, 'admin', 0, '2026-02-13 03:15:37'),
(20, 20, 'Class 6 Mathematics Quiz', 'secondary', 'Mathematics', 'Class 6', 10, 'admin', 0, '2026-02-26 23:48:59'),
(21, 21, 'Class 7 Mathematics Quiz', 'secondary', 'Mathematics', 'Class 7', 10, 'admin', 0, '2026-02-26 23:48:59'),
(22, 22, 'Class 8 Mathematics Quiz', 'secondary', 'Mathematics', 'Class 8', 10, 'admin', 0, '2026-02-26 23:48:59'),
(23, 23, 'Class 9 Mathematics Quiz', 'secondary', 'Mathematics', 'Class 9', 10, 'admin', 0, '2026-02-26 23:48:59'),
(24, 24, 'Class 6 English Quiz', 'secondary', 'English', 'Class 6', 10, 'admin', 0, '2026-02-26 23:48:59'),
(25, 25, 'Class 7 English Quiz', 'secondary', 'English', 'Class 7', 10, 'admin', 0, '2026-02-26 23:48:59'),
(26, 26, 'Class 8 English Quiz', 'secondary', 'English', 'Class 8', 10, 'admin', 0, '2026-02-26 23:48:59'),
(27, 27, 'Class 9 English Quiz', 'secondary', 'English', 'Class 9', 10, 'admin', 0, '2026-02-26 23:48:59'),
(28, 28, 'Class 6 Science Quiz', 'secondary', 'Science', 'Class 6', 10, 'admin', 0, '2026-02-26 23:48:59'),
(29, 29, 'Class 7 Science Quiz', 'secondary', 'Science', 'Class 7', 10, 'admin', 0, '2026-02-26 23:48:59'),
(30, 30, 'Class 8 Science Quiz', 'secondary', 'Science', 'Class 8', 10, 'admin', 0, '2026-02-26 23:48:59'),
(31, 31, 'Class 9 Science Quiz', 'secondary', 'Science', 'Class 9', 10, 'admin', 0, '2026-02-26 23:48:59'),
(32, 32, 'Class 6 Social Quiz', 'secondary', 'Social', 'Class 6', 10, 'admin', 0, '2026-02-26 23:48:59'),
(33, 33, 'Class 7 Social Quiz', 'secondary', 'Social', 'Class 7', 10, 'admin', 0, '2026-02-26 23:48:59'),
(34, 34, 'Class 8 Social Quiz', 'secondary', 'Social', 'Class 8', 10, 'admin', 0, '2026-02-26 23:48:59'),
(35, 35, 'Class 9 Social Quiz', 'secondary', 'Social', 'Class 9', 10, 'admin', 0, '2026-02-26 23:48:59'),
(36, 36, 'Class 10 Mathematics Quiz', 'highschool', 'Mathematics', 'Class 10', 10, 'admin', 0, '2026-03-03 13:43:00'),
(37, 37, 'Class 10 English Quiz', 'highschool', 'English', 'Class 10', 10, 'admin', 0, '2026-03-03 13:43:00'),
(38, 38, 'Class 10 Science Quiz', 'highschool', 'Science', 'Class 10', 10, 'admin', 0, '2026-03-03 13:43:00'),
(39, 39, 'Class 10 History Quiz', 'highschool', 'History', 'Class 10', 10, 'admin', 0, '2026-03-03 13:43:00'),
(40, 40, 'Class 10 Computer Science Quiz', 'highschool', 'Computer Science', 'Class 10', 10, 'admin', 0, '2026-03-03 13:43:00'),
(41, 41, 'Class 11 Mathematics Quiz', 'highschool', 'Mathematics', 'Class 11', 10, 'admin', 0, '2026-03-03 13:43:00'),
(42, 42, 'Class 11 English Quiz', 'highschool', 'English', 'Class 11', 10, 'admin', 0, '2026-03-03 13:43:00'),
(43, 43, 'Class 11 Science Quiz', 'highschool', 'Science', 'Class 11', 10, 'admin', 0, '2026-03-03 13:43:00'),
(44, 44, 'Class 11 History Quiz', 'highschool', 'History', 'Class 11', 10, 'admin', 0, '2026-03-03 13:43:00'),
(45, 45, 'Class 11 Computer Science Quiz', 'highschool', 'Computer Science', 'Class 11', 10, 'admin', 0, '2026-03-03 13:43:00'),
(46, 46, 'Class 12 Mathematics Quiz', 'highschool', 'Mathematics', 'Class 12', 10, 'admin', 0, '2026-03-03 13:43:00'),
(47, 47, 'Class 12 English Quiz', 'highschool', 'English', 'Class 12', 10, 'admin', 0, '2026-03-03 13:43:00'),
(48, 48, 'Class 12 Science Quiz', 'highschool', 'Science', 'Class 12', 10, 'admin', 0, '2026-03-03 13:43:00'),
(49, 49, 'Class 12 History Quiz', 'highschool', 'History', 'Class 12', 10, 'admin', 0, '2026-03-03 13:43:00'),
(50, 50, 'Class 12 Computer Science Quiz', 'highschool', 'Computer Science', 'Class 12', 10, 'admin', 0, '2026-03-03 13:43:00'),
(51, 51, 'Color Quiz', 'kindergarten', 'General', 'KG', 3, 'teacher', 0, '2026-03-04 04:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes1`
--

CREATE TABLE `quizzes1` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes1`
--

INSERT INTO `quizzes1` (`id`, `title`, `level`, `created_by`, `status`, `created_at`) VALUES
(1, 'Numbers 1–10', 'kindergarten', 7, 'pending', '2026-01-29 09:45:36'),
(2, 'Fun with numbers', 'kindergarten', 7, 'pending', '2026-01-29 09:50:54'),
(27, 'sample', 'Secondary', 33, 'pending', '2026-03-10 08:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `user_id`, `quiz_id`, `score`, `completed_at`) VALUES
(1, 1, 1, 3, '2026-02-27 23:12:30'),
(2, 1, 2, 5, '2026-02-28 05:20:21'),
(3, 1, 5, 10, '2026-02-28 05:20:52'),
(4, 2, 5, 4, '2026-02-28 13:29:00'),
(5, 2, 10, 5, '2026-02-28 13:29:25'),
(6, 2, 15, 5, '2026-02-28 13:29:49'),
(7, 2, 6, 5, '2026-02-28 13:30:24'),
(8, 2, 11, 3, '2026-02-28 13:30:48'),
(9, 2, 16, 4, '2026-02-28 13:31:11'),
(10, 2, 7, 4, '2026-02-28 13:32:12'),
(11, 2, 12, 5, '2026-03-01 04:48:20'),
(12, 2, 17, 6, '2026-03-01 04:48:48'),
(13, 2, 8, 5, '2026-03-01 04:49:31'),
(14, 2, 13, 8, '2026-03-01 04:50:10'),
(15, 2, 18, 5, '2026-03-01 04:50:33'),
(16, 2, 9, 6, '2026-03-01 04:51:15'),
(17, 2, 14, 5, '2026-03-01 04:51:55'),
(18, 2, 19, 2, '2026-03-01 04:52:11'),
(34, 3, 20, 4, '2026-03-01 13:16:23'),
(35, 3, 21, 3, '2026-03-01 13:17:27'),
(36, 3, 22, 5, '2026-03-01 13:20:01'),
(37, 3, 23, 11, '2026-03-01 13:28:41'),
(38, 3, 24, 5, '2026-03-01 13:29:14'),
(39, 3, 25, 4, '2026-03-01 13:30:31'),
(40, 3, 26, 4, '2026-03-01 13:31:27'),
(41, 3, 27, 8, '2026-03-01 13:34:12'),
(42, 3, 28, 4, '2026-03-01 13:35:19'),
(43, 3, 29, 9, '2026-03-01 13:36:06'),
(44, 3, 30, 5, '2026-03-01 13:37:02'),
(45, 3, 31, 11, '2026-03-01 13:54:29'),
(47, 3, 33, 3, '2026-03-01 13:55:11'),
(48, 3, 34, 3, '2026-03-01 13:55:46'),
(50, 3, 35, 5, '2026-03-01 14:02:37'),
(51, 3, 32, 2, '2026-03-03 00:50:34'),
(59, 4, 36, 8, '2026-03-04 00:01:02'),
(60, 4, 37, 9, '2026-03-04 00:01:50'),
(61, 4, 38, 10, '2026-03-04 00:03:57'),
(62, 4, 39, 9, '2026-03-04 00:05:06'),
(63, 4, 40, 10, '2026-03-04 00:05:55'),
(64, 4, 41, 5, '2026-03-04 00:06:29'),
(65, 4, 42, 5, '2026-03-04 00:07:09'),
(66, 4, 43, 5, '2026-03-04 00:07:30'),
(67, 4, 44, 5, '2026-03-04 00:08:03'),
(68, 4, 45, 5, '2026-03-04 00:08:26'),
(69, 4, 46, 5, '2026-03-04 00:08:54'),
(70, 4, 47, 5, '2026-03-04 00:09:24'),
(71, 4, 48, 5, '2026-03-04 00:09:49'),
(72, 4, 49, 3, '2026-03-04 00:10:10'),
(73, 4, 50, 5, '2026-03-04 00:10:33'),
(74, 22, 1, 3, '2026-03-05 04:59:36'),
(75, 22, 2, 5, '2026-03-05 05:01:43'),
(76, 22, 4, 13, '2026-03-05 06:57:21'),
(77, 22, 51, 3, '2026-03-05 06:57:31'),
(78, 1, 4, 11, '2026-03-07 11:55:56'),
(79, 1, 51, 3, '2026-03-07 11:56:11'),
(84, 29, 1, 6, '2026-03-11 06:24:22'),
(85, 29, 2, 5, '2026-03-11 06:24:37'),
(86, 29, 4, 11, '2026-03-11 06:25:07'),
(87, 29, 51, 3, '2026-03-11 06:25:17'),
(88, 29, 5, 4, '2026-03-11 06:39:40'),
(90, 29, 10, 4, '2026-03-11 06:41:56'),
(91, 29, 15, 5, '2026-03-11 06:42:18'),
(92, 29, 6, 5, '2026-03-11 06:42:44'),
(93, 29, 11, 5, '2026-03-11 06:43:00'),
(94, 29, 16, 4, '2026-03-11 06:43:18'),
(95, 29, 7, 4, '2026-03-11 06:43:35'),
(96, 29, 12, 5, '2026-03-11 06:43:56'),
(97, 29, 17, 6, '2026-03-11 06:44:27'),
(98, 29, 8, 5, '2026-03-11 06:45:03'),
(99, 29, 13, 5, '2026-03-11 06:47:00'),
(100, 29, 18, 5, '2026-03-11 06:47:24'),
(101, 29, 9, 7, '2026-03-11 06:47:48'),
(102, 29, 14, 4, '2026-03-11 06:48:14'),
(103, 29, 19, 2, '2026-03-11 06:48:36'),
(120, 29, 20, 5, '2026-03-11 08:16:18'),
(121, 29, 21, 3, '2026-03-11 08:17:03'),
(122, 29, 22, 5, '2026-03-11 08:17:39'),
(123, 29, 23, 13, '2026-03-11 08:19:11'),
(124, 29, 24, 5, '2026-03-11 08:20:09'),
(125, 29, 25, 5, '2026-03-11 08:20:59'),
(126, 29, 26, 5, '2026-03-11 08:21:24'),
(127, 29, 27, 9, '2026-03-12 10:08:12'),
(128, 29, 28, 3, '2026-03-12 10:09:22'),
(129, 29, 29, 9, '2026-03-12 10:10:12'),
(130, 29, 30, 5, '2026-03-12 10:10:49'),
(131, 29, 31, 15, '2026-03-12 10:11:50'),
(132, 29, 32, 4, '2026-03-12 10:12:18'),
(133, 29, 33, 5, '2026-03-12 10:12:44'),
(134, 29, 34, 5, '2026-03-12 10:13:16'),
(136, 29, 35, 5, '2026-03-12 10:21:35'),
(137, 29, 36, 10, '2026-03-12 10:30:09'),
(138, 29, 37, 10, '2026-03-12 10:31:11'),
(139, 29, 38, 10, '2026-03-12 10:32:09'),
(140, 29, 39, 10, '2026-03-12 10:33:05'),
(141, 29, 40, 10, '2026-03-12 10:33:54'),
(142, 29, 41, 5, '2026-03-12 10:34:29'),
(143, 29, 42, 5, '2026-03-12 10:35:02'),
(144, 29, 43, 5, '2026-03-12 10:35:27'),
(145, 29, 44, 5, '2026-03-12 10:35:53'),
(146, 29, 45, 5, '2026-03-12 10:36:20'),
(147, 29, 46, 5, '2026-03-12 10:36:43'),
(148, 29, 47, 5, '2026-03-12 10:37:08'),
(149, 29, 48, 5, '2026-03-12 10:37:31'),
(150, 29, 49, 5, '2026-03-12 10:38:02'),
(151, 29, 50, 5, '2026-03-12 10:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `correct_option` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `level`, `question`, `option1`, `option2`, `option3`, `option4`, `correct_option`) VALUES
(1, 1, 'kindergarten', 'What is the 1st number?', '1', '6', '9', '10', 1),
(2, 1, 'kindergarten', 'Which number comes after 4?', '3', '4', '5', '6', 3),
(3, 1, 'kindergarten', 'Count the apples 🍎🍎🍎', '2', '3', '4', '5', 2),
(4, 2, 'kindergarten', 'Which shape has 3 sides?', 'Circle', 'Triangle', 'Square', 'Rectangle', 2),
(5, 2, 'kindergarten', 'Which shape is round?', 'Triangle', 'Square', 'Circle', 'Rectangle', 3),
(6, 2, 'kindergarten', 'Which shape has 4 equal sides?', 'Rectangle', 'Triangle', 'Square', 'Circle', 3),
(7, 2, 'kindergarten', 'Which shape looks like a door?', 'Circle', 'Rectangle', 'Triangle', 'Star', 2),
(8, 2, 'kindergarten', 'Which shape has no corners?', 'Square', 'Triangle', 'Circle', 'Rectangle', 3),
(9, 4, 'kindergarten', 'Which letter comes first in the alphabet?', 'A', 'B', 'C', 'D', 1),
(10, 4, 'kindergarten', 'Which letter comes after A?', 'B', 'C', 'D', 'E', 1),
(11, 4, 'kindergarten', 'Which letter comes after B?', 'C', 'D', 'E', 'F', 1),
(12, 4, 'kindergarten', 'Which letter comes before D?', 'A', 'B', 'C', 'E', 3),
(13, 4, 'kindergarten', 'Which letter comes after C?', 'D', 'E', 'F', 'G', 1),
(14, 4, 'kindergarten', 'Which letter comes before F?', 'D', 'E', 'G', 'H', 2),
(15, 4, 'kindergarten', 'Which letter comes after E?', 'F', 'G', 'H', 'I', 1),
(16, 4, 'kindergarten', 'Which letter comes before H?', 'F', 'G', 'I', 'J', 2),
(17, 4, 'kindergarten', 'Which letter comes after G?', 'H', 'I', 'J', 'K', 1),
(18, 4, 'kindergarten', 'Which letter is a vowel?', 'B', 'C', 'A', 'D', 3),
(19, 5, 'primary', '2 + 3 = ?', '4', '5', '6', '7', 2),
(20, 5, 'primary', '5 - 2 = ?', '2', '3', '4', '5', 2),
(21, 5, 'primary', 'Which is bigger?', '1', '9', '3', '4', 2),
(22, 5, 'primary', '10 + 0 = ?', '0', '5', '10', '1', 3),
(23, 5, 'primary', '7 - 3 = ?', '3', '4', '5', '6', 2),
(24, 6, 'primary', '10 + 5 = ?', '12', '15', '20', '10', 2),
(25, 6, 'primary', '20 - 4 = ?', '16', '14', '18', '12', 1),
(26, 6, 'primary', '4 x 3 = ?', '10', '11', '12', '14', 3),
(27, 6, 'primary', '15 ÷ 3 = ?', '3', '4', '5', '6', 3),
(28, 6, 'primary', '25 + 10 = ?', '30', '35', '40', '45', 2),
(29, 7, 'primary', '2 + 2 = ?', '3', '4', '5', '6', 2),
(30, 7, 'primary', '3² = ?', '6', '9', '12', '3', 2),
(31, 7, 'primary', '4² = ?', '12', '16', '18', '8', 2),
(32, 7, 'primary', '10 ÷ 2 = ?', '2', '5', '8', '10', 2),
(33, 8, 'primary', 'What is 345 + 276?', '611', '621', '631', '641', 2),
(34, 8, 'primary', 'What is 900 - 458?', '442', '452', '462', '472', 1),
(35, 8, 'primary', '12 × 8 = ?', '84', '86', '96', '88', 3),
(36, 8, 'primary', 'How many degrees are in a right angle?', '45°', '60°', '90°', '120°', 3),
(37, 8, 'primary', 'Which fraction is equal to 1/2?', '2/4', '3/4', '1/3', '4/5', 1),
(38, 9, 'primary', 'Square of 5?', '20', '15', '25', '30', 3),
(39, 9, 'primary', 'Half of 50?', '20', '25', '30', '35', 2),
(40, 9, 'primary', 'What is the value of 12 × 8?', '96', '88', '108', '86', 1),
(41, 9, 'primary', 'Solve: 45 ÷ 5', '5', '9', '8', '10', 2),
(42, 9, 'primary', 'What is the square of 15?', '225', '215', '205', '235', 1),
(43, 9, 'primary', 'If x = 5, find the value of 2x + 3.', '10', '13', '15', '8', 2),
(44, 9, 'primary', 'Find the HCF of 18 and 24.', '6', '3', '12', '9', 1),
(45, 10, 'primary', 'Which is a fruit?', 'Dog', 'Ball', 'Apple', 'Car', 3),
(46, 10, 'primary', 'Plural of cat?', 'Cats', 'Cat', 'Cates', 'Catss', 1),
(47, 10, 'primary', 'Which letter comes after A?', 'B', 'C', 'D', 'E', 1),
(48, 10, 'primary', 'Choose correct spelling', 'Bokk', 'Book', 'Buk', 'Boook', 2),
(49, 10, 'primary', 'Which is a noun?', 'Run', 'Ball', 'Jump', 'Quickly', 2),
(50, 11, 'primary', 'Opposite of big?', 'Large', 'Small', 'Tall', 'Wide', 2),
(51, 11, 'primary', 'Which is a verb?', 'Run', 'Chair', 'Ball', 'Table', 1),
(52, 11, 'primary', 'Plural of box?', 'Boxs', 'Boxes', 'Box', 'Boxies', 2),
(53, 11, 'primary', 'Synonym of fast?', 'Slow', 'Quick', 'Late', 'Low', 2),
(54, 11, 'primary', 'Which is adjective?', 'Red', 'Run', 'Eat', 'Jump', 1),
(55, 12, 'primary', 'Choose the correct verb: She ___ playing.', 'is', 'are', 'am', 'be', 1),
(56, 12, 'primary', 'Find the noun: The cat is sleeping.', 'cat', 'sleeping', 'is', 'the', 1),
(57, 12, 'primary', 'Opposite of strong?', 'weak', 'big', 'tall', 'fast', 1),
(58, 12, 'primary', 'Plural of child?', 'childs', 'children', 'childrens', 'childes', 2),
(59, 12, 'primary', 'Choose correct sentence.', 'He go to school', 'He goes to school', 'He going school', 'He gone school', 2),
(60, 13, 'primary', 'Identify the adjective: \"A beautiful flower.\"', 'flower', 'beautiful', 'a', 'is', 2),
(61, 13, 'primary', 'Past tense of \"write\"?', 'writed', 'written', 'wrote', 'writing', 3),
(62, 13, 'primary', 'Choose correct article: \"He is ___ honest man.\"', 'a', 'an', 'the', 'no article', 2),
(63, 13, 'primary', 'Plural of \"mouse\"?', 'mouses', 'mouse', 'mice', 'meese', 3),
(64, 13, 'primary', 'Synonym of \"brave\"?', 'cowardly', 'bold', 'weak', 'shy', 2),
(70, 14, 'primary', 'Identify verb: \"She sings well.\"', 'She', 'sings', 'well', 'is', 2),
(71, 14, 'primary', 'Antonym of \"expand\"?', 'increase', 'grow', 'shrink', 'stretch', 3),
(72, 14, 'primary', 'Choose correct sentence.', 'He have done it', 'He has done it', 'He doing it', 'He do it', 2),
(73, 14, 'primary', 'Past tense of \"take\"?', 'taked', 'taken', 'took', 'taking', 3),
(74, 14, 'primary', 'Collective noun for fish?', 'herd', 'school', 'group', 'flock', 2),
(75, 15, 'primary', 'Which is living?', 'Rock', 'Tree', 'Water', 'Air', 2),
(76, 15, 'primary', 'Sun gives us?', 'Rain', 'Light', 'Snow', 'Wind', 2),
(77, 15, 'primary', 'Plants need water?', 'Yes', 'No', 'Maybe', 'Never', 1),
(78, 15, 'primary', 'We breathe with?', 'Eyes', 'Nose', 'Hands', 'Legs', 2),
(79, 15, 'primary', 'Birds can?', 'Swim', 'Fly', 'Dig', 'Drive', 2),
(80, 16, 'primary', 'Water is?', 'Solid', 'Liquid', 'Gas', 'Stone', 2),
(81, 16, 'primary', 'Sun is a?', 'Planet', 'Star', 'Moon', 'Rock', 2),
(82, 16, 'primary', 'Plants make food in?', 'Root', 'Leaf', 'Stem', 'Flower', 2),
(83, 16, 'primary', 'Ice is?', 'Liquid', 'Gas', 'Solid', 'Air', 3),
(84, 16, 'primary', 'Humans need?', 'Water', 'Air', 'Food', 'All', 4),
(85, 17, 'primary', 'Largest planet?', 'Earth', 'Mars', 'Jupiter', 'Venus', 3),
(86, 17, 'primary', 'Which part of the plant absorbs water?', 'Leaf', 'Stem', 'Root', 'Flower', 3),
(87, 17, 'primary', 'Which gas do humans breathe in?', 'Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Hydrogen', 1),
(88, 17, 'primary', 'Which is a source of energy?', 'Sun', 'Stone', 'Sand', 'Mud', 1),
(89, 17, 'primary', 'Animals that eat only plants are called?', 'Carnivores', 'Herbivores', 'Omnivores', 'Reptiles', 2),
(90, 17, 'primary', 'Water changes into vapor by?', 'Freezing', 'Melting', 'Evaporation', 'Condensation', 3),
(91, 18, 'primary', 'Which organ pumps blood in our body?', 'Lungs', 'Heart', 'Kidney', 'Brain', 2),
(92, 18, 'primary', 'The process by which plants make food is called?', 'Respiration', 'Photosynthesis', 'Digestion', 'Evaporation', 2),
(93, 18, 'primary', 'Which planet is known as the Red Planet?', 'Earth', 'Mars', 'Jupiter', 'Venus', 2),
(94, 18, 'primary', 'Force that pulls objects toward Earth is called?', 'Magnetism', 'Friction', 'Gravity', 'Energy', 3),
(95, 18, 'primary', 'Which of these is a conductor of electricity?', 'Plastic', 'Wood', 'Copper', 'Rubber', 3),
(96, 19, 'primary', 'Boiling point of water?', '50C', '75C', '100C', '120C', 3),
(97, 19, 'primary', 'Plants release?', 'Carbon dioxide', 'Oxygen', 'Nitrogen', 'Hydrogen', 2),
(98, 19, 'primary', 'Human has how many teeth (adult)?', '28', '30', '32', '34', 3),
(99, 19, 'primary', 'Energy from sun is?', 'Solar energy', 'Wind energy', 'Water energy', 'Heat energy', 1),
(100, 20, 'secondary', '15 + 7 = ?', '20', '21', '22', '23', 3),
(101, 20, 'secondary', '30 ÷ 5 = ?', '5', '6', '7', '8', 2),
(102, 20, 'secondary', '12 x 2 = ?', '22', '24', '26', '20', 2),
(103, 20, 'secondary', '100 - 45 = ?', '55', '65', '45', '60', 1),
(104, 20, 'secondary', 'Half of 20?', '5', '8', '10', '12', 3),
(105, 21, 'secondary', '45 + 35 = ?', '70', '75', '80', '85', 3),
(106, 21, 'secondary', '9 x 8 = ?', '72', '81', '63', '64', 1),
(107, 21, 'secondary', '144 ÷ 12 = ?', '10', '11', '12', '13', 3),
(108, 22, 'secondary', '125 + 275 = ?', '350', '375', '400', '425', 3),
(109, 22, 'secondary', '20% of 100?', '10', '15', '20', '25', 3),
(110, 22, 'secondary', 'LCM of 4 and 6?', '10', '12', '14', '16', 2),
(111, 22, 'secondary', 'Square root of 81?', '7', '8', '9', '10', 3),
(112, 22, 'secondary', '500 - 245 = ?', '245', '255', '265', '275', 2),
(113, 23, 'secondary', 'What is 7²?', '14', '49', '21', '77', 2),
(114, 23, 'secondary', 'Solve: 56 ÷ 8', '6', '7', '8', '9', 2),
(115, 23, 'secondary', 'Find the value of 3x if x = 4.', '7', '12', '9', '6', 2),
(116, 23, 'secondary', 'What is the perimeter of a square with side 5 cm?', '20 cm', '25 cm', '15 cm', '10 cm', 1),
(117, 23, 'secondary', 'LCM of 8 and 12?', '24', '16', '32', '48', 1),
(118, 23, 'secondary', 'Square root of 144?', '10', '11', '12', '13', 3),
(119, 23, 'secondary', 'Solve: 5x = 25', '5', '10', '15', '20', 1),
(120, 23, 'secondary', 'Area of rectangle formula?', 'l + b', 'l × b', '2(l+b)', 'b²', 2),
(121, 23, 'secondary', 'What is 15% of 200?', '20', '25', '30', '40', 3),
(122, 23, 'secondary', 'HCF of 20 and 30?', '5', '10', '15', '20', 2),
(123, 23, 'secondary', 'Value of π (approx)?', '3.12', '3.14', '3.16', '3.18', 2),
(124, 23, 'secondary', 'Quadratic formula is used to solve?', 'Linear equations', 'Quadratic equations', 'Fractions', 'Matrices', 2),
(125, 23, 'secondary', 'If a² = 49, a = ?', '5', '6', '7', '8', 3),
(126, 23, 'secondary', 'Distance formula is derived from?', 'Algebra', 'Pythagoras theorem', 'Trigonometry', 'Geometry', 2),
(127, 23, 'secondary', 'Mean is?', 'Average', 'Middle value', 'Most frequent', 'Range', 1),
(128, 24, 'secondary', 'Synonym of happy?', 'sad', 'joyful', 'angry', 'tired', 2),
(129, 24, 'secondary', 'Identify adjective: A red ball.', 'ball', 'red', 'a', 'is', 2),
(130, 24, 'secondary', 'Past tense of eat?', 'eated', 'ate', 'eats', 'eating', 2),
(131, 24, 'secondary', 'Which is a pronoun?', 'Ravi', 'she', 'table', 'run', 2),
(132, 24, 'secondary', 'Opposite of clean?', 'dirty', 'clear', 'pure', 'bright', 1),
(133, 25, 'secondary', 'Antonym of brave?', 'bold', 'cowardly', 'strong', 'kind', 2),
(134, 25, 'secondary', 'Identify adverb: He runs fast.', 'runs', 'he', 'fast', 'is', 3),
(135, 25, 'secondary', 'Future tense of go?', 'went', 'goes', 'will go', 'going', 3),
(136, 25, 'secondary', 'Collective noun for birds?', 'herd', 'flock', 'team', 'group', 2),
(137, 25, 'secondary', 'Choose correct sentence.', 'She have a pen', 'She has a pen', 'She having pen', 'She had pen', 2),
(138, 26, 'secondary', 'Choose the correct synonym of \"Happy\".', 'Sad', 'Joyful', 'Angry', 'Tired', 2),
(139, 26, 'secondary', 'Identify the noun in the sentence: \"The cat is sleeping.\"', 'Sleeping', 'Cat', 'Is', 'The', 2),
(140, 26, 'secondary', 'Choose the correct past tense of \"Go\".', 'Goed', 'Gone', 'Went', 'Going', 3),
(141, 26, 'secondary', 'Fill in the blank: She ____ playing football.', 'is', 'are', 'were', 'be', 1),
(142, 26, 'secondary', 'Choose the correct spelling.', 'Recieve', 'Receive', 'Receeve', 'Receve', 2),
(143, 27, 'secondary', 'Choose the correct past tense: \"I ___ to the store yesterday.\"', 'go', 'went', 'gone', 'going', 2),
(144, 27, 'secondary', 'Select the proper pronoun: \"___ is my best friend.\"', 'He', 'Him', 'His', 'They', 1),
(145, 27, 'secondary', 'Identify the adjective: \"The quick fox jumps.\"', 'quick', 'jumps', 'fox', 'runs', 1),
(146, 27, 'secondary', 'Pick the correct article: \"I saw ___ elephant.\"', 'an', 'a', 'the', 'some', 1),
(147, 27, 'secondary', 'Figure of speech: \"Time is money.\"', 'Simile', 'Metaphor', 'Alliteration', 'Hyperbole', 2),
(148, 27, 'secondary', 'Active voice: \"The ball was kicked by John.\"', 'John kicked the ball', 'The ball kicks John', 'John was kicked', 'None', 1),
(149, 27, 'secondary', 'Synonym of \"ancient\"?', 'modern', 'old', 'new', 'future', 2),
(150, 27, 'secondary', 'Choose correct tense: She ___ finished.', 'have', 'has', 'had', 'is', 2),
(151, 27, 'secondary', 'Plural of \"analysis\"?', 'analysises', 'analysis', 'analyses', 'analys', 3),
(152, 28, 'secondary', 'Which is a gas?', 'Water', 'Oxygen', 'Stone', 'Wood', 2),
(153, 28, 'secondary', 'Plants make food by?', 'Breathing', 'Photosynthesis', 'Sleeping', 'Eating', 2),
(154, 28, 'secondary', 'Which organ pumps blood?', 'Brain', 'Lungs', 'Heart', 'Kidney', 3),
(155, 28, 'secondary', 'Water changes to vapor by?', 'Freezing', 'Melting', 'Evaporation', 'Cooling', 3),
(156, 29, 'secondary', 'Water boils at ___ degrees Celsius.', '90', '100', '120', '80', 2),
(157, 29, 'secondary', 'Which planet is known as the Red Planet?', 'Mars', 'Venus', 'Jupiter', 'Saturn', 1),
(158, 29, 'secondary', 'The process of plants making food is called?', 'Respiration', 'Photosynthesis', 'Digestion', 'Transpiration', 2),
(159, 29, 'secondary', 'Which gas do humans inhale?', 'Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Helium', 1),
(160, 29, 'secondary', 'SI unit of force?', 'Joule', 'Newton', 'Watt', 'Pascal', 2),
(161, 29, 'secondary', 'Chemical formula of Carbon dioxide?', 'CO2', 'O2', 'H2O', 'NaCl', 1),
(162, 29, 'secondary', 'Cell is the basic unit of?', 'Life', 'Matter', 'Energy', 'Force', 1),
(163, 29, 'secondary', 'Which gas is most abundant in air?', 'Oxygen', 'Nitrogen', 'Carbon dioxide', 'Hydrogen', 2),
(164, 29, 'secondary', 'Friction produces?', 'Light', 'Heat', 'Sound', 'Water', 2),
(165, 30, 'secondary', 'Smallest planet?', 'Mars', 'Earth', 'Mercury', 'Venus', 3),
(166, 30, 'secondary', 'Process of water cycle?', 'Evaporation', 'Digestion', 'Respiration', 'Absorption', 1),
(167, 30, 'secondary', 'Human brain controls?', 'Breathing', 'Thinking', 'Walking', 'Eating', 2),
(168, 30, 'secondary', 'Force that pulls objects to Earth?', 'Magnetism', 'Gravity', 'Friction', 'Energy', 2),
(169, 30, 'secondary', 'Energy stored in food?', 'Solar', 'Chemical', 'Wind', 'Water', 2),
(170, 31, 'secondary', 'What is the chemical formula of water?', 'H2O', 'CO2', 'O2', 'NaCl', 1),
(171, 31, 'secondary', 'Which gas is used in photosynthesis?', 'Oxygen', 'Hydrogen', 'Carbon dioxide', 'Nitrogen', 3),
(172, 31, 'secondary', 'The force that pulls objects toward Earth is called?', 'Magnetism', 'Friction', 'Gravity', 'Pressure', 3),
(173, 31, 'secondary', 'Which organ pumps blood in the human body?', 'Lungs', 'Brain', 'Heart', 'Kidney', 3),
(174, 31, 'secondary', 'What is the boiling point of water?', '100°C', '90°C', '80°C', '120°C', 1),
(175, 31, 'secondary', 'Plants prepare food by?', 'Respiration', 'Photosynthesis', 'Digestion', 'Transpiration', 2),
(176, 31, 'secondary', 'Which vitamin is obtained from sunlight?', 'Vitamin A', 'Vitamin B', 'Vitamin C', 'Vitamin D', 4),
(177, 31, 'secondary', 'Acid turns blue litmus paper to?', 'Red', 'Green', 'Yellow', 'Blue', 1),
(178, 31, 'secondary', 'Force is measured in?', 'Newton', 'Joule', 'Watt', 'Pascal', 1),
(179, 31, 'secondary', 'Boiling point of water?', '90°C', '100°C', '80°C', '120°C', 2),
(180, 31, 'secondary', 'Unit of work?', 'Newton', 'Watt', 'Joule', 'Pascal', 3),
(181, 31, 'secondary', 'Speed formula?', 'distance/time', 'time/distance', 'mass/volume', 'force/mass', 1),
(182, 31, 'secondary', 'Atomic number represents?', 'Protons', 'Neutrons', 'Electrons', 'Atoms', 1),
(183, 31, 'secondary', 'Law of inertia was given by?', 'Newton', 'Einstein', 'Galileo', 'Faraday', 1),
(184, 31, 'secondary', 'pH less than 7 indicates?', 'Base', 'Neutral', 'Acid', 'Salt', 3),
(185, 32, 'secondary', 'Who was the first President of the USA?', 'George Washington', 'Abraham Lincoln', 'Thomas Jefferson', 'John Adams', 1),
(186, 32, 'secondary', 'Which continent is Egypt in?', 'Africa', 'Asia', 'Europe', 'Australia', 1),
(187, 32, 'secondary', 'The Great Wall is located in which country?', 'China', 'India', 'Russia', 'Japan', 1),
(188, 32, 'secondary', 'Which is a fundamental right?', 'Freedom of Speech', 'Pay Taxes', 'Drive Car', 'Own a Rocket', 1),
(189, 33, 'secondary', 'Capital of France?', 'Berlin', 'Madrid', 'Paris', 'Rome', 3),
(190, 33, 'secondary', 'Who wrote the Indian Constitution?', 'Gandhi', 'B.R. Ambedkar', 'Nehru', 'Patel', 2),
(191, 33, 'secondary', 'Largest ocean?', 'Indian', 'Pacific', 'Atlantic', 'Arctic', 2),
(192, 33, 'secondary', 'Which continent is India in?', 'Africa', 'Asia', 'Europe', 'Australia', 2),
(193, 33, 'secondary', 'Democracy means rule by?', 'King', 'People', 'Army', 'President', 2),
(194, 34, 'secondary', 'Who discovered America?', 'Columbus', 'Vasco da Gama', 'Cook', 'Magellan', 1),
(195, 34, 'secondary', 'UN headquarters located in?', 'London', 'Paris', 'New York', 'Geneva', 3),
(196, 34, 'secondary', 'Which country is largest by area?', 'USA', 'China', 'Russia', 'India', 3),
(197, 34, 'secondary', 'The Earth rotates on its?', 'Axis', 'Orbit', 'Path', 'Line', 1),
(198, 34, 'secondary', 'Types of government include?', 'Democracy', 'Monarchy', 'Dictatorship', 'All of these', 4),
(199, 35, 'secondary', 'French Revolution began in?', '1776', '1789', '1800', '1812', 2),
(200, 35, 'secondary', 'Indian National Congress founded in?', '1885', '1905', '1947', '1857', 1),
(2001, 35, 'secondary', 'Largest democracy in the world?', 'USA', 'India', 'UK', 'Canada', 2),
(2002, 35, 'secondary', 'Parliament of India has?', 'One house', 'Two houses', 'Three houses', 'Four houses', 2),
(2003, 35, 'secondary', 'Fundamental rights are protected by?', 'Constitution', 'President', 'Prime Minister', 'Court', 1),
(2004, 36, 'highschool', 'What is the value of x in 2x + 6 = 14?', '2', '3', '4', '5', 3),
(2005, 36, 'highschool', 'Factor of x² - 9?', '(x-3)(x+3)', '(x-9)(x+1)', '(x-1)(x+9)', 'Prime', 1),
(2006, 36, 'highschool', '√144 equals?', '10', '11', '12', '13', 3),
(2007, 36, 'highschool', 'Area of circle formula?', 'πr²', '2πr', 'πd', 'r²', 1),
(2008, 36, 'highschool', 'Slope formula?', 'y2-y1/x2-x1', 'x2-x1/y2-y1', 'y/x', 'None', 1),
(2009, 36, 'highschool', 'Quadratic formula contains?', '√b²-4ac', '√a²+bc', '2ab', 'ac²', 1),
(2010, 36, 'highschool', 'Value of sin 90°?', '0', '1', '-1', '0.5', 2),
(2011, 36, 'highschool', 'Derivative of x²?', '2x', 'x', 'x³', '1', 1),
(2012, 36, 'highschool', 'Probability range?', '0 to 1', '1 to 10', '-1 to 1', '0 to 100', 1),
(2013, 36, 'highschool', 'Value of log10 100?', '1', '2', '10', '100', 2),
(2014, 37, 'highschool', 'Synonym of \"Rapid\"?', 'Slow', 'Fast', 'Late', 'Weak', 2),
(2015, 37, 'highschool', 'Antonym of \"Brave\"?', 'Bold', 'Cowardly', 'Strong', 'Heroic', 2),
(2016, 37, 'highschool', 'Identify noun:', 'Run', 'Quickly', 'Happiness', 'Blue', 3),
(2017, 37, 'highschool', 'Correct tense: She ___ gone.', 'has', 'have', 'had', 'is', 1),
(2018, 37, 'highschool', 'Metaphor is?', 'Comparison without like/as', 'Opposite', 'Question', 'Fact', 1),
(2019, 37, 'highschool', 'Plural of \"Child\"?', 'Childs', 'Children', 'Childes', 'Childrens', 2),
(2020, 37, 'highschool', 'Active voice of: Ball was thrown?', 'He threw the ball', 'Ball threw him', 'Throw ball', 'None', 1),
(2021, 37, 'highschool', 'Article before vowel sound?', 'A', 'An', 'The', 'No article', 2),
(2022, 37, 'highschool', 'Adjective describes?', 'Noun', 'Verb', 'Adverb', 'Pronoun', 1),
(2023, 37, 'highschool', 'Correct spelling?', 'Definately', 'Definitely', 'Definetly', 'Definatelye', 2),
(2024, 38, 'highschool', 'Chemical symbol of Sodium?', 'Na', 'S', 'So', 'Sn', 1),
(2025, 38, 'highschool', 'Speed formula?', 'Distance/Time', 'Time/Distance', 'Mass/Volume', 'Force/Area', 1),
(2026, 38, 'highschool', 'Unit of force?', 'Newton', 'Joule', 'Watt', 'Pascal', 1),
(2027, 38, 'highschool', 'Human heart chambers?', '2', '3', '4', '5', 3),
(2028, 38, 'highschool', 'pH of neutral solution?', '5', '6', '7', '8', 3),
(2029, 38, 'highschool', 'Photosynthesis occurs in?', 'Chloroplast', 'Nucleus', 'Ribosome', 'Mitochondria', 1),
(2030, 38, 'highschool', 'Electric current unit?', 'Volt', 'Ampere', 'Watt', 'Ohm', 2),
(2031, 38, 'highschool', 'Law of inertia by?', 'Newton', 'Einstein', 'Galileo', 'Tesla', 1),
(2032, 38, 'highschool', 'Atomic number equals?', 'Protons', 'Neutrons', 'Electrons', 'Mass', 1),
(2033, 38, 'highschool', 'Boiling point of water?', '90°C', '100°C', '80°C', '120°C', 2),
(2034, 39, 'highschool', 'World War I began in?', '1912', '1914', '1916', '1918', 2),
(2035, 39, 'highschool', 'Mahatma Gandhi led?', 'Civil Rights', 'Non-cooperation', 'World War', 'Revolution', 2),
(2036, 39, 'highschool', 'French Revolution year?', '1789', '1776', '1800', '1812', 1),
(2037, 39, 'highschool', 'UN founded in?', '1945', '1950', '1939', '1918', 1),
(2038, 39, 'highschool', 'Cold War was between?', 'USA & USSR', 'India & China', 'UK & France', 'None', 1),
(2039, 39, 'highschool', 'Berlin Wall fell in?', '1985', '1989', '1991', '1995', 2),
(2040, 39, 'highschool', 'Industrial Revolution started in?', 'USA', 'Germany', 'Britain', 'France', 3),
(2041, 39, 'highschool', 'Nelson Mandela country?', 'USA', 'India', 'South Africa', 'Brazil', 3),
(2042, 39, 'highschool', 'American Independence year?', '1776', '1789', '1800', '1810', 1),
(2043, 39, 'highschool', 'First President of USA?', 'Lincoln', 'Washington', 'Jefferson', 'Adams', 2),
(2044, 40, 'highschool', 'Full form of CPU?', 'Central Process Unit', 'Central Processing Unit', 'Computer Unit', 'Control Unit', 2),
(2045, 40, 'highschool', 'Binary system uses?', '0 & 1', '1-9', '0-9', 'A-Z', 1),
(2046, 40, 'highschool', 'HTML stands for?', 'Hyper Text Markup Language', 'High Text', 'Hyper Tool', 'None', 1),
(2047, 40, 'highschool', 'Primary memory?', 'RAM', 'Hard disk', 'USB', 'CD', 1),
(2048, 40, 'highschool', 'Operating system example?', 'Windows', 'MS Word', 'Excel', 'Chrome', 1),
(2049, 40, 'highschool', 'IP stands for?', 'Internet Protocol', 'Internal Program', 'Input Process', 'None', 1),
(2050, 40, 'highschool', 'Loop structure repeats?', 'Code', 'Variable', 'File', 'Image', 1),
(2051, 40, 'highschool', '1 byte equals?', '4 bits', '8 bits', '16 bits', '32 bits', 2),
(2052, 40, 'highschool', 'Database language?', 'HTML', 'CSS', 'SQL', 'PHP', 3),
(2053, 40, 'highschool', 'AI stands for?', 'Artificial Intelligence', 'Auto Input', 'Advanced Internet', 'None', 1),
(3001, 41, 'highschool', 'Value of sin²θ + cos²θ is?', '0', '1', '2', '-1', 2),
(3002, 41, 'highschool', 'Derivative of x² is?', 'x', '2x', 'x²', '2', 2),
(3003, 41, 'highschool', 'If A = {1,2,3}, number of subsets?', '3', '6', '8', '9', 3),
(3004, 41, 'highschool', 'Slope of line y = 3x + 5?', '5', '3', '8', '0', 2),
(3005, 41, 'highschool', 'log₁₀(100) equals?', '1', '2', '10', '100', 2),
(3006, 42, 'highschool', 'Who wrote \"The Portrait of a Lady\"?', 'R.K. Narayan', 'Khushwant Singh', 'Tagore', 'Premchand', 2),
(3007, 42, 'highschool', 'A synonym for \"Brave\"?', 'Coward', 'Fearful', 'Bold', 'Weak', 3),
(3008, 42, 'highschool', 'Identify the noun: \"She sings beautifully.\"', 'She', 'Sings', 'Beautifully', 'None', 1),
(3009, 42, 'highschool', 'Antonym of \"Ancient\"?', 'Old', 'Modern', 'Historic', 'Past', 2),
(3010, 42, 'highschool', 'Figure of speech in \"Time is money\"?', 'Simile', 'Metaphor', 'Alliteration', 'Irony', 2),
(3011, 43, 'highschool', 'SI unit of Force?', 'Joule', 'Newton', 'Watt', 'Pascal', 2),
(3012, 43, 'highschool', 'Atomic number represents?', 'Protons', 'Neutrons', 'Electrons', 'Mass', 1),
(3013, 43, 'highschool', 'pH value less than 7 is?', 'Neutral', 'Basic', 'Acidic', 'Salt', 3),
(3014, 43, 'highschool', 'Speed = ?', 'Distance/Time', 'Time/Distance', 'Mass/Volume', 'Force/Area', 1),
(3015, 43, 'highschool', 'Mitochondria is known as?', 'Brain', 'Powerhouse', 'Nucleus', 'Cell wall', 2),
(3016, 44, 'highschool', 'Harappan civilization was located near?', 'Ganga', 'Indus', 'Nile', 'Amazon', 2),
(3017, 44, 'highschool', 'Ashoka belonged to which dynasty?', 'Gupta', 'Maurya', 'Mughal', 'Chola', 2),
(3018, 44, 'highschool', 'French Revolution started in?', '1776', '1789', '1815', '1857', 2),
(3019, 44, 'highschool', 'Vedas were written in?', 'Hindi', 'Sanskrit', 'Tamil', 'Persian', 2),
(3020, 44, 'highschool', 'Who founded the Mauryan Empire?', 'Ashoka', 'Chandragupta Maurya', 'Akbar', 'Harsha', 2),
(3021, 45, 'highschool', 'Python is a?', 'Compiler', 'Interpreter', 'OS', 'Browser', 2),
(3022, 45, 'highschool', 'Binary number system base?', '2', '8', '10', '16', 1),
(3023, 45, 'highschool', 'HTML stands for?', 'Hyper Text Markup Language', 'High Text Machine Language', 'Home Tool Markup Language', 'None', 1),
(3024, 45, 'highschool', 'CPU stands for?', 'Central Process Unit', 'Central Processing Unit', 'Computer Processing Unit', 'None', 2),
(3025, 45, 'highschool', 'RAM is?', 'Permanent memory', 'Secondary memory', 'Primary memory', 'External memory', 3),
(3026, 46, 'highschool', 'Integral of 1/x dx?', 'ln|x|', 'x', '1', 'x²', 1),
(3027, 46, 'highschool', 'Determinant of 2x2 matrix formula?', 'ad - bc', 'ab - cd', 'a + d', 'ac - bd', 1),
(3028, 46, 'highschool', 'Probability value lies between?', '0 and 1', '1 and 2', '-1 and 1', '0 and 10', 1),
(3029, 46, 'highschool', 'Derivative of sin x?', 'cos x', '-cos x', 'tan x', '-sin x', 1),
(3030, 46, 'highschool', 'Vector has?', 'Magnitude only', 'Direction only', 'Both magnitude and direction', 'None', 3),
(3031, 47, 'highschool', 'Author of \"The Last Lesson\"?', 'Alphonse Daudet', 'Shakespeare', 'Tagore', 'Hardy', 1),
(3032, 47, 'highschool', 'Synonym of \"Eloquent\"?', 'Silent', 'Fluent', 'Angry', 'Weak', 2),
(3033, 47, 'highschool', 'Tense of \"She had gone\"?', 'Present', 'Future', 'Past Perfect', 'Simple Past', 3),
(3034, 47, 'highschool', 'A sonnet has how many lines?', '12', '14', '16', '10', 2),
(3035, 47, 'highschool', 'Opposite of \"Scarcity\"?', 'Shortage', 'Abundance', 'Lack', 'Need', 2),
(3036, 48, 'highschool', 'Unit of electric current?', 'Volt', 'Ampere', 'Ohm', 'Watt', 2),
(3037, 48, 'highschool', 'DNA stands for?', 'Deoxyribonucleic Acid', 'Ribonucleic Acid', 'Dynamic Acid', 'None', 1),
(3038, 48, 'highschool', 'Ohm’s Law formula?', 'V=IR', 'P=VI', 'E=mc²', 'F=ma', 1),
(3039, 48, 'highschool', 'Human heart has how many chambers?', '2', '3', '4', '5', 3),
(3040, 48, 'highschool', 'Photosynthesis occurs in?', 'Mitochondria', 'Chloroplast', 'Nucleus', 'Ribosome', 2),
(3041, 49, 'highschool', 'Quit India Movement year?', '1942', '1930', '1919', '1857', 1),
(3042, 49, 'highschool', 'Partition of India year?', '1945', '1946', '1947', '1950', 3),
(3043, 49, 'highschool', 'Leader of Non-Cooperation Movement?', 'Nehru', 'Gandhi', 'Patel', 'Bose', 2),
(3044, 49, 'highschool', 'Indian Constitution adopted in?', '1947', '1950', '1952', '1949', 2),
(3045, 49, 'highschool', 'Simon Commission came in?', '1928', '1919', '1935', '1942', 1),
(3046, 50, 'highschool', 'SQL is used for?', 'Styling', 'Database management', 'Gaming', 'Design', 2),
(3047, 50, 'highschool', 'Primary key must be?', 'Duplicate', 'Null', 'Unique', 'Optional', 3),
(3048, 50, 'highschool', 'Which is a loop in Python?', 'for', 'loop', 'iterate', 'repeat', 1),
(3049, 50, 'highschool', 'LAN stands for?', 'Local Area Network', 'Large Area Network', 'Logical Area Network', 'None', 1),
(3050, 50, 'highschool', 'AI stands for?', 'Artificial Intelligence', 'Automatic Input', 'Advanced Internet', 'None', 1),
(3051, 51, 'kindergarten', 'What color is the sun?', 'Blue', 'Yellow', 'Green', 'Purple', 2),
(3052, 51, 'kindergarten', 'Which color is an apple?', 'Red', 'Black', 'Brown', 'White', 1),
(3053, 51, 'kindergarten', 'What color is grass?', 'Pink', 'Orange', 'Green', 'Grey', 3),
(3054, 1, 'kindergarten', 'What number comes after 1?', '3', '2', '4', '5', 2),
(3055, 1, 'kindergarten', 'How many fingers are on one hand?', '3', '4', '5', '6', 3),
(3056, 1, 'kindergarten', 'What is 1 + 1?', '1', '3', '2', '4', 3),
(3057, 4, 'kindergarten', 'Which letter is a vowel?', 'B', 'C', 'E', 'F', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `level`, `created_at`, `email_verified`) VALUES
(28, 'Hema', 'dhemagpc@gmail.com', 'admin', '$2y$10$hMGi/5Dk9kFhDfNM4fXohuXjP52vX0ToMNwFjT96KBQLmLueic3ji', 'admin', '2026-03-08 12:30:35', 1),
(29, 'Niranjani', 'niranjani040205@gmail.com', 'student', '$2y$10$gr9feUJrUBcqqJ6hT5hrD.w9XQCfJHAofoQw2Yx8/S9KGUe/FL8nC', 'kindergarten', '2026-03-09 04:57:34', 1),
(30, 'Hema', 'hema24501154@gmail.com', 'teacher', '$2y$10$NwtEacvh4xDjNUMGLWGDT.bVRUs9Y1oR.lNZFDK6oNJb2kvmCzOiS', 'primary', '2026-03-09 05:03:47', 1),
(31, 'Shwetha', 'hemacitycampus@gmail.com', 'student', '$2y$10$0VtwHKwdTTQ59muuDANxHOtJZZ8ACPrM1wxc0zfQNAjRIoNwgNXoe', 'primary', '2026-03-10 08:33:20', 1),
(33, 'Kobika', 'kobikagptc@gmail.com', 'teacher', '$2y$10$vU1cQELNXnc6PUD7GqDej.5.5MGmsuReJYoAVZAOr9KUL7AeeSD.q', 'secondary', '2026-03-10 08:57:28', 1),
(34, 'Raveena', 'rave24501175@gmail.com', 'student', '$2y$10$vU1cQELNXnc6PUD7GqDej.5.5MGmsuReJYoAVZAOr9KUL7AeeSD.q', 'secondary', '2026-03-10 10:21:25', 1),
(35, 'Preethi', 'kpreethi346@gmail.com', 'student', '$2y$10$9dUGC./KNg0IRMczcKG4y.59HQ3ZzdihBWe/8qfySQ899l76ilsCy', 'highschool', '2026-03-11 04:36:17', 1),
(36, 'Danasekar', 'evmds27@gmail.com', 'student', '$2y$10$z1u2.I/bNGQbQUt0WN6DX.vJet33nZIgAno.dVE8dq2oOUtJKqiKm', 'undergraduate', '2026-03-14 06:42:18', 1),
(37, 'Nalini', 'nalinidanasekar27@gmail.com', 'student', '$2y$10$lZvafyrggC0mKlKI9HAhAO7fv6Rkyw/cvK/FiWrRKUmgLqDpgGNrW', 'postgraduate', '2026-03-14 07:03:39', 1),
(38, 'Kobika', 'kobikacitycampus@gmail.com', 'teacher', '$2y$10$eEBx4RUEg/IJd7jni3ATi.1I7SXqyErEKxkT7vFSqhu/.WE9XiEQG', 'kindergarten', '2026-03-14 07:07:49', 1),
(39, 'Ramya', 'hemadvbce@gmail.com', 'teacher', '$2y$10$Odd9pSetxy5mFjU7Uf9LquUm9wzquSTENld0.mI0du9Jc7fb4xBne', 'postgraduate', '2026-04-03 10:12:08', 1),
(40, 'Karthi', 'kobikadvbce@gmail.com', 'teacher', '$2y$10$fTnziJfAB6wEnczdr7K.se98RsCBIh2MJCJPhX8Cc6hMFBEWRY/JC', 'highschool', '2026-04-03 10:15:05', 1),
(41, 'Maya', 'hemkocreations@gmail.com', 'teacher', '$2y$10$1M34YQcfF1u.cTlG1LdTsut1HkpjN5V1fi9U9wTVnnsXxwHNiq.p6', 'undergraduate', '2026-04-03 10:16:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` varchar(50) NOT NULL,
  `quizzes_completed` int(11) DEFAULT 0,
  `certificate_unlocked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`id`, `user_id`, `level`, `quizzes_completed`, `certificate_unlocked`) VALUES
(4, 1, 'kindergarten', 4, 1),
(36, 2, 'primary', 15, 1),
(51, 3, 'secondary', 16, 1),
(74, 4, 'highschool', 15, 1),
(75, 22, 'kindergarten', 4, 1),
(91, 27, 'highschool', 0, 0),
(98, 29, 'kindergarten', 4, 1),
(103, 29, 'primary', 15, 1),
(119, 29, 'secondary', 35, 1),
(120, 29, 'highschool', 15, 1),
(121, 35, 'highschool', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_quizzes`
--
ALTER TABLE `admin_quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_notes`
--
ALTER TABLE `lesson_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `primary_lessons`
--
ALTER TABLE `primary_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_topics`
--
ALTER TABLE `project_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_quiz_id` (`admin_quiz_id`);

--
-- Indexes for table `quizzes1`
--
ALTER TABLE `quizzes1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_quiz` (`user_id`,`quiz_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`level`),
  ADD UNIQUE KEY `unique_user_level` (`user_id`,`level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `admin_quizzes`
--
ALTER TABLE `admin_quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3628;

--
-- AUTO_INCREMENT for table `lesson_notes`
--
ALTER TABLE `lesson_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `primary_lessons`
--
ALTER TABLE `primary_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `project_topics`
--
ALTER TABLE `project_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `quizzes1`
--
ALTER TABLE `quizzes1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3096;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
