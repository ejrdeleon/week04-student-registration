# Laravel Request Lifecycle in Student Registration

## Architectural Diagram

This diagram traces an incoming HTTP POST request for student registration from the browser through Laravel's core architecture to response delivery.

```mermaid
sequenceDiagram
    autonumber
    actor User as Client / Web Browser
    participant Public as public/index.php
    participant Kernel as HTTP Kernel & Middleware (CSRF)
    participant Router as routes/web.php
    participant FormReq as StoreStudentRequest (Validator)
    participant Ctrl as StudentController@store
    participant Storage as Laravel Storage (public disk)
    participant Model as Student Eloquent Model
    participant DB as MySQL Database
    participant Session as Session (Flash Message)

    User->>Public: POST /students (form data + image file + CSRF token)
    Public->>Kernel: Bootstraps framework & loads service providers
    Kernel->>Kernel: VerifyCsrfToken & StartSession middleware
    Kernel->>Router: Route matching -> StudentController@store
    Router->>FormReq: Resolve & Execute StoreStudentRequest

    alt Validation Fails
        FormReq-->>User: 302 Redirect Back with Session Errors & old() Input
    else Validation Passes
        FormReq->>Ctrl: Passes validated payload
        Ctrl->>Storage: $file->store('profile_pictures', 'public')
        Storage-->>Ctrl: Returns relative path ('profile_pictures/hash.jpg')
        Ctrl->>Model: Student::create($validatedWithPhotoPath)
        Model->>DB: INSERT INTO students (...) VALUES (...)
        DB-->>Model: Auto-incremented student record ID
        Ctrl->>Session: session()->flash('success', 'Student registered successfully!')
        Ctrl-->>User: 302 Redirect to GET /students/{id}
    end

    User->>Router: GET /students/{id}
    Router->>Ctrl: StudentController@show(Student $student)
    Ctrl->>Model: Implicit Route Model Binding (find student by ID)
    Model->>DB: SELECT * FROM students WHERE id = ? LIMIT 1
    DB-->>Model: Student record
    Ctrl-->>User: 200 OK HTML (resources/views/students/show.blade.php)
```

## Key Architectural Stages

1. **Entry Point (`public/index.php`)**: Accepts all web traffic, loads Composer autoloader, and retrieves the Laravel application instance from `bootstrap/app.php`.
2. **HTTP Middleware Pipeline**: Validates the CSRF token (`@csrf`), initializes session state, and checks incoming headers.
3. **Routing (`routes/web.php`)**: Matches `POST /students` to `StudentController@store`.
4. **Form Request Validation (`StoreStudentRequest`)**: Automatically injected before the controller action executes. Verifies required fields, unique constraints against MySQL, and image rules. If invalid, generates an immediate `ValidationException` redirecting with error bags.
5. **Secure Storage Handling (`Storage::disk('public')`)**: Laravel hashes the image name to prevent file collisions or directory traversal attacks, storing the binary under `storage/app/public/profile_pictures`.
6. **Eloquent ORM Persistence (`Student::create()`)**: Inserts the sanitized fields and file path into the MySQL `students` table.
7. **Flash Session & Redirect**: Flashes a success alert into session memory and redirects to the newly registered student's profile page.
