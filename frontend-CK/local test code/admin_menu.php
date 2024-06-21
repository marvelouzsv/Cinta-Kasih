<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'connection.php';

// Fetch appointments with doctor and shift information
$sql = "SELECT a.id, a.schedule, p.name as patient_name, d.name as doctor_name, s.keterangan, s.jam
        FROM appointment a
        LEFT JOIN patient p ON a.id_patient = p.id
        LEFT JOIN doctor d ON a.id_doctor = d.id
        LEFT JOIN shift_schedule s ON d.shift_id = s.id";
$appointments = $conn->query($sql);
if (!$appointments) {
    die("Error fetching appointments: " . $conn->error);
}

// Fetch doctors with their shifts
$sql = "SELECT d.*, s.keterangan, s.jam 
        FROM doctor d 
        LEFT JOIN shift_schedule s ON d.shift_id = s.id";
$doctorsResult = $conn->query($sql);
if (!$doctorsResult) {
    die("Error fetching doctors: " . $conn->error);
}

// Fetch patients
$sql = "SELECT * FROM patient";
$patientsResult = $conn->query($sql);
if (!$patientsResult) {
    die("Error fetching patients: " . $conn->error);
}

// Fetch shift schedules
$sql = "SELECT * FROM shift_schedule";
$shiftsResult = $conn->query($sql);
if (!$shiftsResult) {
    die("Error fetching shifts: " . $conn->error);
}

// Create maps for doctors and patients
$doctorMap = [];
$patientMap = [];

$doctors = [];
while ($doctor = $doctorsResult->fetch_assoc()) {
    $doctorMap[$doctor['id']] = $doctor['name'];
    $doctors[] = $doctor; // Store doctor data in an array for reuse
}

while ($patient = $patientsResult->fetch_assoc()) {
    $patientMap[$patient['id']] = $patient['name'];
}

// Create shift map
$shiftMap = [];
while ($shift = $shiftsResult->fetch_assoc()) {
    $shiftMap[$shift['id']] = $shift['keterangan'] . ' (' . $shift['jam'] . ')';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Menu</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #5C8374, #9EC8B9);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1000px;
        }

        h2 {
            color: #5F8670;
            margin-bottom: 20px;
            text-align: center;
        }

        h3 {
            color: #527853;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        a {
            color: #5C8374;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #9EC8B9;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-links {
            display: flex;
            gap: 10px;
        }

        .action-links a {
            background: #5C8374;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .action-links a:hover {
            background: #527853;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, Admin</h2>
        <a href="logout.php">Logout</a>

        <h3>Appointments</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Shift</th>
                <th>Schedule</th>
                <th>Action</th>
            </tr>
            <?php while($row = $appointments->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                <td><?php echo htmlspecialchars($row['keterangan']) . ' (' . htmlspecialchars($row['jam']) . ')'; ?></td>
                <td><?php echo htmlspecialchars($row['schedule']); ?></td>
                <td class="action-links">
                    <a href="edit_appointment.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="delete_appointment.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h3>Doctors</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Shift</th>
                <th>Patients</th>
            </tr>
            <?php
            $doctorsResult->data_seek(0); // Reset the pointer back to the start
            while($row = $doctorsResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['keterangan']) . ' (' . htmlspecialchars($row['jam']) . ')'; ?></td>
                <td><?php echo htmlspecialchars($row['patient']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
