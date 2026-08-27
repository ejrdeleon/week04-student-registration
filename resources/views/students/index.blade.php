@extends('layouts.app')

@section('title', 'Registered Students')

@section('content')
<div class="bg-white shadow rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-6 text-indigo-700">Registered Students</h1>

    @if ($students->isEmpty())
        <p class="text-gray-500">No students registered yet. <a href="{{ route('students.create') }}" class="text-indigo-700 underline">Register one now</a>.</p>
    @else
        <table class="w-full text-sm text-left">
            <thead class="border-b font-medium text-gray-500">
                <tr>
                    <th class="py-2">Student ID</th>
                    <th>Name</th>
                    <th>Program</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr class="border-b">
                        <td class="py-2">{{ $student->student_id }}</td>
                        <td>{{ $student->fullName() }}</td>
                        <td>{{ $student->program }}</td>
                        <td><a href="{{ route('students.show', $student->id) }}" class="text-indigo-700 underline">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
