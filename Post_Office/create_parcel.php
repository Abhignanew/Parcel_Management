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
    $sender_id = $_POST["sender_id"];
    $receiver_id = $_POST["receiver_id"];
    $description = $_POST["description"];
    $amount = $_POST["amount"];
    $weight = $_POST["weight"];
    $status = "Dispatched";

    $e_id = $_SESSION["userid"];
    $sql = "INSERT INTO parcel (sender_id, receiver_id, e_id, description, amount, weight, status) VALUES ('$sender_id', '$receiver_id', '$e_id', '$description', '$amount', '$weight', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Parcel created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Parcel</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .form-container { width: 300px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; }
        input, textarea { width: 100%; padding: 8px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Create Parcel</h2>
        <form method="post">
            <div class="form-group">
                <label for="sender_id">Sender ID:</label>
                <input type="text" name="sender_id" required>
            </div>
            <div class="form-group">
                <label for="receiver_id">Receiver ID:</label>
                <input type="text" name="receiver_id" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" name="amount" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" name="weight" required>
            </div>
            <button type="submit">Create Parcel</button>
        </form>
    </div>
</body>
</html>
