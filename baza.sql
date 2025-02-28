-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               11.6.2-MariaDB - mariadb.org binary distribution
-- Serwer OS:                    Win64
-- HeidiSQL Wersja:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Zrzut struktury bazy danych cmr_project
CREATE DATABASE IF NOT EXISTS `cmr_project` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `cmr_project`;

-- Zrzut struktury tabela cmr_project.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli cmr_project.clients: ~15 rows (około)
INSERT INTO `clients` (`id`, `user_id`, `first_name`, `last_name`, `contact_email`, `contact_phone`, `created_at`) VALUES
	(2, 1, 'Jan', 'Kowalski', 'jan.kowalski@example.com', '+48 600 123 456', '2025-02-28 07:44:16'),
	(3, 1, 'Anna', 'Nowak', 'anna.nowak@example.com', '+48 601 234 567', '2025-01-18 07:44:16'),
	(4, 1, 'Piotr', 'Wiśniewski', 'piotr.wisniewski@example.com', '+48 602 345 678', '2025-02-28 07:44:16'),
	(5, 1, 'Maria', 'Dąbrowska', 'maria.dabrowska@example.com', '+48 603 456 789', '2025-02-28 07:44:16'),
	(6, 1, 'Tomasz', 'Lewandowski', 'tomasz.lewandowski@example.com', '+48 604 567 890', '2025-02-28 07:44:16'),
	(7, 1, 'Agnieszka', 'Wójcik', 'agnieszka.wojcik@example.com', '+48 605 678 901', '2025-02-28 07:44:16'),
	(8, 1, 'Marek', 'Kamiński', 'marek.kaminski@example.com', '+48 606 789 012', '2025-02-28 07:44:16'),
	(9, 1, 'Katarzyna', 'Zielińska', 'katarzyna.zielinska@example.com', '+48 607 890 123', '2025-02-28 07:44:16'),
	(10, 1, 'Paweł', 'Szymański', 'pawel.szymanski@example.com', '+48 608 901 234', '2025-02-28 07:44:16'),
	(11, 1, 'Magdalena', 'Woźniak', 'magdalena.wozniak@example.com', '+48 609 012 345', '2025-02-28 07:44:16'),
	(12, 1, 'Krzysztof', 'Kowalczyk', 'krzysztof.kowalczyk@example.com', '+48 610 123 456', '2025-02-28 07:44:16'),
	(13, 1, 'Ewa', 'Jankowska', 'ewa.jankowska@example.com', '+48 611 234 567', '2025-02-28 07:44:16'),
	(14, 1, 'Łukasz', 'Mazur', 'lukasz.mazur@example.com', '+48 612 345 678', '2025-02-28 07:44:16'),
	(15, 1, 'Barbara', 'Krawczyk', 'barbara.krawczyk@example.com', '+48 613 456 789', '2025-02-28 07:44:16'),
	(16, 1, 'Andrzej', 'Piotrowski', 'andrzej.piotrowski@example.com', '+48 614 567 890', '2025-02-28 07:44:16');

-- Zrzut struktury tabela cmr_project.notes
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `report_id` (`report_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli cmr_project.notes: ~6 rows (około)
INSERT INTO `notes` (`id`, `report_id`, `user_id`, `content`, `created_at`) VALUES
	(16, 1, 1, 'Pierwsza notatka do raportu 1.', '2025-02-28 11:10:32'),
	(17, 1, 1, 'Druga notatka do raportu 1.', '2025-02-28 12:10:32'),
	(18, 1, 1, 'Trzecia notatka do raportu 1.', '2025-02-28 13:10:32'),
	(19, 1, 1, 'Czwarta notatka do raportu 1.', '2025-02-28 14:10:32'),
	(20, 1, 1, 'Piąta notatka do raportu 1.', '2025-02-28 15:10:32'),
	(21, 1, 1, 'Zakończenie projektu', '2025-02-28 12:14:49');

-- Zrzut struktury tabela cmr_project.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `clients_id` int(11) DEFAULT NULL,
  `tasks_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli cmr_project.reports: ~3 rows (około)
INSERT INTO `reports` (`id`, `user_id`, `clients_id`, `tasks_id`, `title`, `content`, `created_at`) VALUES
	(1, 1, 6, 25, 'Raport miesięczny', 'Podsumowanie działań z ostatniego miesiąca.', '2025-02-25 19:02:50'),
	(2, 1, 6, 28, 'Dobry Raport', 'Raportuje ukończenie', '2025-02-28 11:43:20'),
	(3, 1, 6, 29, 'aa', 'aa', '2025-02-28 11:46:56');

-- Zrzut struktury tabela cmr_project.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted` int(11) DEFAULT 0,
  `reported` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli cmr_project.tasks: ~7 rows (około)
INSERT INTO `tasks` (`id`, `client_id`, `title`, `description`, `status`, `due_date`, `created_at`, `deleted`, `reported`) VALUES
	(24, 2, 'Aktualizacja umowy', 'Zmiana warunków umowy na dostawy sprzętu biurowego.', 'completed', '2024-03-20', '2025-02-28 08:04:13', 1, 0),
	(25, 3, 'Weryfikacja płatności', 'Sprawdzenie zaległych płatności za ostatni kwartał.', 'completed', '2024-03-18', '2025-02-28 08:04:13', 0, 0),
	(28, 6, 'Serwis systemu CRM', 'Diagnoza problemów w systemie i aktualizacja bazy danych.', 'completed', '2024-03-17', '2025-02-28 08:04:13', 1, 1),
	(29, 6, 'Analiza rynku', 'Przeprowadzenie analizy konkurencji dla nowego produktu klienta.', 'in_progress', '2024-03-19', '2025-02-28 08:04:13', 0, 1),
	(30, 7, 'bbb', 'Organizacja szkolenia dla działu sprzedaży klienta.', 'completed', '2024-03-24', '2025-02-28 08:04:13', 0, 0),
	(32, 10, 'Funkcje', 'Testy nowej funkcjonalności w aplikacji klienta.', 'completed', '2024-03-23', '2025-02-28 08:04:13', 0, 0),
	(33, 14, 'Dodawanie Tasków na stronie klienta', 'Musiym dodoać nową podstronę ', 'in_progress', '2025-03-07', '2025-02-28 09:25:02', 0, 0);

-- Zrzut struktury tabela cmr_project.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Zrzucanie danych dla tabeli cmr_project.users: ~1 rows (około)
INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
	(1, 'janek', '1', 'janek@example.com', '2025-02-25 19:02:50'),
	(2, 'a', '1', 'a@a', '2025-02-28 12:35:10');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
