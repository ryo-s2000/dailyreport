<?php

namespace Tests\Feature\Trader;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class EditMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/traders/edit');

        $response->assertStatus(200);
    }
}
