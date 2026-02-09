<?php

namespace App\controllers;

use App\exceptions\AccountIsBlockedException;
use App\exceptions\NotEnoughMoneyException;
use App\QueryBuilder;
use League\Plates\Engine;
use function Tamtamchik\SimpleFlash\flash;

class HomeController {
    private $templates;

    public function __construct() {
        $this->templates = new Engine('../app/views');
    }
    
    public function index($vars)

    {
        $db = new QueryBuilder;
        $posts = $db->getAll('posts');

        echo $this->templates->render('homepage', ['postsInView' => $posts]);
    }

    public function about($vars)

    {
        try {
            $this->withdraw($vars['amount']);
        } catch (NotEnoughMoneyException $exception) {
            flash()->error("Ваша баланс меньше" . $vars['amount']);
        } catch (AccountIsBlockedException $exception) {
            flash()->error("Ваш аккаунт заблокирован");
        }

        echo $this->templates->render('about', ['name' => 'Jonathan about page']);
    }

    public function withdraw($amount = 1)
    
    {
    
        $total = 10;

        // throw new AccountIsBlockedException("Your account is blocked");

        if ($amount > $total) {
            throw new NotEnoughMoneyException("Your balance is less than " . $amount);
        }
    }
}