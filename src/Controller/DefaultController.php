<?php

declare(strict_types=1);

namespace App\Controller;

use OpenDxp\Bundle\AdminBundle\Controller\Admin\LoginController;
use OpenDxp\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends FrontendController
{
    public function defaultAction(Request $request): Response
    {
        return $this->render('default/default.html.twig');
    }

    public function loginAction(): Response
    {
        return $this->forward(LoginController::class.'::loginCheckAction');
    }
}
