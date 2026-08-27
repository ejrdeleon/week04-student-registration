# Database Entity-Relationship Diagram (ERD)

## Database Overview

The Student Registration System uses MySQL database storage with a primary `students` table to store student profile information and the relative paths of uploaded profile images.

```mermaid
erDiagram
    STUDENTS {
        bigint id PK "Auto Increment Primary Key"
        string student_id UK "Unique Student ID (e.g. 2026-00001)"
        string first_name "First Name"
        string middle_name "Middle Name (Nullable)"
        string last_name "Last Name"
        string email UK "Unique Email Address"
        string mobile_number "Contact Number"
        enum gender "Male, Female, Other"
        date date_of_birth "Birth Date"
        string program "Enrolled Program (e.g. BSIT)"
        string year_level "1st Year, 2nd Year, 3rd Year, 4th Year"
        text address "Residential Address"
        string profile_picture "Relative path in storage/app/public"
        enum status "active, inactive, archived"
        timestamp created_at "Registration Timestamp"
        timestamp updated_at "Last Update Timestamp"
    }

    USERS {
        bigint id PK "Primary Key"
        string name "User Name"
        string email UK "User Email"
        timestamp email_verified_at "Nullable"
        string password "Hashed Password"
        string remember_token "Nullable"
        timestamp created_at "Timestamp"
        timestamp updated_at "Timestamp"
    }
```

## `students` Table Columns

| Column            | Data Type                            | Constraints                 | Description                                      |
| ----------------- | ------------------------------------ | --------------------------- | ------------------------------------------------ |
| `id`              | BIGINT UNSIGNED                      | PRIMARY KEY, AUTO_INCREMENT | Auto-incrementing record ID                      |
| `student_id`      | VARCHAR(20)                          | UNIQUE, NOT NULL            | Student ID number (must be unique)               |
| `first_name`      | VARCHAR(100)                         | NOT NULL                    | Given first name                                 |
| `middle_name`     | VARCHAR(100)                         | NULLABLE                    | Optional middle name or initial                  |
| `last_name`       | VARCHAR(100)                         | NOT NULL                    | Family name / surname                            |
| `email`           | VARCHAR(255)                         | UNIQUE, NOT NULL            | Student email address (must be unique)           |
| `mobile_number`   | VARCHAR(20)                          | NOT NULL                    | Contact telephone / mobile number                |
| `gender`          | ENUM('Male','Female','Other')        | NOT NULL                    | Selected gender                                  |
| `date_of_birth`   | DATE                                 | NOT NULL                    | Date of birth                                    |
| `program`         | VARCHAR(100)                         | NOT NULL                    | Degree program (e.g., BS Information Technology) |
| `year_level`      | VARCHAR(20)                          | NOT NULL                    | Academic year (e.g., 3rd Year)                   |
| `address`         | TEXT                                 | NOT NULL                    | Complete home address                            |
| `profile_picture` | VARCHAR(255)                         | NOT NULL                    | Path inside `storage/app/public` disk            |
| `status`          | ENUM('active','inactive','archived') | DEFAULT 'active'            | Student record status                            |
| `created_at`      | TIMESTAMP                            | NULLABLE                    | Timestamp when record was created                |
| `updated_at`      | TIMESTAMP                            | NULLABLE                    | Timestamp when record was last updated           |
