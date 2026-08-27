# Laravel Request Lifecycle in Student Registration

## Request Flow Diagram

This diagram shows how a form submission travels from the browser through Laravel to save a student record and display their profile.

```mermaid
sequenceDiagram
    autonumber
    actor Student as User / Web Browser
    participant Public as public/index.php
    participant Kernel as HTTP Kernel & Middleware
    participant Router as routes/web.php
    participant FormReq as StoreStudentRequest
    participant Controller as StudentController@store
    participant Storage as Laravel Storage (public disk)
    participant Model as Student Model (Eloquent)
    participant Database as MySQL Database
    participant Session as Session Flash Message

    Student->>Public: POST /students (form inputs + photo + CSRF token)
    Public->>Kernel: Bootstraps framework and session
    Kernel->>Router: Matches route to StudentController@store
    Router->>FormReq: Validates input fields and uploaded photo

    alt If Validation Fails
        FormReq-->>Student: Redirects back with errors and old() inputs
    else If Validation Passes
        FormReq->>Controller: Sends clean validated data
        Controller->>Storage: Uploads image to storage/app/public/profile_pictures
        Storage-->>Controller: Returns relative image path
        Controller->>Model: Calls Student::create() with student data and image path
        Model->>Database: INSERT INTO students table
        Database-->>Model: Saves record and returns new ID
        Controller->>Session: Flashes success message
        Controller-->>Student: Redirects to GET /students/{id}
    end

    Student->>Router: GET /students/{id}
    Router->>Controller: Calls StudentController@show()
    Controller->>Model: Finds student by ID
    Model->>Database: SELECT * FROM students WHERE id = ?
    Database-->>Model: Returns student record
    Controller-->>Student: Displays student details and photo (show.blade.php)
```

## How It Works in Simple Steps:

1. **Form Submission**: The user fills in the registration form at `/students/create` and uploads a profile image. When clicking submit, the browser sends a `POST` request to `/students` along with the `@csrf` token for security.
2. **Middleware & Routing**: Laravel verifies the CSRF token and route matching in `routes/web.php`.
3. **Form Request Validation**: `StoreStudentRequest` checks that all required fields are filled, checks uniqueness of the Student ID and email in MySQL, and verifies that the uploaded file is a valid image under 2MB.
4. **File Storage**: The controller stores the photo in `storage/app/public/profile_pictures` and receives a relative path (e.g., `profile_pictures/abcdef1234.jpg`).
5. **Database Insert**: Eloquent ORM inserts the student record into MySQL.
6. **Session & Redirect**: A success flash message is saved in session, and the user is redirected to `/students/{id}` where the profile view renders their details and photo.
