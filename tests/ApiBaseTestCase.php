<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class ApiBaseTestCase extends BaseTestCase {
    use CreatesApplication;

    protected $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];
}
