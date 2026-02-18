<?php

namespace App\controllers;

use App\exceptions\AccountIsBlockedException;
use App\exceptions\NotEnoughMoneyException;
use App\QueryBuilder;
use League\Plates\Engine;
use PDO;

use function Tamtamchik\SimpleFlash\flash;

class HomeController {
    private $templates;
    private $auth;

    public function __construct() {
        $this->templates = new Engine('../app/views');
        $db = new PDO("mysql:host=MySQL-8.4;dbname=app3;charset=utf8", "root", "");
        $this->auth = new \Delight\Auth\Auth($db);
    }
    
    public function index()

    {
        $this->auth->login('jvn4@mail.ru', '123');
    
        $db = new QueryBuilder;
        $posts = $db->getAll('posts');

        echo $this->templates->render('homepage', ['postsInView' => $posts]);
    }

    public function about($vars)

    {

        try {
            $userId = $this->auth->register('jvn4@mail.ru', '123', 'Vit2', function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        echo $this->templates->render('about', ['name' => 'Jonathan about page']);
    }

    public function email_verification() {
        try {
            $this->auth->confirmEmail('FAqWAMKzz0vTPb53', 'lQeEH335QF36S31q');

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function login() {
        try {
            $this->auth->login('jvn4@mail.ru', '123');

            echo 'User is logged in';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}