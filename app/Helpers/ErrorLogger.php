<?php

namespace App\Helpers;

use Exception;

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class ErrorLogger {
    private $logDir;
    private $logFile;

    public function __construct($logDir = __DIR__ . '/../../logs', $logFile = 'errors.log') {
        $this->logDir = $logDir;
        $this->logFile = $this->logDir . '/' . $logFile;

        $this->initializeLogFile();
    }

    private function initializeLogFile() {
        if (!file_exists($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }

        if (!file_exists($this->logFile)) {
            file_put_contents($this->logFile, '');
        }
    }

    public static function logException(Exception $e) {
        $message = sprintf(
            "[%s] %s in %s:%d\nStack trace:\n%s\n",
            date('Y-m-d H:i:s'),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getTraceAsString()
        );
        error_log($message . "\n", 3, (new self())->logFile);
    }
}
