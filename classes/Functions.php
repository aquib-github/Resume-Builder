<?php
session_start();

class Functions
{
    public function redirect($address)
    {
        header("Location:" . $address);
        exit();
    }

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

    public function Auth()
    {
        if (isset($_SESSION['Auth'])) {
            return $_SESSION['Auth'];
        } else {
            return false;
        }
    }

    public function authPage()
    {
        if (!isset($_SESSION['Auth'])) {
            $this->redirect('login.php');
        }
    }

    public function nonAuthPage()
    {
        if (isset($_SESSION['Auth'])) {
            $this->redirect('myresumes.php');
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

    public function randomString()
    {
        return bin2hex(random_bytes(8));
    }

    /**
     * Escape output for safe HTML rendering.
     */
    public function esc($value)
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

$fn = new Functions();
