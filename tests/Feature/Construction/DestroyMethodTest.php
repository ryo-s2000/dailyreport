<?php

namespace Tests\Feature\Construction;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class DestroyMethodTest extends TestCase
{
    public function testConnectivity()
    {
        // TODO delete method
        $response = $this->get('/constructions/1');

        // TODO validation test
        $response->assertStatus(405);
    }
}
