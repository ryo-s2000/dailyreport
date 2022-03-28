<?php

namespace Tests\Feature\DataExport;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/data_export/create');

        $response->assertStatus(200);
    }
}
