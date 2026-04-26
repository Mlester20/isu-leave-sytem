-- Fix: Allow NULL user_id in activites_log for failed login tracking

ALTER TABLE activites_log MODIFY user_id INT(11) NULL;

-- Optional: Add an index for faster queries
ALTER TABLE activites_log ADD INDEX idx_status (status);
ALTER TABLE activites_log ADD INDEX idx_created_at (created_at);
