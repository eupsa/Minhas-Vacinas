<?php

/**
 * Simple notification helper for universal use
 */
class NotificationHelper
{

    /**
     * Set success message
     */
    public static function success($message, $redirect = null)
    {
        if (self::isAjax()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $message,
                'redirect' => $redirect
            ]);
            exit;
        } else {
            if ($redirect) {
                header("Location: $redirect?success=" . urlencode($message));
            } else {
                self::setSessionMessage($message, 'success');
            }
        }
    }

    /**
     * Set error message
     */
    public static function error($message, $redirect = null)
    {
        if (self::isAjax()) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $message
            ]);
            exit;
        } else {
            if ($redirect) {
                header("Location: $redirect?error=" . urlencode($message));
            } else {
                self::setSessionMessage($message, 'error');
            }
        }
    }

    /**
     * Set warning message
     */
    public static function warning($message, $redirect = null)
    {
        if (self::isAjax()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $message,
                'type' => 'warning'
            ]);
            exit;
        } else {
            if ($redirect) {
                header("Location: $redirect?warning=" . urlencode($message));
            } else {
                self::setSessionMessage($message, 'warning');
            }
        }
    }

    /**
     * Set info message
     */
    public static function info($message, $redirect = null)
    {
        if (self::isAjax()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $message,
                'type' => 'info'
            ]);
            exit;
        } else {
            if ($redirect) {
                header("Location: $redirect?info=" . urlencode($message));
            } else {
                self::setSessionMessage($message, 'info');
            }
        }
    }

    /**
     * Display session messages
     */
    public static function display()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['notification_message'])) {
            $message = $_SESSION['notification_message'];
            $type = $_SESSION['notification_type'] ?? 'info';

            echo "<div data-message=\"$message\" data-type=\"$type\" style=\"display:none;\"></div>";

            unset($_SESSION['notification_message']);
            unset($_SESSION['notification_type']);
        }
    }

    /**
     * Set session message
     */
    private static function setSessionMessage($message, $type)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['notification_message'] = $message;
        $_SESSION['notification_type'] = $type;
    }

    /**
     * Check if request is AJAX
     */
    private static function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}
