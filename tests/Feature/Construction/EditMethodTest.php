<?php

namespace Tests\Feature\Construction;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class EditMethodTest extends TestCase
{
    public function testConnectivity()
    {
        // TODO inner DB
        $response = $this->get('/constructions/1/edit');

        $response->assertStatus(200);
    }
}
