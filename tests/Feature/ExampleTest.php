<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->get('/')
            ->assertOk();
    }

    /** @test */
    public function customer_login()
    {
        $this->get('/login')
            ->assertOk();
    }
}
