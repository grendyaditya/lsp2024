<?php
session_start();
include('../auth/auth.php');
checkAuth();
include('../config/db.php');

// Ambil data vendor berdasarkan id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM vendor WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $vendor = $stmt->fetch();
}

// Proses edit vendor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $nama_barang = $_POST['nama_barang'];
    $nomor_invoice = $_POST['nomor_invoice'];

    // Update vendor
    $stmt = $conn->prepare("UPDATE vendor SET nama = :nama, kontak = :kontak, nama_barang = :nama_barang, nomor_invoice = :nomor_invoice WHERE id = :id");
    $stmt->execute([
        'id' => $id,
        'nama' => $nama,
        'kontak' => $kontak,
        'nama_barang' => $nama_barang,
        'nomor_invoice' => $nomor_invoice
    ]);

    // Update nama barang di tabel inventory
    $stmt_inventory = $conn->prepare("UPDATE inventory SET nama_barang = :nama_barang WHERE vendor_id = :vendor_id");
    $stmt_inventory->execute([
        'nama_barang' => $nama_barang,
        'vendor_id' => $id
    ]);

    header('Location: vendor_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Edit Vendor</title>
</head>
<body>

<?php include('../partials/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('../partials/sidebar.php'); ?>
        </div>
        <div class="col-md-9">
            <h1 class="mt-4">Edit Vendor</h1>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Edit Vendor</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="edit_vendor.php">
                        <input type="hidden" name="id" value="<?php echo $vendor['id']; ?>">
                        <div class="form-group">
                            <label for="nama">Nama Vendor</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo $vendor['nama']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kontak">Kontak</label>
                            <input type="text" class="form-control" name="kontak" value="<?php echo $vendor['kontak']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" value="<?php echo $vendor['nama_barang']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_invoice">Nomor Invoice</label>
                            <input type="text" class="form-control" name="nomor_invoice" value="<?php echo $vendor['nomor_invoice']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Vendor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../partials/footer.php'); ?>
</body>
</html>
