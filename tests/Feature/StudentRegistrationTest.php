<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_screen_can_be_rendered(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('System Dashboard');
    }

    public function test_registration_form_screen_can_be_rendered(): void
    {
        $response = $this->get(route('students.create'));
        $response->assertStatus(200);
        $response->assertSee('Register New Student');
        $response->assertSee('Student ID');
        $response->assertSee('Profile Picture');
    }

    public function test_students_list_screen_can_be_rendered(): void
    {
        $student = Student::factory()->create([
            'student_id'  => '2026-00001',
            'first_name'  => 'Maria',
            'middle_name' => null,
            'last_name'   => 'Santos',
        ]);

        $response = $this->get(route('students.index'));
        $response->assertStatus(200);
        $response->assertSee($student->fullName());
        $response->assertSee('2026-00001');
    }

    public function test_student_can_be_registered_with_valid_data_and_profile_picture(): void
    {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('student.jpg', 400, 400);

        $postData = [
            'student_id'      => '2026-10001',
            'first_name'      => 'Juan',
            'middle_name'     => 'Dela',
            'last_name'       => 'Cruz',
            'email'           => 'juan.delacruz@example.com',
            'mobile_number'   => '09123456789',
            'gender'          => 'Male',
            'date_of_birth'   => '2004-05-15',
            'program'         => 'BS Information Technology',
            'year_level'      => '2nd Year',
            'address'         => '123 Rizal St., Manila',
            'profile_picture' => $photo,
        ];

        $response = $this->post(route('students.store'), $postData);

        // Asserts
        $this->assertDatabaseHas('students', [
            'student_id' => '2026-10001',
            'email'      => 'juan.delacruz@example.com',
            'first_name' => 'Juan',
            'last_name'  => 'Cruz',
        ]);

        $student = Student::where('student_id', '2026-10001')->first();
        $this->assertNotNull($student);

        // Check file exists in Laravel public storage
        Storage::disk('public')->assertExists($student->profile_picture);

        // Check redirect and flash message
        $response->assertRedirect(route('students.show', $student->id));
        $response->assertSessionHas('success');
    }

    public function test_registration_requires_mandatory_fields(): void
    {
        $response = $this->post(route('students.store'), []);

        $response->assertSessionHasErrors([
            'student_id',
            'first_name',
            'last_name',
            'email',
            'mobile_number',
            'gender',
            'date_of_birth',
            'program',
            'year_level',
            'address',
            'profile_picture',
        ]);
    }

    public function test_duplicate_student_id_is_rejected(): void
    {
        Student::factory()->create(['student_id' => '2026-00099']);

        $response = $this->post(route('students.store'), [
            'student_id' => '2026-00099',
        ]);

        $response->assertSessionHasErrors(['student_id']);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        Student::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->post(route('students.store'), [
            'email' => 'duplicate@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_invalid_profile_picture_mime_type_is_rejected(): void
    {
        Storage::fake('public');
        $fakePdf = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->post(route('students.store'), [
            'profile_picture' => $fakePdf,
        ]);

        $response->assertSessionHasErrors(['profile_picture']);
    }

    public function test_profile_picture_exceeding_2mb_is_rejected(): void
    {
        Storage::fake('public');
        $largeImage = UploadedFile::fake()->create('huge.jpg', 3000, 'image/jpeg');

        $response = $this->post(route('students.store'), [
            'profile_picture' => $largeImage,
        ]);

        $response->assertSessionHasErrors(['profile_picture']);
    }

    public function test_student_profile_page_displays_details(): void
    {
        $student = Student::factory()->create([
            'first_name' => 'Clara',
            'last_name'  => 'Reyes',
            'program'    => 'BS Computer Science',
        ]);

        $response = $this->get(route('students.show', $student->id));
        $response->assertStatus(200);
        $response->assertSee($student->fullName());
        $response->assertSee('BS Computer Science');
        $response->assertSee('Print Summary');
    }

    public function test_student_can_be_updated(): void
    {
        $student = Student::factory()->create([
            'first_name' => 'Original',
            'last_name'  => 'Name',
        ]);

        $response = $this->put(route('students.update', $student->id), [
            'student_id'    => $student->student_id,
            'first_name'    => 'Updated',
            'last_name'     => 'Name',
            'email'         => $student->email,
            'mobile_number' => $student->mobile_number,
            'gender'        => $student->gender,
            'date_of_birth' => $student->date_of_birth->format('Y-m-d'),
            'program'       => $student->program,
            'year_level'    => $student->year_level,
            'address'       => 'Updated Address 456',
        ]);

        $response->assertRedirect(route('students.show', $student->id));
        $this->assertDatabaseHas('students', [
            'id'         => $student->id,
            'first_name' => 'Updated',
            'address'    => 'Updated Address 456',
        ]);
    }

    public function test_student_can_be_archived(): void
    {
        $student = Student::factory()->create(['status' => 'active']);

        $response = $this->delete(route('students.destroy', $student->id));

        $response->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', [
            'id'     => $student->id,
            'status' => 'archived',
        ]);
    }
}

