<?php

declare(strict_types=1);

use OpenDxp\Test\Expectation\Fields;
use OpenDxp\TestFoundation\TestCase;

Fields::register();

pest()->extend(TestCase::class)->in('Feature');
