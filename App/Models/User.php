<?php declare(strict_types=1);

namespace App\Models;

/**
 * Example user model
 */
class User extends \Core\Model
{
    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll() : array
    {
        $db = static::getDatabaseConnection();
        $users = $db->query('SELECT id, name FROM users')->fetchAll();

        return $users;
    }
}
