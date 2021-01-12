<?php declare(strict_types=1);

namespace Core;

use App\Config;

class View
{
    /**
     * Render a view file
     * 
     * @param array $route_params The parameters of the current route
     * @param array $args Associative array of data to display in the view (optional)
     * 
     * @return void
     */
    public static function render(array $route_params, array $args = []) : void
    {
        $view = $route_params['controller'] . '/' . $route_params['action'] . '.php';

        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";

        if (is_readable($file))
        {
            require $file;
        }
        else
        {
            echo "$file not found";
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param array $route_params The parameters of the current route
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate(array $route_params, array $args = []) : void
    {
        static $twig = null;

        if ($twig === null) 
        {
            $loader = new \Twig\Loader\Filesystemloader(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig\Environment($loader);

            $twig->addGlobal('site_name', Config::SITE_NAME);
            $twig->addGlobal('meta_og_url', Config::META_OG_URL);
            $twig->addGlobal('meta_og_title', Config::META_OG_TITLE);
            $twig->addGlobal('meta_og_description', Config::META_OG_DESCRIPTION);
            $twig->addGlobal('meta_og_image', Config::META_OG_IMAGE);
            $twig->addGlobal('meta_keywords', Config::META_KEYWORDS);
            $twig->addGlobal('meta_author', Config::META_AUTHOR);
            $twig->addGlobal('meta_copyright', Config::META_COPYRIGHT);

            $copyright_info = html_entity_decode('&copy;', ENT_COMPAT, 'UTF-8') . ' ' . Config::META_COPYRIGHT_YEAR;
            if (date("Y") !== Config::META_COPYRIGHT_YEAR)
            {
                $copyright_info .= ' - ' . date("Y");
            }
            $copyright_info .= ' ' . Config::META_COPYRIGHT;

            $twig->addGlobal('copyright_info', $copyright_info);
        }

        $template = $route_params['controller'] . '/' . $route_params['action'] . '.html';
        echo $twig->render($template, $args);
    }
}