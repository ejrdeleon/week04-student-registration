@extends('layouts.app')

@section('title', 'Register Student')

@section('content')
<div class="bg-white shadow rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-6 text-indigo-700">Student Registration Form</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Student ID</label>
                <input type="text" name="student_id" value="{{ old('student_id') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Mobile Number</label>
                <input type="text" name="mobile_number" value="{{ old('mobile_number') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                       class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Gender</label>
                <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="">Select</option>
                    <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                    <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                    <option value="Other" @selected(old('gender') === 'Other')>Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Program</label>
                <input type="text" name="program" value="{{ old('program') }}"
                       class="w-full border rounded px-3 py-2" placeholder="e.g. BSIT">
            </div>
            <div>
                <label class="block text-sm font-medium">Year Level</label>
                <select name="year_level" class="w-full border rounded px-3 py-2">
                    <option value="">Select</option>
                    @foreach (['1st Year','2nd Year','3rd Year','4th Year'] as $year)
                        <option value="{{ $year }}" @selected(old('year_level') === $year)>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Address</label>
            <textarea name="address" rows="2" class="w-full border rounded px-3 py-2">{{ old('address') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium">Profile Picture</label>
            <input type="file" name="profile_picture" accept="image/png, image/jpeg"
                   class="w-full border rounded px-3 py-2 bg-white">
            <p class="text-xs text-gray-500 mt-1">JPG or PNG, max 2MB.</p>
        </div>

        <button type="submit" class="bg-indigo-700 text-white px-6 py-2 rounded hover:bg-indigo-800">
            Register
        </button>
    </form>
</div>
@endsection
