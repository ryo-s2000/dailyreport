<?php

namespace Tests\Feature\Report;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ShowMethodTest extends TestCase
{
    public function testConnectivity()
    {
        // TODO inner DB
        $response = $this->get('/reports/1');

        $response->assertStatus(200);
    }
}
