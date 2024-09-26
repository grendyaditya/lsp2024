<?php
session_start();
include('../auth/auth.php');
checkAuth();
include('../config/db.php');

// Proses hapus storage unit
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM storage_unit WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $message = "Storage Unit deleted successfully!";
}

// Ambil daftar storage unit
$stmt = $conn->query("SELECT * FROM storage_unit");
$storage_units = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Storage Unit List</title>
</head>
<body>

<?php include('../partials/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('../partials/sidebar.php'); ?>
        </div>
        <div class="col-md-9">
            <h1 class="mt-4">Storage Unit List</h1>

            <?php if (isset($message)): ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Storage Units</h5>
                    <a href="add_storage_unit.php" class="btn btn-primary float-right">Add Storage Unit</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Gudang</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($storage_units as $storage_unit): ?>
                                <tr>
                                    <td><?php echo $storage_unit['id']; ?></td>
                                    <td><?php echo $storage_unit['nama_gudang']; ?></td>
                                    <td><?php echo $storage_unit['lokasi']; ?></td>
                                    <td>
                                        <a href="edit_storage_unit.php?id=<?php echo $storage_unit['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete=<?php echo $storage_unit['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../partials/footer.php'); ?>
</body>
</html>
