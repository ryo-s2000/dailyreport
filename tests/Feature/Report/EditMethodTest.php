<?php

namespace Tests\Feature\Report;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class EditMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/reports/1/edit');

        $response->assertStatus(200);
    }
}
