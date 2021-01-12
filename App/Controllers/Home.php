<?php declare(strict_types=1);

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 */
class Home extends \Core\Controller
{
    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction() : void 
    {
        View::renderTemplate($this->route_params, [
            'name' => 'Daniel',
            'colors' => ['blue', 'green', 'red'],
            'page_keywords' => 'keyword1, keyword2, keyword3'
        ]);
    }

    protected function before() : void
    {
    }

    protected function after() : void
    {
    }
}