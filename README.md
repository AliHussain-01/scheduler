# CS619 - Lecture Scheduler Project

<p align="center">
  <img src="assets/VU_Logo.png" alt="VU Logo" width="180" />
</p>

---

## 📖 Overview

The **Lecture Scheduler** is a web-based application developed as part of **CS619 (Virtual University of Pakistan)**.

It provides a complete solution for managing **faculty, courses, classrooms, and lecture schedules**. The system automatically generates a **conflict-free weekly timetable**, respecting faculty preferences and classroom availability.

This project eliminates the manual effort of timetable management and ensures **fair distribution of slots**, efficient resource utilization, and an **organized schedule for faculty and students**.

---

## Key Features

### 1. 👨 Faculty Management

* Add, edit, and delete faculty members.
* Manage departments and designations (Professor, Associate Professor, etc.).
* Faculty profiles stored in a structured database.

### 2. 📘 Course Management

* Add new courses with:

  * Course Code
  * Course Title
  * Enrollment strength
  * Multimedia requirements
* Edit or delete existing courses easily.

### 3. ✍🏻 Classroom Management

* Add, edit, and delete classrooms.
* Track seating capacity.
* Identify multimedia-enabled classrooms for specialized courses.

### 4. 📅 Faculty Preferences

* Faculty can specify preferred **days** and **time slots**.
* The scheduler prioritizes these preferences while generating timetables.

### 5. ⏱️ Automatic Schedule Generation

* Generates a **weekly lecture schedule** automatically.
* Ensures:

  * No faculty is double-booked.
  * Courses are scheduled only once per day.
  * Classroom conflicts are avoided.
  * Break times are excluded.
* Algorithm balances fairness and resource efficiency.

### 6. 🗓️ Schedule Viewer

* Displays the **weekly timetable** in a clean, tabular layout.
* Shows:

  * Course Code & Title
  * Faculty Name
  * Classroom ID
  * Time Slot
* Color-coded rows for better readability.

---

## 🛠️ Technology Stack

* **Backend:** PHP (Core PHP, no framework)
* **Database:** MySQL (via XAMPP / MariaDB)
* **Frontend:** HTML, CSS, JavaScript
* **Environment:** XAMPP (Apache + MySQL)

---

### Dashboard

<p align="center">
  <img src="assets/screenshots/dashboard.PNG" alt="Dashboard Screenshot" width="700"/>
</p>

---

### Faculty Management

* Add, edit, and delete faculty members.
* Manage departments and designations (Professor, Associate Professor, etc.).

<p align="center">
  <img src="assets/screenshots/faculty1.PNG" alt="Manage Faculty Screenshot 1" width="500"/>
  <img src="assets/screenshots/faculty2.PNG" alt="Manage Faculty Screenshot 2" width="500"/>
</p>

---

### Course Management

* Add new courses with code, title, enrollment, multimedia requirements.
* Edit or delete existing courses.

<p align="center">
  <img src="assets/screenshots/courses.PNG" alt="Manage Courses Screenshot" width="600"/>
</p>

---

### Classroom Management

* Add new classrooms, Labs with ID, Name, Capacity, multimedia available.
* Edit or delete existing Classroom.

<p align="center">
  <img src="assets/screenshots/classrooms.PNG" alt="Manage Classroom Screenshot" width="600"/>
</p>

---

### Schedule Management

<p align="center">
  <img src="assets/screenshots/schedule.PNG" alt="Schedule Screenshot" width="700"/>
</p>

---

## ❗ Setup Instructions

Follow these steps to set up the project locally:

1. **Install Prerequisites**

   * Download and install [XAMPP](https://www.apachefriends.org/download.html) (or any PHP + MySQL stack).

2. **Clone the Repository**
   Place the project folder inside the `htdocs` directory (for XAMPP).
   Example:

   ```bash
   C:\xampp\htdocs\scheduler
   ```

3. **Database Setup**

   * Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
   * Create a database named `scheduler`.
   * Import the provided SQL file:

     ```bash
     mysql -u root -p scheduler < scheduler.sql
     ```

4. **Run the Project**
   Start Apache & MySQL in the XAMPP Control Panel.
   Open your browser and visit:

   ```
   http://localhost/scheduler
   ```

---

## 📂 Project Structure

```
scheduler/
├── assets/          # CSS, JavaScript, and media files
│       ├── style.css
│       ├── script.js
│       ├── VU_Logo.png
├── database/        # mySQL database
│       ├── scheduler.sql
├── config.php       # Database connection settings
├── functions.php    # Core helper functions
├── index.php        # Dashboard
├── faculty.php      # Faculty management
├── courses.php      # Course management
├── classrooms.php   # Classroom management
├── editFaculty.php      
├── editCourses.php      
├── editClassrooms.php   
└── schedule.php     # Weekly timetable view + auto scheduler
```


## 👤 Authors

Developed as part of **CS619 - Final Year Project** at **Virtual University of Pakistan**.

---

