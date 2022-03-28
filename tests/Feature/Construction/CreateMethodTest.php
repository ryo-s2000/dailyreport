<?php

namespace Tests\Feature\Construction;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/constructions/create');

        $response->assertStatus(200);
    }
}
