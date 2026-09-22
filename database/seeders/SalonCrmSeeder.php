<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\EmailTemplate;
use App\Models\FollowUpReminder;
use App\Models\Lead;
use App\Models\PipelineStage;
use Illuminate\Database\Seeder;

class SalonCrmSeeder extends Seeder
{
    public function run(): void
    {
        $stages = collect([
            ['name' => 'New Enquiry', 'slug' => 'new-enquiry', 'position' => 1, 'color' => '#60A5FA'],
            ['name' => 'Consultation Booked', 'slug' => 'consultation-booked', 'position' => 2, 'color' => '#FBBF24'],
            ['name' => 'Client Won', 'slug' => 'client-won', 'position' => 3, 'is_closed' => true, 'color' => '#34D399'],
        ])->mapWithKeys(fn (array $stage) => [$stage['slug'] => PipelineStage::query()->create($stage)]);

        $leads = [
            ['Ayesha', 'Khan', 'ayesha.khan@example.test', '0300-555-0101', 'Instagram', 'new-enquiry', 8500], ['Sara', 'Ahmed', 'sara.ahmed@example.test', '0300-555-0102', 'Walk-in', 'consultation-booked', 12000], ['Maham', 'Ali', 'maham.ali@example.test', '0300-555-0103', 'Referral', 'client-won', 18500], ['Hina', 'Malik', 'hina.malik@example.test', '0300-555-0104', 'Facebook', 'new-enquiry', 6500], ['Zara', 'Sheikh', 'zara.sheikh@example.test', '0300-555-0105', 'Google', 'consultation-booked', 15000], ['Iqra', 'Raza', 'iqra.raza@example.test', '0300-555-0106', 'Instagram', 'new-enquiry', 9200], ['Nimra', 'Aslam', 'nimra.aslam@example.test', '0300-555-0107', 'Referral', 'client-won', 21000], ['Fatima', 'Noor', 'fatima.noor@example.test', '0300-555-0108', 'Walk-in', 'consultation-booked', 11000], ['Alina', 'Tariq', 'alina.tariq@example.test', '0300-555-0109', 'Google', 'new-enquiry', 7800], ['Komal', 'Butt', 'komal.butt@example.test', '0300-555-0110', 'Facebook', 'consultation-booked', 13500],
        ];

        foreach ($leads as [$firstName, $lastName, $email, $phone, $source, $stage, $value]) {
            Lead::query()->create(['pipeline_stage_id' => $stages[$stage]->id, 'first_name' => $firstName, 'last_name' => $lastName, 'email' => $email, 'phone' => $phone, 'source' => $source, 'estimated_value' => $value, 'notes' => 'Sample Glow Beauty Salon enquiry.', 'next_follow_up_at' => now()->addDays(2), 'converted_at' => $stage === 'client-won' ? now() : null]);
        }

        Lead::query()->orderBy('id')->take(3)->get()->each(function (Lead $lead): void {
            Contact::query()->create(['lead_id' => $lead->id, 'first_name' => $lead->first_name, 'last_name' => $lead->last_name, 'email' => $lead->email, 'phone' => $lead->phone, 'preferred_channel' => 'phone', 'is_primary' => true]);
        });

        EmailTemplate::query()->insert([
            ['name' => 'New Enquiry Welcome', 'slug' => 'new-enquiry-welcome', 'category' => 'welcome', 'subject' => 'Welcome to Glow Beauty Salon, {{first_name}}!', 'body' => 'Hi {{first_name}}, thank you for getting in touch. We would love to help plan your next Glow Beauty Salon visit.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Consultation Confirmation', 'slug' => 'consultation-confirmation', 'category' => 'consultation', 'subject' => 'Your Glow Beauty Salon consultation is confirmed', 'body' => 'Hi {{first_name}}, your consultation is booked for {{appointment_date}}. Please reply if you need to reschedule.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Consultation Reminder', 'slug' => 'consultation-reminder', 'category' => 'reminder', 'subject' => 'A friendly reminder about your Glow consultation', 'body' => 'Hi {{first_name}}, we are looking forward to seeing you on {{appointment_date}}. Our team is ready to make your visit special.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Treatment Follow Up', 'slug' => 'treatment-follow-up', 'category' => 'follow-up', 'subject' => 'How did you enjoy your Glow Beauty Salon treatment?', 'body' => 'Hi {{first_name}}, we hope you loved your recent treatment. Reply with any feedback or questions for our stylists.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rebooking Invitation', 'slug' => 'rebooking-invitation', 'category' => 'rebooking', 'subject' => 'Ready for your next Glow appointment?', 'body' => 'Hi {{first_name}}, it may be the perfect time to refresh your look. Book your next Glow Beauty Salon appointment today.', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $primaryContacts = Contact::query()->orderBy('id')->get()->keyBy('lead_id');
        $leadByEmail = Lead::query()->get()->keyBy('email');

        FollowUpReminder::query()->insert([
            ['lead_id' => $leadByEmail['ayesha.khan@example.test']->id, 'contact_id' => $primaryContacts[$leadByEmail['ayesha.khan@example.test']->id]->id, 'title' => 'Call to arrange bridal consultation', 'channel' => 'phone', 'status' => 'pending', 'due_at' => now()->addDay(), 'notes' => 'Ask about preferred wedding date and bridal party size.', 'completed_at' => null, 'created_at' => now(), 'updated_at' => now()],
            ['lead_id' => $leadByEmail['sara.ahmed@example.test']->id, 'contact_id' => $primaryContacts[$leadByEmail['sara.ahmed@example.test']->id]->id, 'title' => 'Send consultation preparation details', 'channel' => 'email', 'status' => 'pending', 'due_at' => now()->addDays(2), 'notes' => 'Include patch-test guidance for the colour service.', 'completed_at' => null, 'created_at' => now(), 'updated_at' => now()],
            ['lead_id' => $leadByEmail['maham.ali@example.test']->id, 'contact_id' => $primaryContacts[$leadByEmail['maham.ali@example.test']->id]->id, 'title' => 'Check in after hair treatment', 'channel' => 'phone', 'status' => 'completed', 'due_at' => now()->subDay(), 'notes' => 'Confirm the client is happy with the keratin treatment.', 'completed_at' => now()->subHours(3), 'created_at' => now(), 'updated_at' => now()],
        ]);

        ActivityLog::query()->insert([
            ['lead_id' => $leadByEmail['ayesha.khan@example.test']->id, 'contact_id' => $primaryContacts[$leadByEmail['ayesha.khan@example.test']->id]->id, 'activity_type' => 'email', 'subject' => 'Welcome email sent', 'description' => 'Sent the New Enquiry Welcome template after the Instagram enquiry.', 'metadata' => json_encode(['template' => 'new-enquiry-welcome', 'source' => 'Instagram']), 'occurred_at' => now()->subHours(4), 'created_at' => now(), 'updated_at' => now()],
            ['lead_id' => $leadByEmail['sara.ahmed@example.test']->id, 'contact_id' => $primaryContacts[$leadByEmail['sara.ahmed@example.test']->id]->id, 'activity_type' => 'call', 'subject' => 'Consultation confirmed by phone', 'description' => 'Sara confirmed her colour consultation and requested preparation details by email.', 'metadata' => json_encode(['outcome' => 'confirmed']), 'occurred_at' => now()->subHours(2), 'created_at' => now(), 'updated_at' => now()],
            ['lead_id' => $leadByEmail['maham.ali@example.test']->id, 'contact_id' => $primaryContacts[$leadByEmail['maham.ali@example.test']->id]->id, 'activity_type' => 'status_change', 'subject' => 'Lead converted to client', 'description' => 'Marked as Client Won after completing the keratin treatment package.', 'metadata' => json_encode(['from' => 'consultation-booked', 'to' => 'client-won']), 'occurred_at' => now()->subDay(), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
