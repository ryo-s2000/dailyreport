<?php

namespace Tests\Feature\Report;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class StoreMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->post('/reports/create');

        // TODO validation test
        $response->assertStatus(405);
    }
}
