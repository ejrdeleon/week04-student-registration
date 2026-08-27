<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the profile_pictures directory exists in public disk
        if (! Storage::disk('public')->exists('profile_pictures')) {
            Storage::disk('public')->makeDirectory('profile_pictures');
        }

        // Copy a placeholder image so seeded students display a valid image
        $placeholder = public_path('images/placeholder.png');
        if (! Storage::disk('public')->exists('profile_pictures/placeholder.png') && file_exists($placeholder)) {
            Storage::disk('public')->put(
                'profile_pictures/placeholder.png',
                file_get_contents($placeholder)
            );
        }

        Student::factory(15)->create();
    }
}
