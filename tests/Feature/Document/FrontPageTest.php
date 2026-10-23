<?php

declare(strict_types=1);

namespace App\Tests\Feature\Document;

use OpenDxp\TestFoundation\Browser;

it('renders the front page', function () {
    Browser::visit('/')
        ->assertSuccessful()
        ->assertSeeElement('#site');
});
