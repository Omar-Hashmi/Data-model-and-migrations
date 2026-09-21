<?php

namespace Database\Seeders;

use App\Models\Contact;
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
    }
}
