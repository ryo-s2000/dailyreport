<?php

namespace Tests\Feature\Report;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class IndexMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
