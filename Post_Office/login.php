<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "Not_working2";
$dbname = "parcel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST["userType"];
    $cid = $_POST["cid"];
    $password = $_POST["password"];

    if ($userType == "customer") {
        $sql = "SELECT * FROM customer WHERE cid='$cid'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                $_SESSION["userid"] = $row["cid"] ?? $row["e_id"];
                $_SESSION["usertype"] = $userType;
                header("Location: view_status.php");
            } 
            else {
                echo "Invalid password";
            }
        } 
        else {
            echo "No user found with the given phone";
        }
    } 
    
    else {
        $sql = "SELECT * FROM employee WHERE e_id='$cid'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                $_SESSION["userid"] = $row["cid"] ?? $row["e_id"];
                $_SESSION["usertype"] = $userType;
                header("Location: create_parcel.php");
            } 
            else {
                echo "Invalid password";
            }
        } 
        else {
            echo "No user found with the given phone";
        }
    }

    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
    //     $row = $result->fetch_assoc();
    //     if (password_verify($password, $row["password"])) {
    //         $_SESSION["userid"] = $row["cid"] ?? $row["e_id"];
    //         $_SESSION["usertype"] = $userType;
    //         header("Location: view_status.php");
    //     } else {
    //         echo "Invalid password";
    //     }
    // } else {
    //     echo "No user found with the given phone";
    // }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            width: 300px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
        }

        input {
            width: 100%;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Login</h2>
        <form method="post">
            <div class="form-group">
                <label for="userType">Login as:</label>
                <select name="userType" required>
                    <option value="customer">Customer</option>
                    <option value="employee">Employee</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cid">User Id</label>
                <input type="text" name="cid" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>