USE findit;
-- Generate a password hash with: php -r "echo password_hash('ChangeMe123!', PASSWORD_DEFAULT), PHP_EOL;"
-- Then insert the resulting hash into a controlled administrator account:
-- INSERT INTO users (full_name, email, password_hash, role)
-- VALUES ('FindIt Administrator', 'admin@example.com', '<generated-hash>', 'admin');
