<?php
session_start();
include('../auth/auth.php');
checkAuth(); // Cek apakah admin sudah login
include('../config/db.php'); // Koneksi ke database

// Menghitung total vendor
$stmt = $conn->query("SELECT COUNT(*) AS total_vendor FROM vendor");
$total_vendor = $stmt->fetchColumn();

// Menghitung total inventory
$stmt = $conn->query("SELECT COUNT(*) AS total_inventory FROM inventory");
$total_inventory = $stmt->fetchColumn();

// Menghitung total storage unit
$stmt = $conn->query("SELECT COUNT(*) AS total_storage_unit FROM storage_unit");
$total_storage_unit = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Dashboard</title>
</head>
<body>
<?php
include('../partials/header.php'); // Memanggil header
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('../partials/sidebar.php'); // Memanggil sidebar ?>
        </div>
        <div class="col-md-9">
            <h1 class="mt-4">Dashboard</h1>
            <p>Welcome to the admin panel!</p>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Total Vendors</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $total_vendor; ?></h5>
                            <a href="vendor_list.php" class="btn btn-light">Manage Vendors</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Total Inventory Items</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $total_inventory; ?></h5>
                            <a href="inventory_list.php" class="btn btn-light">Manage Inventory</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">Total Storage Units</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $total_storage_unit; ?></h5>
                            <a href="storage_unit_list.php" class="btn btn-light">Manage Storage Units</a>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>

<?php include('../partials/footer.php'); // Memanggil footer ?>
</body>
</html>
