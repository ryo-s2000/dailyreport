<?php

namespace Tests\Feature\Construction;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class StoreMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->post('/constructions/create');

        // TODO validation test
        $response->assertStatus(405);
    }
}
