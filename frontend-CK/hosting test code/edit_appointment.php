<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'connection.php';

if (!isset($_GET['id'])) {
    echo "No appointment ID specified.";
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM appointment WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $appointment = $result->fetch_assoc();
} else {
    echo "No appointment found with ID $id";
    exit;
}

$sql = "SELECT * FROM doctor";
$doctors = $conn->query($sql);

$sql = "SELECT * FROM patient";
$patients = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h2 {
            color: #5C8374;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form input,
        form select,
        form button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form button {
            background-color: #5C8374;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #527853;
        }
    </style>
    <script>
        function showSuccessAlert() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status') && urlParams.get('status') === 'success') {
                alert('Appointment updated successfully!');
            }
        }
    </script>
</head>
<body onload="showSuccessAlert()">
    <h2>Edit Appointment</h2>
    <form action="update_appointment.php" method="post">
        <input type="hidden" name="id" value="<?php echo $appointment['id']; ?>">
        <label for="id_patient">Patient:</label>
        <select name="id_patient" id="id_patient">
            <?php while($row = $patients->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $appointment['id_patient']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($row['name']); ?>
            </option>
            <?php endwhile; ?>
        </select><br>
        <label for="id_doctor">Doctor:</label>
        <select name="id_doctor" id="id_doctor">
            <?php while($row = $doctors->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $appointment['id_doctor']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($row['name']); ?>
            </option>
            <?php endwhile; ?>
        </select><br>
        <label for="schedule">Schedule:</label>
        <input type="date" name="schedule" id="schedule" value="<?php echo $appointment['schedule']; ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
