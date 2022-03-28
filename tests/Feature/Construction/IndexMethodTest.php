<?php

namespace Tests\Feature\Construction;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class IndexMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/constructions');

        $response->assertStatus(200);
    }
}
