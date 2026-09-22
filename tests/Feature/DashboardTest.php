<?php

namespace Tests\Feature;

use Database\Seeders\SalonCrmSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_dashboard_renders_seeded_crm_records(): void
    {
        $this->seed(SalonCrmSeeder::class);

        $response = $this->get('/');

        $response->assertSee('Glow Beauty Salon')
            ->assertSee('Pipeline overview')
            ->assertSee('Ayesha Khan')
            ->assertSee('Call to arrange bridal consultation')
            ->assertSee('Welcome email sent');
    }
}
