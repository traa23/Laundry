-- Struktur tabel untuk users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','owner') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal untuk users (password: admin123 dan owner123)
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('owner', '$2y$10$WN9H2rNe4mE.yC0J5qkCxODpUPlAF8kMnqGNaxVXjqfWRVYn49mPi', 'owner');
