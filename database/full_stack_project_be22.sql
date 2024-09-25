-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Aug 2024 um 20:54
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `full_stack_project_be22`
--
CREATE DATABASE IF NOT EXISTS `full_stack_project_be22` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `full_stack_project_be22`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `availability`
--

CREATE TABLE `availability` (
  `id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `unavailable_date` datetime DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `availability`
--

INSERT INTO `availability` (`id`, `trainer_id`, `unavailable_date`, `is_available`) VALUES
(1, 5, '2024-08-28 14:10:00', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `tutoring_service_id` int(11) DEFAULT NULL,
  `booking_date` datetime NOT NULL,
  `status` enum('booked','completed','cancelled') NOT NULL DEFAULT 'booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `bookings`
--

INSERT INTO `bookings` (`id`, `student_id`, `tutoring_service_id`, `booking_date`, `status`) VALUES
(1, 2, NULL, '2024-08-22 12:16:03', 'booked'),
(2, 2, NULL, '2024-08-27 11:44:43', 'booked'),
(3, 2, NULL, '2024-08-28 09:45:24', 'booked'),
(4, 7, NULL, '2024-08-28 11:11:19', 'booked'),
(5, 2, NULL, '2024-08-29 10:30:09', 'booked'),
(6, 7, 12, '2024-08-29 13:40:32', 'booked'),
(7, 10, 12, '2024-08-29 13:40:54', 'booked'),
(8, 8, NULL, '2024-08-29 14:21:16', 'booked'),
(9, 22, 16, '2024-08-29 14:27:54', 'booked');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `tutoring_service_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `reviews`
--

INSERT INTO `reviews` (`id`, `student_id`, `tutoring_service_id`, `rating`, `comment`) VALUES
(4, 8, 22, 5, 'Dr. David Clark’s Modern History training offers a clear and insightful overview of key 19th and 20th-century events, from industrialization to world wars. Highly recommended for a comprehensive historical perspective, especially if you need insight on everything from the beginning!');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(5, 'Biology'),
(8, 'Chemistry'),
(3, 'Computer Science'),
(4, 'Economics'),
(7, 'History'),
(6, 'Literature'),
(1, 'Mathematics'),
(9, 'Philosophy'),
(2, 'Physics'),
(10, 'Political Science');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tutoring_services`
--

CREATE TABLE `tutoring_services` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `university_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(7,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `tutoring_services`
--

INSERT INTO `tutoring_services` (`id`, `title`, `trainer_id`, `subject_id`, `university_id`, `description`, `price`, `capacity`, `date_from`, `date_to`) VALUES
(12, 'Introduction to Bioinformatics', 5, 5, 1, 'Learn the basics of bioinformatics tools and databases. This course focuses on sequence alignment, phylogenetics, and genome analysis, equipping you with the skills to analyze biological data effectively.', 100.00, 5, '2024-08-30 13:00:00', '2024-08-30 19:00:00'),
(13, 'Algorithms and Data Structures Bootcamp', 13, 3, 3, 'Strengthen your understanding of fundamental algorithms and data structures. This intensive course covers sorting algorithms, tree and graph structures, and optimization techniques, with coding challenges to solidify learning.', 30.00, 10, '2024-09-02 15:00:00', '2024-09-06 18:00:00'),
(14, 'Introduction to Machine Learning', 13, 3, 3, 'Learn the basics of machine learning, including supervised and unsupervised learning, neural networks, and model evaluation. This training is project-based, allowing you to build and test your own machine learning models.', 90.00, 4, '2024-09-04 15:00:00', '2024-09-05 21:00:00'),
(15, 'Introduction to Ethics and Moral Philosophy', 14, 9, 5, 'Explore the foundational concepts in ethics and moral philosophy, including consequentialism, deontology, and virtue ethics. This training delves into classical and contemporary debates, helping students develop critical thinking skills and ethical reasoning.', 50.00, 8, '2024-09-05 12:00:00', '2024-09-05 16:00:00'),
(16, 'Philosophical Analysis and Argumentation', 14, 9, 5, 'Enhance your ability to analyze philosophical texts and construct logical arguments. This course focuses on dissecting complex ideas, identifying fallacies, and sharpening your skills in written and oral argumentation.', 100.00, 2, '2024-09-09 10:00:00', '2024-09-09 21:00:00'),
(17, 'Organic Chemistry Fundamentals', 15, 8, 4, 'Explore key concepts in organic chemistry, including reaction mechanisms, stereochemistry, and functional groups with interactive examples.', 75.00, 7, '2024-09-03 14:00:00', '2024-09-03 21:30:00'),
(18, 'Inorganic Chemistry: Structures and Reactions', 15, 8, 4, 'Delve into the principles of inorganic chemistry, focusing on molecular structures, bonding theories, and reaction types.', 20.00, 20, '2024-09-06 17:00:00', '2024-09-06 21:10:00'),
(19, 'Microeconomics: Theory and Application', 16, 4, 5, 'Deepen your understanding of microeconomic theory and its application to real-world problems, including market structures and consumer behavior.', 50.00, 5, '2024-09-17 15:00:00', '2024-09-20 21:10:00'),
(20, 'Econometrics: Tools and Techniques', 16, 4, 5, 'Learn essential econometric tools such as regression analysis and hypothesis testing with practical examples using statistical software.', 80.00, 3, '2024-09-09 15:10:00', '2024-09-10 17:45:00'),
(21, 'Ancient Civilizations: A Comprehensive Overview', 17, 7, 2, 'Explore the major ancient civilizations, including Mesopotamia, Egypt, Greece, and Rome, focusing on their cultural, political, and social impacts.', 80.00, 10, '2024-08-30 16:30:00', '2024-08-30 20:30:00'),
(22, 'Modern History: Key Events and Movements', 17, 7, 2, 'Examine significant events and movements from the 19th and 20th centuries, including industrialization, world wars, and social changes.', 50.00, 5, '2024-09-03 11:00:00', '2024-09-03 16:45:00'),
(23, 'Literary Analysis: Themes and Symbols', 18, 6, 1, 'Enhance your ability to analyze literary texts by exploring themes, symbols, and narrative techniques.', 25.00, 25, '2024-09-05 15:00:00', '2024-09-05 20:00:00'),
(24, 'Essay Writing for Literature Students', 18, 6, 1, 'Improve your literary essay writing skills, focusing on structure, argumentation, and textual analysis.', 75.00, 5, '2024-09-03 14:30:00', '2024-09-03 18:30:00'),
(25, 'Calculus: From Limits to Integrals', 19, 1, 2, 'Master calculus concepts, including limits, derivatives, and integrals, with step-by-step problem-solving and application.', 150.00, 10, '2024-09-02 09:00:00', '2024-09-04 15:30:00'),
(26, 'Algebraic Structures and Functions', 19, 1, 2, 'Explore algebraic concepts such as equations, functions, and matrices, with practical exercises and theory explanations.', 400.00, 4, '2024-09-09 08:30:00', '2024-09-13 17:30:00'),
(27, 'Classical Mechanics: Forces and Motion', 20, 2, 3, 'Explore the fundamentals of classical mechanics, including Newton’s laws, kinematics, and dynamics, with problem-solving exercises.', 50.00, 10, '2024-08-31 08:30:00', '2024-08-31 19:30:00'),
(28, 'Electromagnetism: Theory and Applications', 20, 2, 3, 'Dive into electromagnetism concepts such as electric fields, magnetic fields, and Maxwell’s equations, with practical examples.\n', 90.00, 8, '2024-09-04 15:30:00', '2024-09-04 19:30:00'),
(29, 'Comparative Politics: Systems and Structures', 21, 10, 4, 'Analyze different political systems and structures, focusing on democracy, authoritarianism, and comparative government.', 60.00, 4, '2024-09-23 16:30:00', '2024-09-23 20:30:00'),
(30, 'International Relations: Theories and Practices', 21, 10, 4, 'Explore theories of international relations and their application to global issues, including diplomacy, conflict, and cooperation.', 75.00, 5, '2024-09-07 14:30:00', '2024-09-07 19:30:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `universities`
--

CREATE TABLE `universities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `universities`
--

INSERT INTO `universities` (`id`, `name`, `city`, `address`) VALUES
(1, 'Charles University', 'Prague', 'Ovocný trh 560/5, 116 36 Praha 1'),
(2, 'Masaryk University', 'Brno', 'Žerotínovo nám. 617/9, 601 77 Brno-střed'),
(3, 'Czech Technical University', 'Prague', 'Jugoslávských partyzánů 1580/3, 160 00 Praha 6'),
(4, 'Palacký University', 'Olomouc', 'Křížkovského 8, 771 47 Olomouc'),
(5, 'University of West Bohemia', 'Plzeň', 'Univerzitní 2732/8, 301 00 Plzeň 3');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('student','trainer','admin') NOT NULL DEFAULT 'student',
  `picture` varchar(255) NOT NULL,
  `profile_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `password`, `email`, `role`, `picture`, `profile_info`) VALUES
(2, 'John', 'Doe', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'bbb@gmail.com', 'student', '66d04fa3d9809.jpg', 'Hi, I am a university student majoring in Engineering, with a strong focus on advanced mathematics and physics. I am seeking a tutor to help me deepen my understanding of complex topics like differential equations and quantum mechanics. I prefer a hands-on approach with lots of problem-solving and real-world applications.'),
(5, 'Paulina', 'Kost', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'paulina@mail.com', 'trainer', 'avatar.png', 'Hello! I am a seasoned tutor with a background in biology, specializing in genetics, molecular biology, and bioinformatics. With five years of experience, I tailor my sessions to suit individual learning styles, using visual aids and practical examples to make complex concepts more accessible.'),
(6, 'Jane', 'Doe', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'aaa@gmail.com', 'admin', 'avatar.png', 'No'),
(7, 'Jane', 'Smith', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'aaa123@gmail.com', 'student', 'avatar.png', 'I’m a psychology student interested in cognitive neuroscience and behavioral analysis. I’m seeking guidance to better understand research methodologies and statistical analysis. I prefer interactive discussions and case studies to connect theory with real-world applications.'),
(8, 'Sophia', 'Turner', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'sophia@mail.com', 'student', '66d026ac83e79.jpg', 'Hi, I am a biology major passionate about genetics and molecular biology. I am looking for a tutor who can help me navigate complex topics like gene expression and bioinformatics. I enjoy learning through visual aids and practical examples and want to improve my lab skills and theoretical knowledge.'),
(9, 'Daniel', 'Brooks', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'daniel@mail.com', 'student', '66d026ddb38ab.jpg', 'I’m a psychology student interested in cognitive neuroscience and behavioral analysis. I’m seeking guidance to better understand research methodologies and statistical analysis. I prefer interactive discussions and case studies to connect theory with real-world applications.'),
(10, 'Alex', 'Ramirez', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'alex@mail.com', 'student', 'avatar.png', 'As a computer science major, I’m focused on mastering algorithms, data structures, and machine learning. I’m looking for a tutor who can provide clear explanations and help me work through challenging coding problems. I learn best by tackling projects and writing code.'),
(11, 'Rachel', 'Johnson', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'rachel@mail.com', 'student', 'avatar.png', 'I’m an economics student fascinated by microeconomics and econometrics. I’m looking for a tutor who can help me grasp advanced economic models and statistical tools. I appreciate detailed explanations and enjoy applying concepts to analyze real-world economic issues.'),
(12, 'Lily', 'Anderson', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'lily@mail.com', 'student', 'avatar.png', 'I am an English literature student with a passion for classic and contemporary fiction. I’m seeking help to deepen my literary analysis skills and improve my essay writing. I thrive in discussions about themes, symbolism, and narrative techniques.'),
(13, 'James', 'Carter', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'trainerjames@mail.com', 'trainer', 'avatar.png', 'I am a computer science tutor specializing in algorithms, data structures, and machine learning. With a hands-on teaching style, I help students work through challenging coding problems and projects, ensuring they build a strong foundation in both theory and application.'),
(14, 'Sarah', 'Mitchell', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'trainersarah@mail.com', 'trainer', 'avatar.png', 'Hello! I am a university-level tutor with a strong background in philosophy, specializing in ethics, moral philosophy, and the history of Western thought. With over five years of teaching experience, I tailor my sessions to each student&#039;s needs, focusing on developing critical thinking, analytical skills, and clear argumentation. Whether you&#039;re grappling with complex philosophical texts or looking to refine your reasoning abilities, I’m here to guide you through thoughtful discussions and rigorous analysis.'),
(15, 'Laura', 'Johnson', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'chemistry@gmail.com', 'trainer', 'avatar.png', 'Hi there! I’m a chemistry tutor with a strong background in organic and inorganic chemistry. My approach combines theoretical knowledge with practical experiments to make complex chemical processes more understandable and engaging.'),
(16, 'Michael', 'Thompson', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'economics@gmail.com', 'trainer', 'avatar.png', 'Hi! I’m an economics tutor with a focus on microeconomics, econometrics, and economic modeling. I offer detailed explanations and practical examples to help students apply economic theories to real-world scenarios.'),
(17, 'David', 'Clark', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'history@gmail.com', 'trainer', 'avatar.png', 'Hello! I’m a history tutor with expertise in both ancient and modern history. My sessions are designed to help students understand historical events and trends through engaging narratives and critical analysis.'),
(18, 'Anna', 'Reynolds', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'english@gmail.com', 'trainer', 'avatar.png', 'Hi, I’m an English literature tutor specializing in both classic and contemporary works. I focus on helping students analyze texts deeply and improve their literary essay writing through engaging discussions and practical exercises.'),
(19, 'Olivia', 'Evans', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'math@gmail.com', 'trainer', 'avatar.png', 'Hello! I’m a mathematics tutor with a strong background in algebra, calculus, and statistics. I offer a hands-on approach to problem-solving and concept reinforcement to help students excel in their math courses.'),
(20, 'Andrew', 'Miller', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'physics@gmail.com', 'trainer', 'avatar.png', 'Hi! I’m a physics tutor specializing in classical mechanics, electromagnetism, and quantum physics. My approach combines theoretical concepts with practical problem-solving to help students grasp complex physical principles.'),
(21, 'Julia', 'Carter', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'politics@gmail.com', 'trainer', 'avatar.png', 'Hello! I’m a political science tutor with expertise in comparative politics, international relations, and political theory. I offer engaging sessions to help students understand political systems, theories, and global issues.'),
(22, 'Jane', 'Doe', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'xxx@gmail.com', 'student', 'avatar.png', '');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indizes für die Tabelle `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tutoring_service_id` (`tutoring_service_id`);

--
-- Indizes für die Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tutoring_service_id` (`tutoring_service_id`);

--
-- Indizes für die Tabelle `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `tutoring_services`
--
ALTER TABLE `tutoring_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `university_id` (`university_id`);

--
-- Indizes für die Tabelle `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `availability`
--
ALTER TABLE `availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `tutoring_services`
--
ALTER TABLE `tutoring_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT für Tabelle `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `availability_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`tutoring_service_id`) REFERENCES `tutoring_services` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`tutoring_service_id`) REFERENCES `tutoring_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tutoring_services`
--
ALTER TABLE `tutoring_services`
  ADD CONSTRAINT `tutoring_services_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tutoring_services_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tutoring_services_ibfk_3` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
