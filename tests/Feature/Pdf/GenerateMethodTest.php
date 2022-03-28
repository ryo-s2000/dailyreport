<?php

namespace Tests\Feature\Pdf;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class GenerateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        // TODO inner DB
        $response = $this->get('/pdf/1');

        $response->assertStatus(200);
    }
}
