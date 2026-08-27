<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'mobile_number',
        'gender',
        'date_of_birth',
        'program',
        'year_level',
        'address',
        'profile_picture',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function fullName(): string
    {
        $parts = array_filter([$this->first_name, $this->middle_name, $this->last_name]);
        return implode(' ', $parts);
    }

    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('student_id', 'like', "%{$term}%")
              ->orWhere('first_name', 'like', "%{$term}%")
              ->orWhere('last_name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%");
        });
    }

    public function scopeByProgram(Builder $query, ?string $program): Builder
    {
        return $program ? $query->where('program', $program) : $query;
    }

    public function scopeByYearLevel(Builder $query, ?string $yearLevel): Builder
    {
        return $yearLevel ? $query->where('year_level', $yearLevel) : $query;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeNotArchived(Builder $query): Builder
    {
        return $query->where('status', '!=', 'archived');
    }

    // ─── Constants ────────────────────────────────────────────────────────────

    public const PROGRAMS = [
        'BS Information Technology',
        'BS Computer Science',
        'BS Information Systems',
        'BS Computer Engineering',
        'BS Electronics Engineering',
        'BS Business Administration',
        'BS Accountancy',
        'BS Nursing',
        'BS Education',
        'AB Communication',
    ];

    public const YEAR_LEVELS = [
        '1st Year',
        '2nd Year',
        '3rd Year',
        '4th Year',
    ];

    public const GENDERS = ['Male', 'Female', 'Other'];

    public const STATUSES = ['active', 'inactive', 'archived'];
}
