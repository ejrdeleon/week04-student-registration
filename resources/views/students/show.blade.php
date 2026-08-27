@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
<div class="bg-white shadow rounded-lg p-8">
    <div class="flex items-center gap-6 mb-6">
        <img src="{{ asset('storage/' . $student->profile_picture) }}"
             alt="Profile picture"
             class="w-28 h-28 rounded-full object-cover border-4 border-indigo-200">
        <div>
            <h1 class="text-2xl font-bold text-indigo-700">{{ $student->fullName() }}</h1>
            <p class="text-gray-500">{{ $student->student_id }} &middot; {{ $student->program }} ({{ $student->year_level }})</p>
        </div>
    </div>

    <dl class="grid grid-cols-2 gap-4 text-sm">
        <div><dt class="font-medium text-gray-500">Email</dt><dd>{{ $student->email }}</dd></div>
        <div><dt class="font-medium text-gray-500">Mobile Number</dt><dd>{{ $student->mobile_number }}</dd></div>
        <div><dt class="font-medium text-gray-500">Gender</dt><dd>{{ $student->gender }}</dd></div>
        <div><dt class="font-medium text-gray-500">Date of Birth</dt><dd>{{ $student->date_of_birth->format('F d, Y') }}</dd></div>
        <div class="col-span-2"><dt class="font-medium text-gray-500">Address</dt><dd>{{ $student->address }}</dd></div>
    </dl>
</div>
@endsection
