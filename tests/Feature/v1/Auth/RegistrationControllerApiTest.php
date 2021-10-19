<?php

namespace Tests\Feature\v1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\ApiBaseTestCase;

class RegistrationControllerApiTest extends ApiBaseTestCase {

    public function test_able_to_register() {
        $response = $this->withHeaders($this->headers)
            ->json('POST', '/api/v1/register', [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => '123456789',
                'password_confirmation' => '123456789'
            ]);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }
}
