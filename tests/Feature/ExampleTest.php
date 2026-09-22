<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_dashboard_renders_an_empty_pipeline_state(): void
    {
        $response = $this->get('/');

        $response->assertSee('No leads yet. Add your first salon enquiry to get started.');
    }
}
