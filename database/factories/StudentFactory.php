<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $year  = $this->faker->numberBetween(2023, 2026);
        $seq   = str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT);

        return [
            'student_id'      => "{$year}-{$seq}",
            'first_name'      => $this->faker->firstName(),
            'middle_name'     => $this->faker->optional(0.7)->lastName(),
            'last_name'       => $this->faker->lastName(),
            'email'           => $this->faker->unique()->safeEmail(),
            'mobile_number'   => '09' . $this->faker->numerify('#########'),
            'gender'          => $this->faker->randomElement(['Male', 'Female']),
            'date_of_birth'   => $this->faker->dateTimeBetween('-30 years', '-16 years')->format('Y-m-d'),
            'program'         => $this->faker->randomElement(Student::PROGRAMS),
            'year_level'      => $this->faker->randomElement(Student::YEAR_LEVELS),
            'address'         => $this->faker->address(),
            'profile_picture' => 'profile_pictures/placeholder.png',
            'status'          => $this->faker->randomElement(['active', 'active', 'active', 'inactive']),
        ];
    }
}
