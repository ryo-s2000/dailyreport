<?php

namespace Tests\Feature\Construction;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class RootIndexMethodTest extends TestCase
{
    public function testConnectivity()
    {
        // TODO fix auth
        $response = $this->get('/constructions/password');

        $response->assertStatus(200);
    }
}
