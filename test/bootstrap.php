<?php

use Http\Discovery\ClassDiscovery;
use Http\Discovery\Strategy\MockClientStrategy;

require __DIR__ . '/../vendor/autoload.php';

// No real PSR-18 client is installed for the test suite, and the php-http/discovery
// Composer plugin that would auto-install one is disabled in composer.json. Point
// discovery at the mock client so the tests that let the library build its own client
// still get a client.
ClassDiscovery::prependStrategy(MockClientStrategy::class);
