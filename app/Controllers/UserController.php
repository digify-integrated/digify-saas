<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Mail;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        $this->view('auth/register', [
            'csrf_token' => csrf_token()
        ]);
    }

    public function showLoginForm()
    {
        $this->view('auth/login', [
            'csrf_token' => csrf_token(),
            'pageTitle' => 'Login'
        ]);
    }

    /**
     * Handle registration form submission
     */
    public function register()
    {
        Session::start();
        $request = new Request();
        $userModel = new User();

        if (!$request->isPost()) {
            redirect('/register');
        }

        $data = $request->allPost();

        // CSRF Check
        if (!csrf_verify($data['_csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid CSRF token.');
            redirect('/register');
        }

        // Validation
        $errors = [];

        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $confirm = $data['confirm_password'] ?? '';

        if (empty($username)) $errors[] = 'Username is required.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
        if (empty($password)) $errors[] = 'Password is required.';
        if ($password !== $confirm) $errors[] = 'Passwords do not match.';

        if ($userModel->findByEmailOrUsername($email) || $userModel->findByEmailOrUsername($username)) {
            $errors[] = 'Email or username already exists.';
        }

        if (!empty($errors)) {
            Session::flash('errors', $errors);
            redirect('/register');
        }

        // Hash password and generate verification token
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $userModel->create([
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash,
            'verification_token' => $token,
            'token_expires_at' => $expiresAt,
            'is_verified' => 0,
        ]);

        // Send verification email
        $verificationLink = $_ENV['APP_URL'] . '/verify?token=' . $token;
        $subject = 'Verify Your Account';
        $message = "Hi {$username},\n\nPlease click the link below to verify your account:\n{$verificationLink}\n\nThis link will expire in 1 hour.\n\nThank you!";
        $headers = 'From: no-reply@yourapp.com';

        Mail::send($email, $subject, $message, $headers);

        Session::flash('success', 'Registration successful. Please check your email to verify your account.');
        redirect('/register');
    }

    /**
     * Handle account verification
     */
    public function verify()
    {
        Session::start();
        $request = new Request();
        $userModel = new User();

        $token = $request->get('token');

        if (!$token) {
            http_response_code(400);
            echo "Invalid verification link.";
            return;
        }

        $user = $userModel->findByVerificationToken($token);

        if (!$user) {
            echo "Invalid or expired verification link.";
            return;
        }

        if ($user['is_verified']) {
            echo "Your account is already verified.";
            return;
        }

        if (strtotime($user['token_expires_at']) < time()) {
            echo "Verification link has expired. Please request a new one.";
            return;
        }

        $userModel->verifyUser($user['id']);
        echo "Your account has been successfully verified. You may now log in.";
    }
}
