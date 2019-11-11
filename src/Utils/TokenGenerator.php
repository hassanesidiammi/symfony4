<?php


namespace App\Utils;


class TokenGenerator
{
    const ALPHA = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const NUM = '0123456789';

    public function getAlpha($length=25)
    {
        return $this->getShuffled(self::ALPHA, $length);
    }

    public function getAlphaNum($length=25)
    {
        return $this->getShuffled(self::ALPHA.self::NUM, $length);
    }

    public function getShuffled($baseString, $length=25)
    {
        $token = '';

        do {
            $token .= str_shuffle($baseString);
        } while(strlen($token) < $length);

        return substr($token, 0, $length);
    }
}