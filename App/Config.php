<?php declare(strict_types=1);

namespace App;

/**
 * Application configuration
 */
class Config
{
    /**
     * Site meta data configuration
     */
    const SITE_NAME = "your-site-name";
    const META_OG_URL = "your-og-url";
    const META_OG_TITLE = "your-og-title";
    const META_OG_DESCRIPTION = "your-site-description";
    const META_OG_IMAGE = "your-og-image-url";
    const META_KEYWORDS = "your-site-keywords";
    const META_AUTHOR = "your-site-author";
    const META_COPYRIGHT = "your-copyright-info";
    const META_COPYRIGHT_YEAR = "2020";

    /**
     * Database configuration
     */
    const DB_HOST = 'your-database-host';
    const DB_NAME = 'your-database-name';
    const DB_USER = 'your-database-user';
    const DB_PASSWORD = 'your-database-password';
    const DB_CHARSET = 'utf8';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
}
