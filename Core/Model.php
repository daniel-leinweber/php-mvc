<?php declare(strict_types=1);

namespace Core;

use App\Config;

/**
 * Base model
 */
abstract class Model
{
    /**
     * Get the mysqli database connection
     * 
     * @return Database 
     */
    protected static function getDatabaseConnection() : Database
    {
        static $db = null;
        
        if ($db === null)
        {
            $db = new Database(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME, Config::DB_CHARSET);
        }

        return $db;
    }
}
