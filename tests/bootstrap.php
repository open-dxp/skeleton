<?php

// define project root which will be used throughout the bootstrapping process
define('OPENDXP_PROJECT_ROOT', dirname(__DIR__));

const PROJECT_ROOT = OPENDXP_PROJECT_ROOT;

// set the used opendxp/symfony environment
foreach (['APP_ENV' => 'test', 'OPENDXP_SKIP_DOTENV_FILE' => true] as $name => $value) {
    putenv("{$name}={$value}");
    $_ENV[$name] = $_SERVER[$name] = $value;
}
require_once OPENDXP_PROJECT_ROOT . '/vendor/autoload.php';

\OpenDxp\Bootstrap::setProjectRoot();
\OpenDxp\Bootstrap::bootstrap();
