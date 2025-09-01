<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lecture Scheduler Dashboard</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 30px 0;
            color: #333;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 20px;
            max-width: 1000px;
            margin: auto;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            padding: 25px 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        }

        .card a {
            display: block;
            color: #007bff;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card p {
            color: #555;
            font-size: 14px;
            line-height: 1.5;
        }

        .icon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 15px;
        }
    </style>
    <!-- Use free icons (Font Awesome CDN) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Lecture Scheduler Dashboard</h1>

    <div class="dashboard">
        <div class="card">
            <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <a href="faculty.php">Manage Faculty</a>
            <p>Add, edit, or remove faculty members and assign their preferences.</p>
        </div>

        <div class="card">
            <div class="icon"><i class="fas fa-book"></i></div>
            <a href="courses.php">Manage Courses</a>
            <p>Define and manage all offered courses with codes and titles.</p>
        </div>

        <div class="card">
            <div class="icon"><i class="fas fa-school"></i></div>
            <a href="classrooms.php">Manage Classrooms</a>
            <p>Set up available classrooms, capacities, and time slots.</p>
        </div>

        <div class="card">
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
            <a href="schedule.php">Manage Schedule</a>
            <p>Generate and review the weekly lecture schedule with details.</p>
        </div>
    </div>
</body>
</html>
