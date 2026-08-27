@extends('layouts.app')

@section('title', 'Edit Student — ' . $student->fullName())

@section('content')
<x-page-header
    title="Edit Student Information"
    subtitle="Updating registration record for {{ $student->fullName() }} ({{ $student->student_id }})."
>
    <x-slot:actions>
        <a href="{{ route('students.show', $student->id) }}"
           class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Cancel & View
        </a>
    </x-slot:actions>
</x-page-header>

{{-- Validation Summary --}}
@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
        <div class="flex items-center gap-2 text-red-700 font-medium text-sm mb-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            Please correct the following errors before updating:
        </div>
        <ul class="list-disc list-inside space-y-1 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="space-y-6">

        {{-- ── Section 1: Personal Information ── --}}
        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">1</span>
                    Personal Information
                </h2>
                <div>
                    <label for="status" class="text-xs font-medium text-gray-500 mr-2">Record Status:</label>
                    <select id="status" name="status"
                            class="rounded-lg border border-gray-300 px-2.5 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="active" @selected(old('status', $student->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $student->status) === 'inactive')>Inactive</option>
                        <option value="archived" @selected(old('status', $student->status) === 'archived')>Archived</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Student ID --}}
                <div class="sm:col-span-2 lg:col-span-1">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Student ID <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="student_id" name="student_id"
                           value="{{ old('student_id', $student->student_id) }}"
                           class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  {{ $errors->has('student_id') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                    <x-input-error field="student_id"/>
                </div>

                {{-- First Name --}}
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="first_name" name="first_name"
                           value="{{ old('first_name', $student->first_name) }}"
                           class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  {{ $errors->has('first_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    <x-input-error field="first_name"/>
                </div>

                {{-- Middle Name --}}
                <div>
                    <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Middle Name <span class="text-gray-400 text-xs">(optional)</span>
                    </label>
                    <input type="text" id="middle_name" name="middle_name"
                           value="{{ old('middle_name', $student->middle_name) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <x-input-error field="middle_name"/>
                </div>

                {{-- Last Name --}}
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="last_name" name="last_name"
                           value="{{ old('last_name', $student->last_name) }}"
                           class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  {{ $errors->has('last_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    <x-input-error field="last_name"/>
                </div>

                {{-- Date of Birth --}}
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
                        Date of Birth <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date_of_birth" name="date_of_birth"
                           value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}"
                           max="{{ now()->subDays(1)->format('Y-m-d') }}"
                           class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  {{ $errors->has('date_of_birth') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    <x-input-error field="date_of_birth"/>
                </div>

                {{-- Gender --}}
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">
                        Gender <span class="text-red-500">*</span>
                    </label>
                    <select id="gender" name="gender"
                            class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   {{ $errors->has('gender') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                        <option value="">Select gender</option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender }}" @selected(old('gender', $student->gender) === $gender)>{{ $gender }}</option>
                        @endforeach
                    </select>
                    <x-input-error field="gender"/>
                </div>

            </div>
        </div>

        {{-- ── Section 2: Contact Information ── --}}
        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">2</span>
                    Contact Information
                </h2>
            </div>
            <div class="px-6 py-5 grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $student->email) }}"
                           class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    <x-input-error field="email"/>
                </div>

                {{-- Mobile Number --}}
                <div>
                    <label for="mobile_number" class="block text-sm font-medium text-gray-700 mb-1">
                        Mobile Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="mobile_number" name="mobile_number"
                           value="{{ old('mobile_number', $student->mobile_number) }}"
                           class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  {{ $errors->has('mobile_number') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    <x-input-error field="mobile_number"/>
                </div>

                {{-- Address --}}
                <div class="sm:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                     {{ $errors->has('address') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('address', $student->address) }}</textarea>
                    <x-input-error field="address"/>
                </div>

            </div>
        </div>

        {{-- ── Section 3: Academic Information ── --}}
        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">3</span>
                    Academic Information
                </h2>
            </div>
            <div class="px-6 py-5 grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- Program --}}
                <div>
                    <label for="program" class="block text-sm font-medium text-gray-700 mb-1">
                        Program <span class="text-red-500">*</span>
                    </label>
                    <select id="program" name="program"
                            class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   {{ $errors->has('program') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                        <option value="">Select program</option>
                        @foreach ($programs as $prog)
                            <option value="{{ $prog }}" @selected(old('program', $student->program) === $prog)>{{ $prog }}</option>
                        @endforeach
                    </select>
                    <x-input-error field="program"/>
                </div>

                {{-- Year Level --}}
                <div>
                    <label for="year_level" class="block text-sm font-medium text-gray-700 mb-1">
                        Year Level <span class="text-red-500">*</span>
                    </label>
                    <select id="year_level" name="year_level"
                            class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   {{ $errors->has('year_level') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white' }}">
                        <option value="">Select year level</option>
                        @foreach ($yearLevels as $year)
                            <option value="{{ $year }}" @selected(old('year_level', $student->year_level) === $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                    <x-input-error field="year_level"/>
                </div>

            </div>
        </div>

        {{-- ── Section 4: Profile Picture ── --}}
        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600">4</span>
                    Profile Picture <span class="text-gray-400 text-xs font-normal">(Leave empty to keep current picture)</span>
                </h2>
            </div>
            <div class="px-6 py-5" x-data="imagePreview('{{ asset('storage/' . $student->profile_picture) }}')">
                <div class="flex flex-col items-start gap-6 sm:flex-row">

                    {{-- Preview / Current Image --}}
                    <div class="flex-shrink-0">
                        <div class="h-32 w-32 overflow-hidden rounded-xl border-2 border-indigo-100 bg-gray-50 flex items-center justify-center">
                            <img :src="previewUrl" alt="Profile preview"
                                 onerror="this.src='{{ asset('images/placeholder.png') }}'"
                                 class="h-full w-full object-cover">
                        </div>
                    </div>

                    {{-- Upload Control --}}
                    <div class="flex-1 min-w-0">
                        <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">
                            Change Photo
                        </label>
                        <label for="profile_picture"
                               class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Choose New Image
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture"
                               accept="image/png,image/jpeg,image/jpg"
                               class="sr-only"
                               @change="setPreview($event)">
                        <p x-text="fileName || 'Keeping current profile picture'" class="mt-2 text-xs text-gray-500"></p>
                        <ul class="mt-3 space-y-1 text-xs text-gray-400">
                            <li>• Accepted: JPG, JPEG, PNG (max 2MB)</li>
                            <li>• Uploading a new photo replaces the previous file securely</li>
                        </ul>
                    </div>
                </div>
                <x-input-error field="profile_picture"/>
            </div>
        </div>

        {{-- ── Actions ── --}}
        <div class="flex items-center justify-between gap-4 rounded-xl border border-gray-100 bg-white px-6 py-4 shadow-sm">
            <p class="text-xs text-gray-400"><span class="text-red-500">*</span> Required fields</p>
            <div class="flex items-center gap-3">
                <a href="{{ route('students.show', $student->id) }}"
                   class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>

    </div>
</form>

@push('scripts')
<script>
function imagePreview(initialUrl) {
    return {
        previewUrl: initialUrl,
        fileName: null,
        setPreview(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.fileName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => { this.previewUrl = e.target.result; };
            reader.readAsDataURL(file);
        }
    };
}
</script>
@endpush
@endsection

