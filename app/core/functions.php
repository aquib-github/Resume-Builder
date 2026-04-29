<?php
// Helper Functions — auth, session, redirects, flash messages, and XSS escaping

class Functions
{
    public function redirect($address)
    {
        header("Location:" . $address);
        exit();
    }

    // Store error message in session (displayed as SweetAlert popup)
    public function setError($msg)
    {
        $_SESSION['error'] = $msg;
    }

    public function error()
    {
        if (isset($_SESSION['error'])) {
            $msg = htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
            echo "Swal.fire('','" . $msg . "','error')";
            unset($_SESSION['error']);
        }
    }

    // Store success message in session (displayed as SweetAlert popup)
    public function setAlert($msg)
    {
        $_SESSION['alert'] = $msg;
    }

    public function alert()
    {
        if (isset($_SESSION['alert'])) {
            $msg = htmlspecialchars($_SESSION['alert'], ENT_QUOTES, 'UTF-8');
            echo "Swal.fire('','" . $msg . "','success')";
            unset($_SESSION['alert']);
        }
    }

    public function setAuth($data)
    {
        $_SESSION['Auth'] = $data;
    }

    // Returns user data array if logged in, false otherwise
    public function Auth()
    {
        if (isset($_SESSION['Auth'])) {
            return $_SESSION['Auth'];
        } else {
            return false;
        }
    }

    // Guard: redirects to login if not authenticated
    public function authPage()
    {
        if (!isset($_SESSION['Auth'])) {
            $this->redirect(BASE_URL . 'public/pages/public/login.php');
        }
    }

    // Guard: redirects to dashboard if already authenticated
    public function nonAuthPage()
    {
        if (isset($_SESSION['Auth'])) {
            $this->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
        }
    }

    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession($key)
    {
        return $_SESSION[$key] ?? '';
    }

    // Generate a random 16-char hex string for unique slugs
    public function randomString()
    {
        return bin2hex(random_bytes(8));
    }

    // Escape output to prevent XSS
    public function esc($value)
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

$fn = new Functions();
