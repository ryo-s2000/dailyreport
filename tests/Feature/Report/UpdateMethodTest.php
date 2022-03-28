<?php

namespace Tests\Feature\Report;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->put('/reports/1/edit');

        // TODO validation test
        $response->assertStatus(405);
    }
}
