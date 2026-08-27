# Student Registration Flowchart

## Workflow Overview

This diagram represents the step-by-step registration workflow required by the Week 4 Laboratory Activity.

```mermaid
flowchart TD
    Start([User Visits Registration Page]) --> ViewForm[Display Registration Form GET /students/create]
    ViewForm --> FillForm[User Inputs Personal, Contact, Academic Info & Selects Profile Picture]
    FillForm --> JSPreview[Client-Side Image Preview via FileReader API]
    JSPreview --> Submit[Submit POST /students]

    Submit --> Route[routes/web.php routes to StudentController@store]
    Route --> FormReq[StoreStudentRequest Form Validation]

    FormReq --> IsValid{Is Input Valid?}

    IsValid -- No --> ValidationFail[Redirect back with Input & Errors]
    ValidationFail --> DisplayErrors[Display Inline Field Errors & Summary Alert]
    DisplayErrors --> FillForm

    IsValid -- Yes --> SaveImage[Store Image in storage/app/public/profile_pictures]
    SaveImage --> SaveDB[Insert Student Record in MySQL students Table with File Path]
    SaveDB --> FlashSuccess[Flash Success Session Message]
    FlashSuccess --> RedirectShow[Redirect to GET /students/{id}]
    RedirectShow --> ViewProfile[Display Student Profile with Uploaded Picture from Storage]
    ViewProfile --> End([Registration Complete])
```

## Process Steps Explained

1. **User Opens Registration Page**: Navigates to `/students/create`.
2. **Form Interaction & Image Preview**: The student fills out all mandatory fields. Selecting a photo immediately displays a client-side preview via JavaScript FileReader without uploading early.
3. **Form Submission**: Form submitted via `POST /students` with `multipart/form-data` and CSRF token.
4. **Validation via `StoreStudentRequest`**: Validates mandatory constraints, format (email, date of birth, phone), uniqueness (`student_id`, `email`), and file constraints (image type JPG/JPEG/PNG, max 2048 KB).
5. **Storage & Database Persistence**: On validation success, image is stored to `storage/app/public/profile_pictures`. Only the relative storage path is written to MySQL `students` table.
6. **Flash Message & Profile View**: User is redirected with a success flash message to the new student's profile page where their details and photo are rendered via `asset('storage/...')`.
