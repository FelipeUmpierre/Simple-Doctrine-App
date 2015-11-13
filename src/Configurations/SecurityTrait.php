<?php

namespace Configurations;

trait SecurityTrait
{
    /**
     * Encrypt password
     *
     * @param string $password
     */
    public function encrypt(&$password)
    {
        $password = password_hash($password, PASSWORD_BCRYPT, [
            "cost" => 12,
        ]);
    }

    /**
     * Compare the password and the hash
     *
     * @param $password
     * @param $hash
     * @return bool
     */
    public function compare($password, $hash)
    {
        return password_verify($password, $hash);
    }
}