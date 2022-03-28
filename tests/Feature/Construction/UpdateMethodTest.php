<?php

namespace Tests\Feature\Construction;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->put('/constructions/1/edit');

        // TODO validation test
        $response->assertStatus(405);
    }
}
