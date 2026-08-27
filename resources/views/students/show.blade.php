@extends('layouts.app')

@section('title', $student->fullName() . ' — Profile')

@section('content')
{{-- Breadcrumb & Action Header --}}
<div class="print:hidden">
    <x-page-header
        title="Student Profile"
        subtitle="Registration details and academic profile for {{ $student->fullName() }}."
    >
        <x-slot:actions>
            <a href="{{ route('students.index') }}"
               class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
            <button onclick="window.print()"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Summary
            </button>
            <a href="{{ route('students.edit', $student->id) }}"
               class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profile
            </a>
        </x-slot:actions>
    </x-page-header>
</div>

{{-- Printable Summary Header (Only visible when printing) --}}
<div class="hidden print:block mb-8 border-b-2 border-indigo-900 pb-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">STUDENT REGISTRATION RECORD</h1>
            <p class="text-sm text-gray-500">Official Student Profile Summary • ITST 302 Mini Project</p>
        </div>
        <div class="text-right text-xs text-gray-500">
            <p>Printed: {{ now()->format('F d, Y h:i A') }}</p>
            <p class="font-mono">ID: {{ $student->student_id }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- Left Card: Identity Card --}}
    <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm text-center">
        <div class="relative mx-auto mb-4 h-36 w-36 overflow-hidden rounded-2xl border-4 border-indigo-100 shadow-inner">
            <img src="{{ asset('storage/' . $student->profile_picture) }}"
                 alt="{{ $student->fullName() }}"
                 onerror="this.src='{{ asset('images/placeholder.png') }}'"
                 class="h-full w-full object-cover">
        </div>

        <h2 class="text-xl font-bold text-gray-900">{{ $student->fullName() }}</h2>
        <p class="mt-1 font-mono text-sm font-medium text-indigo-600">{{ $student->student_id }}</p>
        
        <div class="mt-3 flex items-center justify-center gap-2">
            <x-status-badge :status="$student->status" />
            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700">
                {{ $student->year_level }}
            </span>
        </div>

        <div class="mt-6 border-t border-gray-100 pt-4 text-left space-y-3 text-xs text-gray-500">
            <div class="flex justify-between">
                <span class="font-medium text-gray-400">Registered On:</span>
                <span class="text-gray-700">{{ $student->created_at->format('M d, Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-400">Last Updated:</span>
                <span class="text-gray-700">{{ $student->updated_at->format('M d, Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-400">Database Record:</span>
                <span class="font-mono text-gray-700">#{{ $student->id }}</span>
            </div>
        </div>
    </div>

    {{-- Right Card: Detailed Information --}}
    <div class="space-y-6 lg:col-span-2">

        {{-- Academic Information Card --}}
        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-gray-900 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                </svg>
                Academic Information
            </h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
                <div>
                    <span class="block text-xs font-medium text-gray-400">Academic Program</span>
                    <span class="font-medium text-gray-900">{{ $student->program }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-400">Year Level</span>
                    <span class="font-medium text-gray-900">{{ $student->year_level }}</span>
                </div>
            </div>
        </div>

        {{-- Personal Details Card --}}
        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-gray-900 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Personal Details
            </h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 text-sm">
                <div>
                    <span class="block text-xs font-medium text-gray-400">First Name</span>
                    <span class="font-medium text-gray-900">{{ $student->first_name }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-400">Middle Name</span>
                    <span class="font-medium text-gray-900">{{ $student->middle_name ?: '—' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-400">Last Name</span>
                    <span class="font-medium text-gray-900">{{ $student->last_name }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-400">Gender</span>
                    <span class="font-medium text-gray-900">{{ $student->gender }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-400">Date of Birth</span>
                    <span class="font-medium text-gray-900">{{ $student->date_of_birth->format('F d, Y') }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-400">Age</span>
                    <span class="font-medium text-gray-900">{{ $student->age }} years old</span>
                </div>
            </div>
        </div>

        {{-- Contact & Address Card --}}
        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-gray-900 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contact & Address
            </h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 text-sm">
                <div>
                    <span class="block text-xs font-medium text-gray-400">Email Address</span>
                    <span class="font-medium text-gray-900">{{ $student->email }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-400">Mobile Number</span>
                    <span class="font-medium text-gray-900">{{ $student->mobile_number }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium text-gray-400">Residential Address</span>
                    <span class="font-medium text-gray-900">{{ $student->address }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
