<?php

declare(strict_types=1);

namespace App\Tests\Feature\Console;

use OpenDxp\TestFoundation\Container;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

it('lists the OpenDXP commands', function () {
    $application = new Application(Container::testClient()->getKernel());
    $command = new CommandTester($application->find('list'));

    $command->execute([]);

    expect($command->getDisplay())->toContain('opendxp:');
});
