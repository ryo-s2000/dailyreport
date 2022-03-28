<?php

namespace Tests\Feature\DataExport;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class GenerateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        // TODO csv generate test
        $response = $this->get('/data_export/create');

        $response->assertStatus(200);
    }
}
