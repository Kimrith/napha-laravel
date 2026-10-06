<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test that all primary dashboard routes return successful status codes.
     */
    public function test_all_portal_routes_render_successfully(): void
    {
        $routes = [
            '/',
            '/dashboard',
            '/students',
            '/courses',
            '/attendance',
            '/grades',
            '/departments',
            '/settings',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }
}
