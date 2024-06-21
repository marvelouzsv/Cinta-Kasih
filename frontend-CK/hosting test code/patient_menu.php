<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit;
}

include 'connection.php';

// Fetch doctors
$sql = "SELECT d.*, s.keterangan, s.jam 
        FROM doctor d 
        LEFT JOIN shift_schedule s ON d.shift_id = s.id";
$doctors = $conn->query($sql);
if (!$doctors) {
    die("Error fetching doctors: " . $conn->error);
}

// Fetch shift schedules
$sql = "SELECT * FROM shift_schedule";
$shiftsResult = $conn->query($sql);
if (!$shiftsResult) {
    die("Error fetching shifts: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Menu</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #5C8374, #9EC8B9); /* Warna latar belakang */
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
        color: #527853; /* Warna teks utama */
        margin-bottom: 20px;
        text-align: center;
    }

    h3 {
        color: #5F8670; /* Warna teks sekunder */
        margin-top: 20px;
        margin-bottom: 10px;
    }

    a {
        color: #5C8374; /* Warna link */
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
        background-color: #527853; /* Warna header tabel */
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .form-group {
        margin-bottom: 15px;
    }

    select, input[type="date"], button {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        background-color: #5C8374; /* Warna tombol */
        color: #fff;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background-color: #527853; /* Warna tombol saat dihover */
    }
</style>

</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></h2>
        <a href="logout.php">Logout</a>

        <h3>Doctors' Schedules</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Shift</th>
            </tr>
            <?php while($row = $doctors->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['keterangan']) . ' (' . htmlspecialchars($row['jam']) . ')'; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

      

        <h3>Make an Appointment</h3>
        <form action="process_appointment.php" method="post">
            <div class="form-group">
                <label for="doctor_id">Select Doctor:</label>
                <select name="doctor_id" id="doctor_id">
                    <?php 
                    $doctors->data_seek(0); // Reset the pointer back to the start
                    while($row = $doctors->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="schedule">Schedule:</label>
                <input type="date" name="schedule" id="schedule" required>
            </div>
            
            <button type="submit">Submit</button>
        </form>
    </div>
    
</body>
</html>
