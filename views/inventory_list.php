<?php
session_start();
include('../auth/auth.php');
checkAuth();
include('../config/db.php');

// Proses hapus inventory
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $message = "Inventory deleted successfully!";
}

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Modify SQL query to include search functionality
$stmt = $conn->prepare("SELECT inventory.id, inventory.nama_barang, inventory.jenis_barang, inventory.kuantitas_stok,
                        inventory.lokasi_gudang, inventory.barcode, inventory.harga, vendor.nama AS vendor_nama 
                        FROM inventory 
                        JOIN vendor ON inventory.vendor_id = vendor.id
                        WHERE inventory.nama_barang LIKE :search OR inventory.barcode LIKE :search");
$stmt->execute(['search' => '%' . $search . '%']);
$inventories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Inventory List</title>
</head>
<body>

<?php include('../partials/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('../partials/sidebar.php'); ?>
        </div>
        <div class="col-md-9">
            <h1 class="mt-4">Inventory List</h1>

            <?php if (isset($message)): ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Search Form -->
            <form method="GET" class="form-inline mb-3">
                <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search by Name or Barcode" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Inventory List</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Kuantitas Stok</th>
                                <th>Lokasi Gudang</th>
                                <th>Harga</th>
                                <th>Barcode</th>
                                <th>Vendor</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($inventories) > 0): ?>
                                <?php foreach ($inventories as $inventory): ?>
                                    <tr>
                                        <td><?php echo $inventory['id']; ?></td>
                                        <td><?php echo $inventory['nama_barang']; ?></td>
                                        <td><?php echo $inventory['jenis_barang']; ?></td>
                                        <td><?php echo $inventory['kuantitas_stok']; ?></td>
                                        <td><?php echo $inventory['lokasi_gudang']; ?></td>
                                        <td>Rp. <?php echo $inventory['harga']; ?></td>
                                        <td><?php echo $inventory['barcode']; ?></td>
                                        <td><?php echo $inventory['vendor_nama']; ?></td>
                                        <td>
                                            <a href="edit_inventory.php?id=<?php echo $inventory['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?delete=<?php echo $inventory['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No inventory items found.</td>
                                </tr>
                            <?php endif; ?>
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
