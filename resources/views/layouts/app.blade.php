<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Student Registration System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-indigo-700 text-white px-6 py-4 flex justify-between">
        <a href="{{ route('students.index') }}" class="font-bold text-lg">Student Registration System</a>
        <a href="{{ route('students.create') }}" class="hover:underline">Register New Student</a>
    </nav>

    <main class="max-w-3xl mx-auto py-10 px-4">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
