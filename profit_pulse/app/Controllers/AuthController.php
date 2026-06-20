<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private User $users;

    public function __construct()
    {
        $this->users = new User();
    }

    public function loginForm(): void
    {
        Auth::guest();
        $this->view('auth/login', [], 'auth');
    }

    public function login(): void
    {
        Auth::guest();
        $this->validateCsrf();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            flash('error', 'Username and password are required.');
            $this->storeOld(['username' => $username]);
            $this->redirect('login');
        }

        $user = $this->users->verify($username, $password);

        if (!$user) {
            flash('error', 'Invalid username or password.');
            $this->storeOld(['username' => $username]);
            $this->redirect('login');
        }

        Auth::login(
            (int) $user['user_id'],
            $user['username'] ?? $user['full_name'] ?? $user['email'] ?? 'User'
        );
        flash('success', 'Welcome back!');
        $this->redirect('dashboard');
    }

    public function logout(): void
    {
        Auth::logout();
        flash('success', 'You have been logged out.');
        $this->redirect('login');
    }
}
