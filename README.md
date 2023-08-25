# booking_system
Booking System using Laravel and Livewire

1. Clone the system.
2. Install composer.phar (https://getcomposer.org/download/).
3. php composer.phar install (run this command)
4. npm install (run this command)
5. npm run dev (run this command)
6. php artisan key:generate (run this command)
7. http://localhost:8011/ (Run this in the browser.)
8. Import the database. (SQL query indicated below)

ACCESS LIST:
1. email: superadmin@access
   password: defaultpassword

2. email: user@access
   password: password

SQL Query
__________________________________________________________________________________________________________________________________________________________________________________________
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('Super Administrator', 'superadmin@access', NULL, '$2y$10$44Aa9OjrbEaYqO2vcMyXxeTtGQqhksvEf9n4o9YE7eIjenox5KWf.', NULL, '2023-08-24 22:59:08', '2023-08-24 22:59:08'),
('User Testing', 'user@access', NULL, '$2y$10$8aAbYdu5mIq.gZp3zxq0ru8hyKJknl53S3aqMBOlmJ/KDlTUIrvci', NULL, '2023-08-24 23:00:11', '2023-08-24 23:00:11');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

__________________________________________________________________________________________________________________________________________________________________________________________
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `reservation_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `reservation_status` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Pending', NULL, '2023-08-25 09:37:48'),
(2, 'Approved', NULL, '2023-08-25 09:37:48'),
(3, 'Denied', NULL, '2023-08-25 09:37:48'),
(4, 'Cancel', NULL, '2023-08-25 09:37:48');

ALTER TABLE `reservation_status`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reservation_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;
__________________________________________________________________________________________________________________________________________________________________________________________
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `room_information` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `room_information` (`id`, `name`, `description`, `status`, `created_at`) VALUES
(1, 'Luzon Room', '100 capacity', '1', '2023-08-25 08:50:46'),
(2, 'Visayas Room', '1,000 capacity', '1', '2023-08-25 08:50:48'),
(3, 'Mindanao Room', '10,000 capacity', '1', '2023-08-25 08:50:50');

ALTER TABLE `room_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
__________________________________________________________________________________________________________________________________________________________________________________________
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `reservation_information` (
  `id` int(11) NOT NULL,
  `reservationist` varchar(255) NOT NULL,
  `room_id` varchar(255) NOT NULL,
  `date_reservation` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `minutes_count` varchar(255) NOT NULL,
  `reservation_status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `reservation_information`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reservation_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
