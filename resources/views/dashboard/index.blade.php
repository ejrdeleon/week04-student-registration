@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<x-page-header
    title="System Dashboard"
    subtitle="Overview of student registrations, enrollment distribution, and recent activity."
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

{{-- ── Stat Cards ── --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">

    {{-- Total Students --}}
    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Enrolled</span>
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-2xl font-bold text-gray-900">{{ number_format($totalStudents) }}</p>
        <p class="mt-1 text-xs text-gray-400">All registered active & inactive records</p>
    </div>

    {{-- Active Students --}}
    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active Students</span>
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-2xl font-bold text-gray-900">{{ number_format($activeStudents) }}</p>
        <p class="mt-1 text-xs text-emerald-600 font-medium">Currently active status</p>
    </div>

    {{-- New This Month --}}
    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">New This Month</span>
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-2xl font-bold text-gray-900">{{ number_format($newThisMonth) }}</p>
        <p class="mt-1 text-xs text-gray-400">Registered in {{ now()->format('F Y') }}</p>
    </div>

    {{-- Programs Offered --}}
    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Programs Represented</span>
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-2xl font-bold text-gray-900">{{ count($byProgram) }}</p>
        <p class="mt-1 text-xs text-gray-400">Academic degree programs</p>
    </div>

</div>

{{-- ── Distribution Breakdown Section ── --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-8">

    {{-- Program Breakdown --}}
    <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
            Program Enrollment
        </h3>
        @if ($byProgram->isEmpty())
            <p class="text-xs text-gray-400 text-center py-8">No registration data yet.</p>
        @else
            <div class="space-y-3.5">
                @foreach ($byProgram as $item)
                    @php
                        $percentage = $totalStudents > 0 ? round(($item->total / $totalStudents) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-medium text-gray-700 truncate max-w-[240px]">{{ $item->program }}</span>
                            <span class="text-gray-500 font-mono">{{ $item->total }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                            <div class="h-full rounded-full bg-indigo-600" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Year Level Breakdown --}}
    <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Year Level Distribution
        </h3>
        @if ($byYearLevel->isEmpty())
            <p class="text-xs text-gray-400 text-center py-8">No year level data yet.</p>
        @else
            <div class="space-y-3.5">
                @foreach ($byYearLevel as $item)
                    @php
                        $percentage = $totalStudents > 0 ? round(($item->total / $totalStudents) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-medium text-gray-700">{{ $item->year_level }}</span>
                            <span class="text-gray-500 font-mono">{{ $item->total }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                            <div class="h-full rounded-full bg-indigo-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

{{-- ── Recent Registrations Table ── --}}
<div class="rounded-xl border border-gray-100 bg-white shadow-sm overflow-hidden">
    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
        <h3 class="text-base font-semibold text-gray-900">Recent Registrations</h3>
        <a href="{{ route('students.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
            View All Students →
        </a>
    </div>
    @if ($recentStudents->isEmpty())
        <div class="p-8 text-center text-sm text-gray-500">
            No students registered yet. <a href="{{ route('students.create') }}" class="text-indigo-600 underline">Register the first student</a>.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="border-b border-gray-100 bg-gray-50/75 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th scope="col" class="px-6 py-3">Student</th>
                        <th scope="col" class="px-6 py-3">Program</th>
                        <th scope="col" class="px-6 py-3">Year Level</th>
                        <th scope="col" class="px-6 py-3">Registered</th>
                        <th scope="col" class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($recentStudents as $student)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $student->profile_picture) }}"
                                         alt="{{ $student->fullName() }}"
                                         onerror="this.src='{{ asset('images/placeholder.png') }}'"
                                         class="h-8 w-8 rounded-full object-cover border border-gray-200">
                                    <div>
                                        <p class="font-medium text-gray-900 text-xs">{{ $student->fullName() }}</p>
                                        <p class="font-mono text-[11px] text-gray-400">{{ $student->student_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-xs text-gray-700">{{ $student->program }}</td>
                            <td class="px-6 py-3.5 text-xs text-gray-500">{{ $student->year_level }}</td>
                            <td class="px-6 py-3.5 text-xs text-gray-400">{{ $student->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('students.show', $student->id) }}"
                                   class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                    View Profile →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

