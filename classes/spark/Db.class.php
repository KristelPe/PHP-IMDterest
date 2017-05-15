<?php

namespace spark;

use PDO;

abstract class Db
{
    private static $conn = null;

    public static function getInstance()
    {
        if (isset($conn)) {
            //er is een connectie geef ze terug
            return self::$conn;
        } else {
            //er is nog geen connectie maak ze aan en geef ze terug
            self::$conn = new PDO("mysql:host=localhost; dbname=IMDterest", "root", "");
            return self::$conn;
        }
    }
}
