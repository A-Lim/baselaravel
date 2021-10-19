<?php

namespace Tests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class ApiBaseTestCase extends BaseTestCase {
    use CreatesApplication;

    protected $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];

    protected function setUp(): void {
        parent::setUp();
        Artisan::call('db:wipe');
        Artisan::call('key:generate');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        Artisan::call('passport:install');
    }
}
