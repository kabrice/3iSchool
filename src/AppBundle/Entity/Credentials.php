<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 20/11/2016
 * Time: 11:39
 */

namespace AppBundle\Entity;


class Credentials
{
    protected $login;

    protected $password;

    protected $gRecaptchaResponse;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getGRecaptchaResponse()
    {
        return $this->gRecaptchaResponse;
    }

    public function setGRecaptchaResponse($gRecaptchaResponse)
    {
        $this->gRecaptchaResponse = $gRecaptchaResponse;
    }


}