# CS619 - Lecture Scheduler Project

<p align="center">
  <img src="vu_logo.png" alt="VU Logo" width="150" />
</p>


## Project Overview
This project is developed as part of **CS619 - Virtual University**. It is a **web-based Lecture Scheduler** that automates the scheduling of lectures based on faculty, courses, classrooms, and faculty preferences.

The main goal of the project is to provide an easy-to-use interface to manage:

- Faculty members
- Courses
- Classrooms
- Faculty lecture preferences
- Automatic generation of weekly lecture schedules

---

## Features

1. **Faculty Management**
   - Add, edit, and delete faculty members.
   - Set faculty designations and departments.

2. **Course Management**
   - Add, edit, and delete courses.
   - Manage enrollment and multimedia requirements.

3. **Classroom Management**
   - Add, edit, and delete classrooms.
   - Track capacity and multimedia availability.

4. **Faculty Preferences**
   - Faculty can select preferred days and time slots for courses.
   - Preferences are used by the automatic scheduling algorithm.

5. **Automatic Schedule Generation**
   - Automatically generates weekly lecture schedules.
   - Avoids conflicts and ensures each course is scheduled only once per day.
   - Break time is excluded automatically from scheduling.

6. **Schedule View**
   - Displays a weekly timetable with courses, faculty names, and classroom locations.
   - Easy-to-read format showing all time slots and days.

---

## Technology Stack
- **Backend:** PHP
- **Database:** MySQL (XAMPP)
- **Frontend:** HTML, CSS, JavaScript

---

## Setup Instructions

1. Install **XAMPP** or any PHP + MySQL environment.
2. Clone the project into `htdocs` (or equivalent web folder).
3. Import the `scheduler.sql` database file into MySQL:
   ```bash
   mysql -u root -p < scheduler.sql
