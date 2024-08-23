<?php

namespace Src\Config;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

class Env
{
    public static function load($path)
    {
        try {
            $dotenv = Dotenv::createImmutable($path);
            $dotenv->load();
        } catch (InvalidPathException $e) {
            die('Error loading .env file: ' . $e->getMessage());
        }
        catch (\Exception $e) {
            die('Error loading .env file: ' . $e->getMessage());
        }

    }
}
