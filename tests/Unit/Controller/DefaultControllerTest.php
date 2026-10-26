<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\DefaultController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

it('renders the default template', function () {

    $twig = new Environment(new ArrayLoader([
        'default/default.html.twig' => 'At OpenDXP we love writing tests!',
    ]));

    $container = new Container();
    $container->set('twig', $twig);

    $controller = new DefaultController();
    $controller->setContainer($container);

    $response = $controller->defaultAction(Request::create('/'));

    expect($response->getStatusCode())
        ->toBe(200)
        ->and($response->getContent())
        ->toBe('At OpenDXP we love writing tests!');
});
