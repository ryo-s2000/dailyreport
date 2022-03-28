<?php

namespace Tests\Feature\Report;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class IndexMethodTest extends TestCase
{
    public function testRedirect()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function testConnectivity()
    {
        $response = $this->get('/reports');

        $response->assertStatus(200);
    }
}
