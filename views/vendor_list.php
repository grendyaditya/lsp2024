<?php
session_start();
include('../auth/auth.php');
checkAuth();
include('../config/db.php');

// Proses hapus vendor
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Hapus vendor
    $stmt = $conn->prepare("DELETE FROM vendor WHERE id = :id");
    $stmt->execute(['id' => $id]);
    
    $message = "Vendor deleted successfully!";
}

// Ambil daftar vendor
$stmt = $conn->query("SELECT * FROM vendor");
$vendors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Vendor List</title>
</head>
<body>

<?php include('../partials/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('../partials/sidebar.php'); ?>
        </div>
        <div class="col-md-9">
            <h1 class="mt-4">Vendor List</h1>

            <?php if (isset($message)): ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Vendor List</h5>
                    <a href="add_vendor.php" class="btn btn-primary float-right">Add Vendor</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Vendor</th>
                                <th>Kontak</th>
                                <th>Nama Barang</th>
                                <th>Nomor Invoice</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vendors as $vendor): ?>
                                <tr>
                                    <td><?php echo $vendor['id']; ?></td>
                                    <td><?php echo $vendor['nama']; ?></td>
                                    <td><?php echo $vendor['kontak']; ?></td>
                                    <td><?php echo $vendor['nama_barang']; ?></td>
                                    <td><?php echo $vendor['nomor_invoice']; ?></td>
                                    <td>
                                        <a href="edit_vendor.php?id=<?php echo $vendor['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete=<?php echo $vendor['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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
