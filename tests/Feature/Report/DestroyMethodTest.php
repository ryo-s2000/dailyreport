<?php

namespace Tests\Feature\Report;

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
        $response = $this->get('/reports/1');

        $response->assertStatus(200);
    }
}
