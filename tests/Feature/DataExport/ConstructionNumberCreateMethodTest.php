<?php

namespace Tests\Feature\DataExport;

use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ConstructionNumberCreateMethodTest extends TestCase
{
    public function testConnectivity()
    {
        $response = $this->get('/data_export/construction_number/create');

        $response->assertStatus(200);
    }
}
