<?php

declare(strict_types=1);

namespace App\Tests\Feature\Document;

use App\Controller\DefaultController;
use OpenDxp\Test\Factory\DocumentPageFactory;
use OpenDxp\TestFoundation\Browser;

it('renders a page with the default template', function () {

    $page = DocumentPageFactory::new()
        ->withController(DefaultController::class, 'defaultAction')
        ->create();

    Browser::visit($page->getFullPath())
        ->assertSuccessful()
        ->assertSeeElement('#site');
});
