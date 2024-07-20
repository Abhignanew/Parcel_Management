<?php
session_start();
if ($_SESSION["usertype"] != "employee") {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "Not_working2";
$dbname = "parcel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parcel_id = $_POST["parcel_id"];
    $status = $_POST["status"];

    $sql = "UPDATE parcel SET status='$status' WHERE parcel_id='$parcel_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Status updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Parcel Status</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .form-container { width: 300px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; }
        input, select { width: 100%; padding: 8px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Update Parcel Status</h2>
        <form method="post">
            <div class="form-group">
                <label for="parcel_id">Parcel ID:</label>
                <input type="text" name="parcel_id" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Dispatched">Dispatched</option>
                    <option value="Interval Station">Interval Station</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </div>
            <button type="submit">Update Status</button>
        </form>
    </div>
</body>
</html>
