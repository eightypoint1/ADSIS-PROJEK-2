-- Grant full privileges after Docker entrypoint creates user
-- Runs on first database initialization only
GRANT ALL PRIVILEGES ON nusantara_db.* TO 'nusantara_user'@'%';
FLUSH PRIVILEGES;
