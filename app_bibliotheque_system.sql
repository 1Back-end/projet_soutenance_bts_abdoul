-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 17 mars 2026 à 18:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app_bibliotheque_system`
--

-- --------------------------------------------------------

--
-- Structure de la table `authors`
--

CREATE TABLE `authors` (
  `author_uuid` varchar(255) NOT NULL,
  `author_full_name` varchar(255) DEFAULT NULL,
  `author_email` varchar(255) DEFAULT NULL,
  `author_phone_number` varchar(255) DEFAULT NULL,
  `author_second_phone_number` varchar(255) DEFAULT NULL,
  `author_nationality` varchar(255) DEFAULT NULL,
  `author_picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `authors`
--

INSERT INTO `authors` (`author_uuid`, `author_full_name`, `author_email`, `author_phone_number`, `author_second_phone_number`, `author_nationality`, `author_picture`, `is_active`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`, `added_by`, `updated_by`) VALUES
('a1b2c3d4-e5f6-11ed-afa1-0242ac120002', 'Albert Einstein', 'einstein@example.com', '+491234567890', NULL, 'Allemand', 'einstein.jpg', 1, NULL, NULL, 0, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL),
('a1b2c3d5-e5f6-11ed-afa1-0242ac120002', 'Marie Curie', 'curie@example.com', '+33123456789', '', 'Polonaise', '56d4fb132dfbe7bf_1773681172.png', 1, NULL, '2026-03-16 17:12:52', 0, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2'),
('a1b2c3d6-e5f6-11ed-afa1-0242ac120002', 'Isaac Newton', 'newton@example.com', '+441234567890', NULL, 'Anglais', 'newton.jpg', 1, NULL, NULL, 0, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL),
('a1b2c3d7-e5f6-11ed-afa1-0242ac120002', 'Victor Hugo', 'hugov@example.com', '+33123456780', NULL, 'Français', 'victor_hugo.jpg', 1, NULL, NULL, 0, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL),
('a1b2c3d8-e5f6-11ed-afa1-0242ac120002', 'Stephen Hawking', 'hawking@example.com', '+441234567891', '', 'Anglais', '7ebb1d111248398f_1773681430.png', 1, NULL, '2026-03-16 17:17:10', 0, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2'),
('a1b2c3d9-e5f6-11ed-afa1-0242ac120002', 'Simone de Beauvoir', 'beauvoir@example.com', '+33123456781', NULL, 'Française', 'beauvoir.jpg', 1, NULL, NULL, 0, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `book_uuid` varchar(255) NOT NULL,
  `category_uuid` varchar(255) NOT NULL,
  `genre_uuid` varchar(255) NOT NULL,
  `author_uuid` varchar(255) NOT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `book_publication_date` varchar(255) DEFAULT NULL,
  `book_isbn` varchar(255) DEFAULT NULL,
  `book_description` varchar(255) DEFAULT NULL,
  `book_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_deleted` tinyint(1) DEFAULT 0,
  `added_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `book_copies` varchar(255) DEFAULT NULL,
  `book_location` varchar(255) DEFAULT NULL,
  `book_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`book_uuid`, `category_uuid`, `genre_uuid`, `author_uuid`, `book_name`, `book_publication_date`, `book_isbn`, `book_description`, `book_picture`, `created_at`, `updated_at`, `deleted_at`, `is_active`, `is_deleted`, `added_by`, `updated_by`, `book_copies`, `book_location`, `book_code`) VALUES
('116efedfdd68bfab7050072e4d6003c0', '5c5d94688b3390c7ea3e96543a954d62', 'g1a2c3d8-e5f6-11ed-afa1-0242ac120002', 'a1b2c3d8-e5f6-11ed-afa1-0242ac120002', 'Le Petit Prince', '1963', '978-2-07-061275-8', 'Le Petit Prince', 'book_69b2a77d4f553.jpg', '2026-03-12 11:46:05', '2026-03-16 16:52:45', NULL, 1, 0, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '8', 'Salle B - Rayon 2', ''),
('40e215accb1eae127690c82728aceed2', '5c5d94688b3390c7ea3e96543a954d62', 'g1a2c3da-e5f6-11ed-afa1-0242ac120002', 'a1b2c3d5-e5f6-11ed-afa1-0242ac120002', 'Le Mystère de l\\&amp;#039;Ombre', '2026', '978-2-12345-678-9', 'Un roman captivant où le détective Élian enquête sur une série d’événements mystérieux dans une ville remplie de secrets. Suspense et rebondissements garantis pour les amateurs de thrillers.', 'book_69b2aaac64dba.jpg', '2026-03-12 11:59:40', '2026-03-16 16:52:57', NULL, 1, 0, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '8', 'Salle C - Rayon 2', 'LEM_1966_4887'),
('ced695e0394c15b5c20c7284ff38aa2f', '5c5d94688b3390c7ea3e96543a954d62', 'g1a2c3d9-e5f6-11ed-afa1-0242ac120002', 'a1b2c3d7-e5f6-11ed-afa1-0242ac120002', 'I Have Some Questions for You', '1966', '978-2-07-061275-7', 'Un roman contemporain de grande qualité littéraire qui mêle fiction, enquête et réflexion sur la mémoire, la justice et la vérité. Il a reçu un très bon accueil critique et a figuré parmi les livres les plus recommandés récemment dans la catégorie fiction', 'book_69b83c3395535.jpg', '2026-03-16 17:20:41', '2026-03-16 17:21:55', NULL, 1, 0, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '10', 'Salle C - Rayon 4', 'IHA_1966_1746');

-- --------------------------------------------------------

--
-- Structure de la table `category_books`
--

CREATE TABLE `category_books` (
  `category_uuid` varchar(255) NOT NULL,
  `category_code` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `added_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `category_books`
--

INSERT INTO `category_books` (`category_uuid`, `category_code`, `category_name`, `category_description`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`, `added_by`, `updated_by`) VALUES
('04413d30bba7b1a804ab0dfe6923de8d', 'JEU_ENF', 'Jeunesse', 'Livres destinés aux jeunes étudiants ou adolescents.', 1, NULL, '2026-03-12 11:28:15', NULL, 0, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL),
('5c5d94688b3390c7ea3e96543a954d62', 'LIT_FIC', 'Littérature et Fiction', 'Romans, théâtre et poésie pour études littéraires.', 1, NULL, '2026-03-12 11:28:16', NULL, 0, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL),
('bb422448d9d5047c59a04e329dc966a7', 'VIE_LOIS', 'Vie Pratique et Loisirs', 'Livres sur la cuisine, sports, loisirs et développement personnel.', 1, NULL, NULL, NULL, 0, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL),
('f69a1eb6578c72270b7c63aecaf73510', 'SAV_ETUD', 'Savoirs et Études', 'Livres universitaires et manuels académiques (non-fiction).', 1, NULL, NULL, NULL, 0, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE `customers` (
  `customer_uuid` varchar(255) NOT NULL,
  `customer_full_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone_number` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emprunter`
--

CREATE TABLE `emprunter` (
  `emprunt_uuid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '''pending''',
  `date_emprunt` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `book_uuid` varchar(255) NOT NULL,
  `customer_uuid` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `validated_by` varchar(255) DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL,
  `rejected_by` varchar(255) DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `rejected_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `frogot_password`
--

CREATE TABLE `frogot_password` (
  `forgot_password_uuid` varchar(255) NOT NULL,
  `user_uuid` varchar(255) NOT NULL,
  `forgot_password_opt` int(11) DEFAULT NULL,
  `forgot_password_expired_at` timestamp NULL DEFAULT NULL,
  `forgot_password_is_used` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genre_books`
--

CREATE TABLE `genre_books` (
  `genre_uuid` varchar(255) NOT NULL,
  `genre_name` varchar(255) DEFAULT NULL,
  `genre_code` varchar(255) NOT NULL,
  `genre_description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `category_book_uuid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `genre_books`
--

INSERT INTO `genre_books` (`genre_uuid`, `genre_name`, `genre_code`, `genre_description`, `is_active`, `is_deleted`, `created_at`, `updated_at`, `deleted_at`, `added_by`, `updated_by`, `category_book_uuid`) VALUES
('g1a2c3d4-e5f6-11ed-afa1-0242ac120002', 'Informatique', 'INF', 'Livres sur l’informatique, programmation et systèmes.', 1, 0, '2026-03-12 11:27:16', NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'f69a1eb6578c72270b7c63aecaf73510'),
('g1a2c3d5-e5f6-11ed-afa1-0242ac120002', 'Mathématiques', 'MAT', 'Manuels de mathématiques et statistiques.', 1, 0, '2026-03-12 11:27:16', NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'f69a1eb6578c72270b7c63aecaf73510'),
('g1a2c3d6-e5f6-11ed-afa1-0242ac120002', 'Physique', 'PHY', 'Livres et guides sur la physique générale et appliquée.', 1, 0, '2026-03-12 11:27:16', NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'f69a1eb6578c72270b7c63aecaf73510'),
('g1a2c3d7-e5f6-11ed-afa1-0242ac120002', 'Chimie', 'CHM', 'Manuels de chimie, organique et analytique.', 1, 0, '2026-03-12 11:27:16', NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'f69a1eb6578c72270b7c63aecaf73510'),
('g1a2c3d8-e5f6-11ed-afa1-0242ac120002', 'Histoire', 'HIS', 'Livres sur l’histoire universelle et régionale.', 1, 0, '2026-03-12 11:27:16', NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'SAV_ETUD'),
('g1a2c3d9-e5f6-11ed-afa1-0242ac120002', 'Littérature', 'LIT', 'Romans, poésies et études littéraires.', 1, 0, '2026-03-12 11:27:16', NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'LIT_FIC'),
('g1a2c3da-e5f6-11ed-afa1-0242ac120002', 'Loisirs créatifs', 'LOI', 'Guides et manuels sur les loisirs et activités créatives.', 1, 0, '2026-03-12 11:27:16', NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'VIE_LOIS'),
('g1a2c3db-e5f6-11ed-afa1-0242ac120002', 'Développement personnel', 'DEV', 'Livres sur la motivation, la productivité et la gestion du temps.', 1, 0, '2026-03-12 11:27:16', NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'VIE_LOIS');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_uuid` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_phone_number` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_role` varchar(255) DEFAULT NULL,
  `user_status` varchar(255) DEFAULT NULL,
  `counter_connection` int(11) DEFAULT NULL,
  `is_new_user` tinyint(1) DEFAULT NULL,
  `first_connection_date` timestamp NULL DEFAULT NULL,
  `last_connection_date` timestamp NULL DEFAULT NULL,
  `user_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0,
  `remember_token` varchar(255) DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_uuid`, `username`, `user_email`, `user_phone_number`, `user_password`, `user_role`, `user_status`, `counter_connection`, `is_new_user`, `first_connection_date`, `last_connection_date`, `user_picture`, `created_at`, `deleted_at`, `updated_at`, `is_deleted`, `remember_token`, `added_by`, `updated_by`, `address`) VALUES
('90e37608463363a67c2e676642e93aba', 'User System', 'user_system@gmail.com', '678536884', '$2y$10$bac1g7XzTHpuao3KC9nB4.G2FEu5qSAqc25gBusmSzWb0xbytyAva', 'system', 'active', 1, NULL, '2026-03-09 09:38:23', '2026-03-09 09:38:23', '../uploads/69ae923e9e8c8-GTLABO-logo-1750339740.png', '2026-03-09 09:07:13', NULL, '2026-03-09 09:38:23', 0, '31f7521a8fc7db73f601aba34a398244352a95ae6675aebf06318fef30872dc0', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', 'Limbé'),
('98b4df4a-17ea-11f1-b627-2c5f5795e6c2', 'User Admin', 'admin@gmail.com', '237600000000', '$2y$10$s.DIfIFXIWesGeN6WkbKdeKNgmeIjcVQ1k3Ap/kquZJa5Il6JDUI6', 'admin', 'active', 15, 0, '2026-03-04 17:41:28', '2026-03-16 17:16:47', NULL, '2026-03-04 16:52:57', NULL, '2026-03-16 17:16:47', 0, 'a4fc6c4190d038d5e4a84195112ec331463b6bd7dab3f381a5c2b25dfb597311', NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', 'Bafoussam'),
('a63b98aa619fcf6f3ab11afe7eeb72dd', 'User Manager', 'user_manager@gmail.com', '654349087', '$2y$10$Fu7yG522k3FZO0y2d9GD..XC7ljQt2PoI5qPjrCtX7mtwrVtqUUmO', 'system', 'active', 3, 0, '2026-03-09 09:52:28', '2026-03-09 10:01:25', '../uploads/69ae962de1a46-WORFLOW 002.jpg', '2026-03-09 09:43:09', NULL, '2026-03-09 10:01:25', 0, 'ec08c558b377127f77f0e3d959eef3a614a673ffaba5e36533d16016dbbd7d4b', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', NULL, 'Garoua');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_uuid`),
  ADD UNIQUE KEY `AUTHOR_EMAIL` (`author_email`,`author_phone_number`,`author_second_phone_number`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_uuid`),
  ADD KEY `FK_BOOKS_APPARTENI_CATEGORY` (`category_uuid`),
  ADD KEY `FK_BOOKS_AVOIR_GENRE_BO` (`genre_uuid`),
  ADD KEY `FK_BOOKS_POSSEDER_AUTHORS` (`author_uuid`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Index pour la table `category_books`
--
ALTER TABLE `category_books`
  ADD PRIMARY KEY (`category_uuid`),
  ADD UNIQUE KEY `CATEGORY_NAME` (`category_name`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_uuid`),
  ADD UNIQUE KEY `CUSTOMER_EMAIL` (`customer_email`,`customer_phone_number`);

--
-- Index pour la table `emprunter`
--
ALTER TABLE `emprunter`
  ADD PRIMARY KEY (`book_uuid`,`customer_uuid`),
  ADD KEY `FK_EMPRUNTE_EMPRUNTER_CUSTOMER` (`customer_uuid`),
  ADD KEY `validated_by` (`validated_by`),
  ADD KEY `rejected_by` (`rejected_by`);

--
-- Index pour la table `frogot_password`
--
ALTER TABLE `frogot_password`
  ADD PRIMARY KEY (`forgot_password_uuid`),
  ADD KEY `FK_FROGOT_P_DEMANDE_D_USERS` (`user_uuid`);

--
-- Index pour la table `genre_books`
--
ALTER TABLE `genre_books`
  ADD PRIMARY KEY (`genre_uuid`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `category_book_uuid` (`category_book_uuid`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_uuid`),
  ADD KEY `added_by` (`added_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `authors_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_uuid`),
  ADD CONSTRAINT `authors_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_uuid`);

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `FK_BOOKS_APPARTENI_CATEGORY` FOREIGN KEY (`category_uuid`) REFERENCES `category_books` (`category_uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_BOOKS_AVOIR_GENRE_BO` FOREIGN KEY (`genre_uuid`) REFERENCES `genre_books` (`genre_uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_BOOKS_POSSEDER_AUTHORS` FOREIGN KEY (`author_uuid`) REFERENCES `authors` (`author_uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_uuid`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_uuid`);

--
-- Contraintes pour la table `category_books`
--
ALTER TABLE `category_books`
  ADD CONSTRAINT `category_books_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_uuid`),
  ADD CONSTRAINT `category_books_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_uuid`);

--
-- Contraintes pour la table `emprunter`
--
ALTER TABLE `emprunter`
  ADD CONSTRAINT `FK_EMPRUNTE_EMPRUNTER_BOOKS` FOREIGN KEY (`book_uuid`) REFERENCES `books` (`book_uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_EMPRUNTE_EMPRUNTER_CUSTOMER` FOREIGN KEY (`customer_uuid`) REFERENCES `customers` (`customer_uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `emprunter_ibfk_1` FOREIGN KEY (`validated_by`) REFERENCES `users` (`user_uuid`),
  ADD CONSTRAINT `emprunter_ibfk_2` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`user_uuid`);

--
-- Contraintes pour la table `frogot_password`
--
ALTER TABLE `frogot_password`
  ADD CONSTRAINT `FK_FROGOT_P_DEMANDE_D_USERS` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`user_uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `genre_books`
--
ALTER TABLE `genre_books`
  ADD CONSTRAINT `genre_books_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_uuid`),
  ADD CONSTRAINT `genre_books_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_uuid`),
  ADD CONSTRAINT `genre_books_ibfk_3` FOREIGN KEY (`category_book_uuid`) REFERENCES `category_books` (`category_uuid`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_uuid`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_uuid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
