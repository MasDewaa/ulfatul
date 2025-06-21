<?php
/**
 * Configuration file untuk JPL Monitoring System
 * Load environment variables dari file .env
 */

// Load environment variables
function loadEnv($file) {
    if (!file_exists($file)) {
        return false;
    }
    
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) {
            continue; // Skip comments
        }
        
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            if (preg_match('/^(["\'])(.*)\1$/', $value, $matches)) {
                $value = $matches[2];
            }
            
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
    return true;
}

// Load .env file
loadEnv(__DIR__ . '/../.env');

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: '172.28.0.2');
define('DB_PORT', getenv('DB_PORT') ?: '5432');
define('DB_NAME', getenv('DB_NAME') ?: 'monitoring-jpl');
define('DB_USER', getenv('DB_USER') ?: 'postgres');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'your_postgres_password');
define('DB_TYPE', getenv('DB_TYPE') ?: 'postgresql');

// Application Configuration
define('APP_NAME', getenv('APP_NAME') ?: 'JPL Monitoring System');
define('APP_ENV', getenv('APP_ENV') ?: 'production');
define('APP_DEBUG', getenv('APP_DEBUG') === 'true');
define('APP_URL', getenv('APP_URL') ?: 'http://localhost:3006');

// Web Server Configuration
define('WEB_PORT', getenv('WEB_PORT') ?: '3006');
define('WEB_HOST', getenv('WEB_HOST') ?: '0.0.0.0');

// Security Configuration
define('SESSION_SECRET', getenv('SESSION_SECRET') ?: 'default_session_secret');
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY') ?: 'default_encryption_key');

// Monitoring Configuration
define('MONITORING_INTERVAL', getenv('MONITORING_INTERVAL') ?: '30');
define('ALERT_EMAIL', getenv('ALERT_EMAIL') ?: 'admin@jpl.com');

// File Upload Configuration
define('UPLOAD_MAX_SIZE', getenv('UPLOAD_MAX_SIZE') ?: '10MB');
define('ALLOWED_FILE_TYPES', getenv('ALLOWED_FILE_TYPES') ?: 'jpg,jpeg,png,gif,pdf,doc,docx');

// Logging Configuration
define('LOG_LEVEL', getenv('LOG_LEVEL') ?: 'info');
define('LOG_FILE', getenv('LOG_FILE') ?: '/var/log/jpl-monitoring.log');

// Backup Configuration
define('BACKUP_ENABLED', getenv('BACKUP_ENABLED') === 'true');
define('BACKUP_RETENTION_DAYS', getenv('BACKUP_RETENTION_DAYS') ?: '7');

// Email Configuration
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_PORT', getenv('SMTP_PORT') ?: '587');
define('SMTP_USERNAME', getenv('SMTP_USERNAME') ?: '');
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD') ?: '');
define('SMTP_ENCRYPTION', getenv('SMTP_ENCRYPTION') ?: 'tls');

// External API Configuration
define('API_KEY', getenv('API_KEY') ?: '');
define('API_SECRET', getenv('API_SECRET') ?: '');

// Helper function to get configuration
function config($key, $default = null) {
    $config = [
        'db_host' => DB_HOST,
        'db_port' => DB_PORT,
        'db_name' => DB_NAME,
        'db_user' => DB_USER,
        'db_password' => DB_PASSWORD,
        'db_type' => DB_TYPE,
        'app_name' => APP_NAME,
        'app_env' => APP_ENV,
        'app_debug' => APP_DEBUG,
        'app_url' => APP_URL,
        'web_port' => WEB_PORT,
        'web_host' => WEB_HOST,
        'session_secret' => SESSION_SECRET,
        'encryption_key' => ENCRYPTION_KEY,
        'monitoring_interval' => MONITORING_INTERVAL,
        'alert_email' => ALERT_EMAIL,
        'upload_max_size' => UPLOAD_MAX_SIZE,
        'allowed_file_types' => ALLOWED_FILE_TYPES,
        'log_level' => LOG_LEVEL,
        'log_file' => LOG_FILE,
        'backup_enabled' => BACKUP_ENABLED,
        'backup_retention_days' => BACKUP_RETENTION_DAYS,
        'smtp_host' => SMTP_HOST,
        'smtp_port' => SMTP_PORT,
        'smtp_username' => SMTP_USERNAME,
        'smtp_password' => SMTP_PASSWORD,
        'smtp_encryption' => SMTP_ENCRYPTION,
        'api_key' => API_KEY,
        'api_secret' => API_SECRET,
    ];
    
    return $config[$key] ?? $default;
}
?> 