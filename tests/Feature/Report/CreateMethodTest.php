<?php

namespace Tests\Feature\Report;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/reports/create');

        $response->assertStatus(200);
    }
}
