# Student Registration System — ITST 302 Week 4

## 1. Introduction
_(Explain the purpose of a student registration system, why validation matters, and where registration systems fit in enterprise apps.)_

## 2. Objectives
- Built Blade registration forms
- Implemented server-side validation
- Displayed flash messages
- Uploaded files via Laravel Storage
- Designed a relational students table
- Practiced Git + portfolio documentation

## 3. Laravel Request Lifecycle
Browser → Route (`web.php`) → Controller (`StudentController@store`) → Validation (`$request->validate()`) → Model (`Student::create()`) → Database (MySQL `students` table) → Response (redirect + flash message).

_(Insert your lifecycle diagram here.)_

## 4. Validation Rules
| Field | Rule | Why |
|---|---|---|
| student_id | required, unique | Prevent duplicate enrollment records |
| email | required, email, unique | Guarantees a valid, one-per-student contact channel |
| mobile_number | required, numeric | Blocks non-numeric junk input |
| profile_picture | required, image, mimes:jpg,jpeg,png, max:2048 | Restricts uploads to safe image types under 2MB |

## 5. Database Design
_(Insert ERD + table structure here.)_

## 6. Flowchart
_(Insert registration flowchart here.)_

## 7. Screenshots
_(Insert screenshots from `screenshots/` here.)_

## 8. Problems Encountered & Solutions
1. ...
2. ...
3. ...

## 9. Reflection
_(500-word reflection here.)_

## 10. References
- Laravel Documentation. (2026). https://laravel.com/docs
- PHP Documentation. (2026). https://www.php.net/docs.php
- MySQL Documentation. (2026). https://dev.mysql.com/doc/
- Tailwind CSS Documentation. (2026). https://tailwindcss.com/docs
- MDN Web Docs. (2026). https://developer.mozilla.org/
