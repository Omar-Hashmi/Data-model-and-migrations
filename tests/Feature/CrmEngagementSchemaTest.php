<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\EmailTemplate;
use App\Models\FollowUpReminder;
use App\Models\Lead;
use App\Models\PipelineStage;
use Database\Seeders\SalonCrmSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CrmEngagementSchemaTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_seeder_creates_templates_and_connected_crm_timeline_records(): void
    {
        $this->seed(SalonCrmSeeder::class);

        $this->assertDatabaseCount('email_templates', 5);
        $this->assertDatabaseHas('email_templates', ['slug' => 'consultation-confirmation', 'is_active' => true]);

        $lead = Lead::query()
            ->where('email', 'ayesha.khan@example.test')
            ->with(['contacts', 'followUpReminders', 'activityLogs'])
            ->firstOrFail();

        $this->assertCount(1, $lead->contacts);
        $this->assertCount(1, $lead->followUpReminders);
        $this->assertCount(1, $lead->activityLogs);
        $this->assertSame('new-enquiry-welcome', $lead->activityLogs->first()->metadata['template']);
        $this->assertTrue(EmailTemplate::query()->where('slug', 'rebooking-invitation')->firstOrFail()->is_active);
    }

    public function test_deleting_a_contact_preserves_linked_reminders_and_activity_history(): void
    {
        $stage = PipelineStage::factory()->create();
        $lead = Lead::factory()->for($stage)->create();
        $contact = Contact::factory()->for($lead)->create();
        $reminder = FollowUpReminder::factory()->for($lead)->for($contact)->create();
        $activity = ActivityLog::factory()->for($lead)->for($contact)->create();

        $contact->delete();

        $this->assertModelExists($reminder);
        $this->assertModelExists($activity);
        $this->assertNull($reminder->fresh()->contact_id);
        $this->assertNull($activity->fresh()->contact_id);
    }
}
