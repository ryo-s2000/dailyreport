<?php

namespace Tests\Feature\Report;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateCopyMethodTest extends TestCase
{
    public function testConnectivity()
    {
        // TODO inner DB
        $response = $this->get('/reports/create');

        $response->assertStatus(200);
    }
}
