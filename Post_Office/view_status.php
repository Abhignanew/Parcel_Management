<?php
session_start();
if ($_SESSION["usertype"] != "customer") {
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

$customer_id = $_SESSION["userid"];
$sql = "SELECT * FROM parcel WHERE sender_id='$customer_id'";

$result = $conn->query($sql);
$parcels = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $parcels[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Parcel Status</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table-container { width: 800px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        #search { margin-bottom: 15px; width: 100%; padding: 8px; }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>View Parcel Status</h2>
        <input type="text" id="search" placeholder="Search parcels...">
        <table id="parcelTable">
            <thead>
                <tr>
                    <th>Parcel ID</th>
                    <th>Receiver ID</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Weight</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parcels as $parcel) { ?>
                    <tr>
                        <td><?php echo $parcel["parcel_id"]; ?></td>
                        <td><?php echo $parcel["receiver_id"]; ?></td>
                        <td><?php echo $parcel["description"]; ?></td>
                        <td><?php echo $parcel["amount"]; ?></td>
                        <td><?php echo $parcel["weight"]; ?></td>
                        <td><?php echo $parcel["status"]; ?></td>
                        <td><?php echo $parcel["created_at"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('#parcelTable tbody tr');

            rows.forEach(function(row) {
                let showRow = false;
                row.querySelectorAll('td').forEach(function(cell) {
                    if (cell.textContent.toLowerCase().includes(searchValue)) {
                        showRow = true;
                    }
                });

                if (showRow) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
