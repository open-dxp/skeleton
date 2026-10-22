<?php

declare(strict_types=1);

namespace App\Tests;

use App\Kernel;
use OpenDxp\TestFoundation\Kernel\Testable;

final class TestKernel extends Kernel
{
    use Testable;
}
