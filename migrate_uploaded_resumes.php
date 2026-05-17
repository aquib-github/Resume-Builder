<?php
require_once __DIR__ . '/app/bootstrap.php';

$sql = "CREATE TABLE IF NOT EXISTS `uploaded_resumes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `resume_title` varchar(250) NOT NULL,
  `file_path` varchar(250) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `updated_at` int(20) NOT NULL,
  `background` varchar(250) NOT NULL DEFAULT 'tile1.png',
  `font` varchar(250) NOT NULL DEFAULT '\'Assistant\', sans-serif',
  PRIMARY KEY (`id`),
  KEY `fk_uploaded_resumes_user` (`user_id`),
  CONSTRAINT `fk_uploaded_resumes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

if ($db->query($sql)) {
    echo "Table uploaded_resumes created successfully.\n";
} else {
    echo "Error creating table: " . $db->error . "\n";
}
