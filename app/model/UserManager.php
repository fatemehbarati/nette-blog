<?php
/**
 * Created by PhpStorm.
 * User: muhammad
 * Date: 9/28/2017
 * Time: 2:22 PM
 */

namespace App\Model;


use Nette\Database\Context;

class UserManager
{

    /** @var  Context */
    private $database;

    public function __construct(Context $database)
    {

        $this->database = $database;
    }

    public function signUpUser($values)
    {
        $this->database->table('users')
            ->insert(
                [
                    'username' => $values['username'],
                    'password' => $values['password']
                ]
            );
    }
}