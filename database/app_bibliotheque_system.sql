-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 07 mars 2026 à 16:04
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
('156b5b29942980aecb3345b226a09a14', 'Franc Carré', 'afg@assurance.com', '689654580', '', 'Italienne', '11699fbf0e898783_1772895573.png', 1, '2026-03-04 18:26:55', '2026-03-07 14:59:33', 0, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2'),
('5d64bb259256f7b30fbc899d6727f7ed', 'Laurent Alphonse', 'laurentalphonsewilfried@gmail.com', '697176700', '', 'Camerounaise', 'e51e54cb6f23ff8a_1772895518.png', 1, '2026-03-04 18:18:43', '2026-03-07 14:58:39', 0, NULL, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2'),
('78449bf4a838d36bce22d9521fc34c39', 'Kamsu kenfack Kamsu', 'kamsukessy1@gmail.com', '612908700', '', 'Camerounaise', 'bcec1842e5aff2e6_1772895590.png', 1, '2026-03-04 18:26:03', '2026-03-07 14:59:50', 0, NULL, '98b4df4a-17ea-11f1-b627-2c5f5795e6c2', '98b4df4a-17ea-11f1-b627-2c5f5795e6c2');

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
  `book_price` int(11) DEFAULT NULL,
  `book_publication_date` varchar(255) DEFAULT NULL,
  `book_isbn` varchar(255) DEFAULT NULL,
  `book_description` varchar(255) DEFAULT NULL,
  `book_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category_books`
--

CREATE TABLE `category_books` (
  `category_uuid` varchar(255) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `genre_description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_uuid`, `username`, `user_email`, `user_phone_number`, `user_password`, `user_role`, `user_status`, `counter_connection`, `is_new_user`, `first_connection_date`, `last_connection_date`, `user_picture`, `created_at`, `deleted_at`, `updated_at`, `is_deleted`, `remember_token`) VALUES
('98b4df4a-17ea-11f1-b627-2c5f5795e6c2', 'admin', 'admin@gmail.com', '237600000000', '$2y$10$s.DIfIFXIWesGeN6WkbKdeKNgmeIjcVQ1k3Ap/kquZJa5Il6JDUI6', 'admin', 'active', 7, 0, '2026-03-04 17:41:28', '2026-03-07 14:37:08', NULL, '2026-03-04 16:52:57', NULL, '2026-03-07 14:37:08', 0, '39b092ef95806ab1f7954833935b740f6f0355a2402fadae840eaddd45e5bd71');

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
  ADD KEY `FK_BOOKS_POSSEDER_AUTHORS` (`author_uuid`);

--
-- Index pour la table `category_books`
--
ALTER TABLE `category_books`
  ADD PRIMARY KEY (`category_uuid`),
  ADD UNIQUE KEY `CATEGORY_NAME` (`category_name`);

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
  ADD PRIMARY KEY (`genre_uuid`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_uuid`);

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
  ADD CONSTRAINT `FK_BOOKS_POSSEDER_AUTHORS` FOREIGN KEY (`author_uuid`) REFERENCES `authors` (`author_uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
