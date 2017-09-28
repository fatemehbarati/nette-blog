<?php
/**
 * Created by PhpStorm.
 * User: muhammad
 * Date: 9/28/2017
 * Time: 12:36 PM
 */

namespace App\Model;


use Nette\Security\Permission;

class AuthorizatorFactory
{

    /** @return Permission */
    public static function create()
    {
        $acl = new Permission();

        $acl->addRole('guest');
        $acl->addRole('admin');

        $acl->addResource('article');

        $acl->allow('guest', 'article');

        return $acl;
    }
}