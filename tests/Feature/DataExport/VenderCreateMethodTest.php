<?php

namespace Tests\Feature\DataExport;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class VenderCreateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/data_export/vender/create');

        $response->assertStatus(200);
    }
}
