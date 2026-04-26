-- Activity Logs Table and Stored Procedure Migration
-- Run this script to enable activity logging

-- Create activity_logs table
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `reference_table` varchar(50) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'success',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  KEY `action` (`action`),
  KEY `module` (`module`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create stored procedure for logging activities
DELIMITER $$

CREATE PROCEDURE IF NOT EXISTS `log_activity`(
    IN p_user_id INT,
    IN p_role VARCHAR(50),
    IN p_action VARCHAR(50),
    IN p_module VARCHAR(50),
    IN p_reference_id INT,
    IN p_reference_table VARCHAR(50),
    IN p_description LONGTEXT,
    IN p_ip_address VARCHAR(45),
    IN p_status VARCHAR(20)
)
BEGIN
    INSERT INTO activity_logs (
        user_id,
        role,
        action,
        module,
        reference_id,
        reference_table,
        description,
        ip_address,
        status
    ) VALUES (
        p_user_id,
        p_role,
        p_action,
        p_module,
        p_reference_id,
        p_reference_table,
        p_description,
        p_ip_address,
        p_status
    );
END$$

DELIMITER ;
