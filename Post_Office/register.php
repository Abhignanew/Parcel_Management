<?php
$servername = "localhost";
$username = "root";
$password = "Not_working2";
$dbname = "parcel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $pno = $_POST["pno"];
    $userType = $_POST["userType"];

    if ($userType == "customer") {
        $sql = "INSERT INTO customer (cname, cphone, caddress, pno, password) VALUES ('$name', '$phone', '$address', '$pno', '$password')";
    } else {
        $sql = "INSERT INTO employee (ename, password, pno) VALUES ('$name', '$password', '$pno')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .form-container { width: 300px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; }
        input { width: 100%; padding: 8px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form method="post">
            <div class="form-group">
                <label for="userType">Register as:</label>
                <select name="userType" required>
                    <option value="customer">Customer</option>
                    <option value="employee">Employee</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" required>
            </div>
            <div class="form-group">
                <label for="pno">Post Office Number:</label>
                <input type="text" name="pno" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
