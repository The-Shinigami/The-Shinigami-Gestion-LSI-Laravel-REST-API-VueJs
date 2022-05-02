-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 27 juin 2021 à 22:36
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `auth_laravel`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `prenom`, `login`, `password`) VALUES
(1, 'the', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `annees`
--

CREATE TABLE `annees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `annee` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `annees`
--

INSERT INTO `annees` (`id`, `annee`) VALUES
(1, '2020/2021');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cne` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_de_naissance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semestre_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `cne`, `date_de_naissance`, `semestre_id`, `created_at`, `updated_at`) VALUES
(1, 'nom_1', 'prenom_1', 'cne_1', 'date_1', 1, '2021-05-19 13:49:42', '2021-06-24 07:24:25'),
(2, 'nom_2', 'prenom_2', 'cne_2', 'date_2', 2, '2021-05-19 13:56:10', '2021-06-17 19:45:04'),
(3, 'nom_3', 'prenom_3', 'cne_3', 'date_3', 2, '2021-06-05 22:23:24', '2021-06-23 07:20:55'),
(4, 'nom_4', 'prenom_4', 'cne_4', 'date_4', 6, '2021-06-16 16:10:39', '2021-06-16 22:32:47'),
(5, 'nom_5', 'prenom_5', 'cne_5', 'date_5', 6, '2021-06-23 07:15:41', '2021-06-23 07:15:41'),
(6, 'nom_6', 'prenom_6', 'cne_6', 'date_6', 2, '2021-06-24 19:08:28', '2021-06-24 19:08:28');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_05_11_193823_create_salles_table', 1),
(2, '2021_05_11_204653_create_semestres_table', 2),
(3, '2021_05_18_153847_create_etudiants_table', 3),
(4, '2021_05_18_153902_create_seances_table', 4),
(7, '2021_05_19_131349_create_profs_table', 6),
(8, '2021_05_18_154100_create_modules_table', 7),
(9, '2014_10_12_000000_create_users_table', 8),
(10, '2014_10_12_100000_create_password_resets_table', 8),
(11, '2014_10_12_200000_add_two_factor_columns_to_users_table', 8),
(12, '2019_08_19_000000_create_failed_jobs_table', 8),
(13, '2019_12_14_000001_create_personal_access_tokens_table', 8),
(14, '2021_05_21_230106_create_sessions_table', 8);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semestre_id` bigint(20) UNSIGNED NOT NULL,
  `seance_id` bigint(20) UNSIGNED NOT NULL,
  `prof_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `module`, `semestre_id`, `seance_id`, `prof_id`, `created_at`, `updated_at`) VALUES
(1, 'Architecture des ordinateurs', 1, 1, 1, '2021-05-20 14:05:56', '2021-06-26 18:30:25'),
(2, 'systèmes d\'exploitation', 1, 1, 2, '2021-05-20 14:08:08', '2021-05-20 14:08:08'),
(3, 'Architecture réseaux & protocoles', 1, 9, 3, '2021-05-20 14:31:49', '2021-06-27 08:57:20'),
(4, 'Systèmes d’informations & bases de données', 1, 6, 4, '2021-05-20 14:32:48', '2021-05-20 14:32:48'),
(5, 'Programmation Orientée Objets en C++', 1, 7, 5, '2021-05-20 14:33:09', '2021-05-20 14:33:09'),
(6, 'Mathématiques pour l’ingénieur', 1, 8, 6, '2021-05-20 14:33:36', '2021-05-20 14:33:36'),
(7, 'Techniques d’expression et de communication', 1, 10, 7, '2021-05-20 14:34:07', '2021-05-20 14:34:07'),
(8, 'Programmation Orientée Objets en Java', 2, 14, 8, '2021-05-20 16:12:50', '2021-05-20 16:12:50'),
(9, 'Programmation\r\nMobile', 2, 14, 4, '2021-05-20 16:13:33', '2021-05-20 16:13:33'),
(10, 'Développement web', 2, 15, 9, '2021-05-20 16:25:32', '2021-05-20 16:25:32'),
(11, 'Frameworks', 2, 15, 4, '2021-05-20 16:26:35', '2021-05-20 16:26:35'),
(12, 'Théorie des graphes & Applications', 2, 16, 2, '2021-05-20 16:34:45', '2021-05-20 16:34:45'),
(13, 'Conception Orienté Objet', 2, 19, 10, '2021-05-20 16:39:14', '2021-05-20 16:39:14'),
(14, 'Statistique descriptive et inférentielle ', 2, 18, 11, '2021-05-20 16:40:12', '2021-05-20 16:40:12'),
(15, 'Management & comptabilité ', 2, 21, 12, '2021-05-20 16:40:44', '2021-05-20 16:40:44');

-- --------------------------------------------------------

--
-- Structure de la table `niveaus`
--

CREATE TABLE `niveaus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `niveau` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `niveaus`
--

INSERT INTO `niveaus` (`id`, `niveau`) VALUES
(1, 'LSI 1er annee');

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `note` int(11) NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `note`, `module_id`, `updated_at`, `created_at`) VALUES
(1, 15, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(2, 12, 3, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(3, 10, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(4, 18, 1, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(5, 18, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(6, 17, 2, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(7, 17, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(8, 16, 11, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(9, 19, 1, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(10, 13, 1, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(11, 17, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(12, 19, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(13, 20, 1, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(14, 15, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(15, 13, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(16, 12, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(17, 14, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(18, 12, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(19, 11, 11, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(20, 10, 1, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(21, 17, 1, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(22, 15, 1, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(23, 20, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(24, 11, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(25, 1, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(26, 2, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(27, 3, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(28, 4, 11, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(29, 10, 2, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(30, 12, 2, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(31, 15, 12, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(32, 7, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(33, 11, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(34, 16, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(35, 16, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(36, 17, 11, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(37, 15, 11, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(38, 5, 11, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(39, 3, 4, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(40, 1, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(41, 13, 11, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(42, 10, 9, '2021-06-12 11:20:07', '2021-06-12 12:20:35'),
(47, 5, 4, '2021-06-12 12:09:28', '2021-06-12 13:09:28'),
(48, 5, 9, '2021-06-12 12:09:36', '2021-06-12 13:09:36');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pfes`
--

CREATE TABLE `pfes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sujet` varchar(100) NOT NULL,
  `date` varchar(20) NOT NULL,
  `salle_id` bigint(20) UNSIGNED NOT NULL,
  `etudiant_id` bigint(20) UNSIGNED NOT NULL,
  `prof_id` bigint(11) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `pfes`
--

INSERT INTO `pfes` (`id`, `sujet`, `date`, `salle_id`, `etudiant_id`, `prof_id`, `updated_at`, `created_at`) VALUES
(1, 'walo', '2010-06-09 10:00:00', 1, 4, 4, '2021-06-26 07:27:16', '2021-06-22 13:58:59');

-- --------------------------------------------------------

--
-- Structure de la table `profs`
--

CREATE TABLE `profs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profs`
--

INSERT INTO `profs` (`id`, `nom`, `prenom`, `login`, `password`, `created_at`, `updated_at`) VALUES
(1, 'ELBRAK', '', 'elbarak', 'elbarak', '2021-05-20 13:34:50', '2021-05-20 13:34:50'),
(2, 'GHADI', '', 'ghadi', 'ghadi', '2021-05-20 13:45:00', '2021-05-20 13:45:00'),
(3, 'BEN AHMED\r\n', '', '', '', '2021-05-20 14:29:21', '2021-05-20 14:29:21'),
(4, 'ZILI', 'hassan', 'zili', 'zili', '2021-05-20 14:29:36', '2021-05-20 14:29:36'),
(5, 'EN-ENAIMI', '', '', '', '2021-05-20 14:29:51', '2021-05-20 14:29:51'),
(6, 'EL JARROUDI\r\n', '', '', '', '2021-05-20 14:30:04', '2021-05-20 14:30:04'),
(7, 'Dept TEC', '', '', '', '2021-05-20 14:30:17', '2021-05-20 14:30:17'),
(8, 'FENNAN', '', '', '', '2021-05-20 15:53:13', '2021-05-20 15:53:13'),
(9, 'ELAACHAK', '', '', '', '2021-05-20 15:54:04', '2021-05-20 15:54:04'),
(10, 'EL AMRANI', '', '', '', '2021-05-20 15:54:32', '2021-05-20 15:54:32'),
(11, 'Dept MATHS\r\n', '', '', '', '2021-05-20 15:54:48', '2021-05-20 15:54:48'),
(12, 'Dept TEC\r\n', '', '', '', '2021-05-20 15:54:59', '2021-05-20 15:54:59');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `seance_id` bigint(22) UNSIGNED NOT NULL,
  `module_id` bigint(22) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime NOT NULL,
  `decision` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `seance_id`, `module_id`, `updated_at`, `created_at`, `deleted_at`, `decision`) VALUES
(1, 1, 4, '2021-06-11 18:34:19', '2021-06-10 20:44:40', '2021-06-14 12:00:00', 'refuser'),
(2, 2, 4, '2021-06-14 14:47:11', '2021-06-10 20:55:35', '2021-06-14 12:00:00', ''),
(3, 3, 4, '2021-06-14 13:47:42', '2021-06-10 21:15:08', '2021-06-15 12:00:00', 'accepter'),
(4, 1, 4, '2021-06-10 20:15:37', '2021-06-10 21:15:37', '2021-06-14 12:00:00', ''),
(5, 3, 4, '2021-06-10 20:16:45', '2021-06-10 21:16:45', '2021-06-15 12:00:00', ''),
(6, 3, 4, '2021-06-10 20:19:58', '2021-06-10 21:19:58', '2021-06-15 12:00:00', ''),
(7, 9, 4, '2021-06-24 07:16:25', '2021-06-10 21:50:38', '2021-06-18 12:00:00', '');

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`id`, `numero`, `created_at`, `updated_at`) VALUES
(1, 'E21', '2021-05-19 13:49:18', '2021-05-19 13:49:18'),
(2, 'E22', '2021-05-20 15:57:23', '2021-05-20 15:57:23');

-- --------------------------------------------------------

--
-- Structure de la table `seances`
--

CREATE TABLE `seances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salle_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `seances`
--

INSERT INTO `seances` (`id`, `jour`, `heure`, `salle_id`, `created_at`, `updated_at`) VALUES
(1, 'lundi', '9:00h -> 12:45h', 1, '2021-05-19 13:51:08', '2021-05-19 13:51:08'),
(2, 'lundi', '15:00h -> 18:45h', 1, '2021-05-19 13:52:09', '2021-05-19 13:52:09'),
(3, 'mardi', '9:00h -> 12:45h', 1, '2021-05-20 13:15:29', '2021-05-20 13:15:29'),
(4, 'mardi', '15:00h -> 18:45h', 1, '2021-05-20 13:16:07', '2021-05-20 13:16:07'),
(6, 'mercredi', '9:00h -> 12:45h', 1, '2021-05-20 13:16:56', '2021-05-20 13:16:56'),
(7, 'mercredi', '15:00h -> 18:45h', 1, '2021-05-20 13:19:29', '2021-05-20 13:19:29'),
(8, 'jeudi', '9:00h -> 12:45h', 1, '2021-05-20 13:26:16', '2021-05-20 13:26:16'),
(9, 'jeudi', '15:00h -> 18:45h', 1, '2021-05-20 13:26:52', '2021-05-20 13:26:52'),
(10, 'vendredi', '9:00h -> 12:45h', 1, '2021-05-20 13:27:56', '2021-05-20 13:27:56'),
(11, 'vendredi', '15:00h -> 18:45h', 1, '2021-05-20 13:28:35', '2021-05-20 13:28:35'),
(12, 'samedi', '9:00h -> 12:45h', 1, '2021-05-20 13:28:58', '2021-05-20 13:28:58'),
(13, 'samedi', '15:00h -> 18:45h', 1, '2021-05-20 13:29:32', '2021-05-20 13:29:32'),
(14, 'lundi', '9:00h -> 12:45h', 2, '2021-06-25 20:06:01', '2021-06-25 20:06:01'),
(15, 'lundi', '15:00h -> 18:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(16, 'mardi', '9:00h -> 12:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(17, 'mardi', '15:00h -> 18:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(18, 'mercredi', '9:00h -> 12:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(19, 'mercredi', '15:00h -> 18:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(20, 'jeudi', '9:00h -> 12:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(21, 'jeudi', '15:00h -> 18:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(22, 'vendredi', '9:00h -> 12:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(23, 'vendredi', '15:00h -> 18:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(24, 'samedi', '9:00h -> 12:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41'),
(25, 'samedi', '15:00h -> 18:45h', 2, '2021-06-25 20:06:41', '2021-06-25 20:06:41');

-- --------------------------------------------------------

--
-- Structure de la table `semestres`
--

CREATE TABLE `semestres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semestre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `semestres`
--

INSERT INTO `semestres` (`id`, `semestre`, `created_at`, `updated_at`) VALUES
(1, 'S1', '2021-05-19 13:48:48', '2021-05-19 13:48:48'),
(2, 'S2', '2021-05-19 13:55:22', '2021-05-19 13:55:22'),
(3, 'S3', '2021-06-22 17:01:17', '2021-06-08 17:01:03'),
(4, 'S4', '2021-06-22 17:01:52', '2021-06-22 17:01:52'),
(5, 'S5', '2021-06-22 17:02:17', '2021-06-22 17:02:17'),
(6, 'S6', '2021-06-22 17:02:40', '2021-06-22 17:02:40');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('IAd0whXrLmEMNfmbK1Xf8wxHufTXVM5fH5JjLHhB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDVPMXllWjltZTZ2RmFPN2pJNUVNQjk5VjhIZGhabURra2pqSGtiVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9mIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1622467906),
('Lp3opGR5pKABnCFyyxQRgXdUFwtIBH0ZxhKV0uaL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiODZPMjVoZXRTR29pZnBTcnNtTkhSM2taY0FsOGhtb05mZlhLMlJqcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1622442154),
('YjkzC4aSDIgl1NV3BNDqtGpW72rx6WDA9IYsbJTT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2cwWDF4a1NZaU1wRVJzNXJKdE1IMlo1d3FDbzVUcEhsT0w0ckJ0byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsb2lzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1621808390);

-- --------------------------------------------------------

--
-- Structure de la table `suivres`
--

CREATE TABLE `suivres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `etudiant_id` bigint(20) UNSIGNED NOT NULL,
  `note_id` bigint(20) UNSIGNED NOT NULL,
  `niveau_id` bigint(20) UNSIGNED NOT NULL,
  `annee_id` bigint(20) UNSIGNED NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `suivres`
--

INSERT INTO `suivres` (`id`, `etudiant_id`, `note_id`, `niveau_id`, `annee_id`, `updated_at`, `created_at`) VALUES
(2, 2, 1, 1, 1, '2021-06-06 22:49:34', '2021-06-06 22:46:23'),
(3, 3, 2, 1, 1, '2021-06-06 22:49:47', '2021-06-06 22:46:23'),
(4, 3, 39, 1, 1, '2021-06-09 08:18:51', '2021-06-06 21:46:43'),
(5, 2, 42, 1, 1, '2021-06-12 12:09:50', '2021-06-07 11:53:38'),
(6, 2, 37, 1, 1, '2021-06-18 20:40:44', '2021-06-07 16:08:42'),
(8, 3, 22, 1, 1, '2021-06-07 19:47:41', '2021-06-07 16:09:37'),
(17, 1, 4, 1, 1, '2021-06-12 11:57:34', '2021-06-07 19:46:54'),
(18, 1, 29, 1, 1, '2021-06-07 19:56:07', '2021-06-07 19:56:07'),
(19, 3, 30, 1, 1, '2021-06-07 19:56:17', '2021-06-07 19:56:17'),
(20, 2, 31, 1, 1, '2021-06-07 19:56:17', '2021-06-07 19:56:17'),
(21, 3, 37, 1, 1, '2021-06-09 15:59:30', '2021-06-09 15:51:08'),
(22, 3, 14, 1, 1, '2021-06-12 12:09:54', '2021-06-09 15:59:29'),
(25, 1, 3, 1, 1, '2021-06-19 16:04:49', '2021-06-12 11:58:58'),
(26, 4, 1, 1, 1, '2021-06-18 15:22:20', '2021-06-18 15:22:20');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `annees`
--
ALTER TABLE `annees`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiants_semestre_id_foreign` (`semestre_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modules_semestre_id_foreign` (`semestre_id`),
  ADD KEY `modules_seance_id_foreign` (`seance_id`),
  ADD KEY `modules_prof_id_foreign` (`prof_id`);

--
-- Index pour la table `niveaus`
--
ALTER TABLE `niveaus`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `pfes`
--
ALTER TABLE `pfes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prof_id` (`prof_id`),
  ADD KEY `etudiant_id` (`etudiant_id`),
  ADD KEY `salle_id` (`salle_id`);

--
-- Index pour la table `profs`
--
ALTER TABLE `profs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `seance_id` (`seance_id`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `seances`
--
ALTER TABLE `seances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seances_salle_id_foreign` (`salle_id`);

--
-- Index pour la table `semestres`
--
ALTER TABLE `semestres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `suivres`
--
ALTER TABLE `suivres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiant_id` (`etudiant_id`),
  ADD KEY `note_id` (`note_id`),
  ADD KEY `niveau_id` (`niveau_id`),
  ADD KEY `annee_id` (`annee_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `annees`
--
ALTER TABLE `annees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `niveaus`
--
ALTER TABLE `niveaus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pfes`
--
ALTER TABLE `pfes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `profs`
--
ALTER TABLE `profs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `seances`
--
ALTER TABLE `seances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `semestres`
--
ALTER TABLE `semestres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `suivres`
--
ALTER TABLE `suivres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_semestre_id_foreign` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`);

--
-- Contraintes pour la table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_prof_id_foreign` FOREIGN KEY (`prof_id`) REFERENCES `profs` (`id`),
  ADD CONSTRAINT `modules_seance_id_foreign` FOREIGN KEY (`seance_id`) REFERENCES `seances` (`id`),
  ADD CONSTRAINT `modules_semestre_id_foreign` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`);

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);

--
-- Contraintes pour la table `pfes`
--
ALTER TABLE `pfes`
  ADD CONSTRAINT `pfes_ibfk_1` FOREIGN KEY (`prof_id`) REFERENCES `profs` (`id`),
  ADD CONSTRAINT `pfes_ibfk_2` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`),
  ADD CONSTRAINT `pfes_ibfk_3` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`seance_id`) REFERENCES `seances` (`id`);

--
-- Contraintes pour la table `seances`
--
ALTER TABLE `seances`
  ADD CONSTRAINT `seances_salle_id_foreign` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`);

--
-- Contraintes pour la table `suivres`
--
ALTER TABLE `suivres`
  ADD CONSTRAINT `suivres_ibfk_1` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiants` (`id`),
  ADD CONSTRAINT `suivres_ibfk_2` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`),
  ADD CONSTRAINT `suivres_ibfk_3` FOREIGN KEY (`niveau_id`) REFERENCES `niveaus` (`id`),
  ADD CONSTRAINT `suivres_ibfk_4` FOREIGN KEY (`annee_id`) REFERENCES `annees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
