<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/11/2016
 * Time: 11:27
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;

class UserService
{

    public function isPasswordEmpty(User $user)
    {
        if(empty($user->getPassword()))
        {
            return true;
        }
            return false;
    }

}