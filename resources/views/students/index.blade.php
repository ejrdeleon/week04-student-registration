@extends('layouts.app')

@section('title', 'All Students')

@section('content')
<x-page-header
    title="Registered Students"
    subtitle="View, search, filter, and manage student registration records."
>
    <x-slot:actions>
        <a href="{{ route('students.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Register Student
        </a>
    </x-slot:actions>
</x-page-header>

{{-- Search & Filter Bar --}}
<div class="mb-6 rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
    <form method="GET" action="{{ route('students.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Search Input --}}
        <div>
            <label for="search" class="block text-xs font-medium text-gray-500 mb-1">Search Records</label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="search" name="search" value="{{ $search }}"
                       placeholder="Student ID, Name, Email..."
                       class="w-full rounded-lg border border-gray-300 pl-9 pr-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        {{-- Program Filter --}}
        <div>
            <label for="program" class="block text-xs font-medium text-gray-500 mb-1">Filter by Program</label>
            <select id="program" name="program" class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Programs</option>
                @foreach ($programs as $prog)
                    <option value="{{ $prog }}" @selected($program === $prog)>{{ $prog }}</option>
                @endforeach
            </select>
        </div>

        {{-- Year Level Filter --}}
        <div>
            <label for="year_level" class="block text-xs font-medium text-gray-500 mb-1">Filter by Year Level</label>
            <select id="year_level" name="year_level" class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Year Levels</option>
                @foreach ($yearLevels as $year)
                    <option value="{{ $year }}" @selected($yearLevel === $year)>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter & Reset Actions --}}
        <div class="flex items-end gap-2">
            <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-gray-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-gray-800 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
            </button>
            @if ($search || $program || $yearLevel || ($status && $status !== 'active'))
                <a href="{{ route('students.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Students Table / Empty State --}}
<div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
    @if ($students->isEmpty())
        <x-empty-state
            title="No students found"
            description="{{ $search || $program || $yearLevel ? 'No registration records matched your active search or filter criteria.' : 'No students have been registered yet. Start by registering the first student.' }}"
            actionLabel="Register Student"
            actionRoute="{{ route('students.create') }}"
        />
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="border-b border-gray-100 bg-gray-50/75 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">Student</th>
                        <th scope="col" class="px-6 py-3.5">Program & Year</th>
                        <th scope="col" class="px-6 py-3.5">Contact</th>
                        <th scope="col" class="px-6 py-3.5">Status</th>
                        <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($students as $student)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            {{-- Student Profile & ID --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $student->profile_picture) }}"
                                         alt="{{ $student->fullName() }}"
                                         onerror="this.src='{{ asset('images/placeholder.png') }}'"
                                         class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                    <div>
                                        <a href="{{ route('students.show', $student->id) }}" class="font-medium text-gray-900 hover:text-indigo-600 transition-colors">
                                            {{ $student->fullName() }}
                                        </a>
                                        <p class="text-xs text-gray-400 font-mono">{{ $student->student_id }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Program & Year Level --}}
                            <td class="px-6 py-4">
                                <p class="text-gray-900 font-medium">{{ $student->program }}</p>
                                <p class="text-xs text-gray-500">{{ $student->year_level }}</p>
                            </td>

                            {{-- Contact --}}
                            <td class="px-6 py-4">
                                <p class="text-gray-900">{{ $student->email }}</p>
                                <p class="text-xs text-gray-500">{{ $student->mobile_number }}</p>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4">
                                <x-status-badge :status="$student->status" />
                            </td>

                            {{-- Action Links --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('students.show', $student->id) }}"
                                       class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 hover:bg-indigo-100 transition-colors">
                                        View
                                    </a>
                                    <a href="{{ route('students.edit', $student->id) }}"
                                       class="inline-flex items-center gap-1 rounded-md bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                                        Edit
                                    </a>
                                    @if ($student->status !== 'archived')
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to archive student {{ $student->fullName() }}?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 hover:bg-red-100 transition-colors">
                                                Archive
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($students->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $students->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
