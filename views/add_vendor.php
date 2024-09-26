<?php
session_start();
include('../auth/auth.php');
checkAuth();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $nama_barang = $_POST['nama_barang'];
    $nomor_invoice = $_POST['nomor_invoice'];
    $kuantitas_stok = $_POST['kuantitas_stok'];

    try {
        // Insert ke tabel vendor
        $stmt = $conn->prepare("INSERT INTO vendor (nama, kontak, nama_barang, nomor_invoice) VALUES (:nama, :kontak, :nama_barang, :nomor_invoice)");
        $stmt->execute([
            'nama' => $nama,
            'kontak' => $kontak,
            'nama_barang' => $nama_barang,
            'nomor_invoice' => $nomor_invoice
        ]);

        // Dapatkan id vendor yang baru saja dimasukkan
        $vendor_id = $conn->lastInsertId();

        // Insert ke tabel inventory secara otomatis
        $stmt_inventory = $conn->prepare("INSERT INTO inventory (nama_barang, kuantitas_stok, vendor_id) VALUES (:nama_barang, :kuantitas_stok, :vendor_id)");
        $stmt_inventory->execute([
            'nama_barang' => $nama_barang,
            'kuantitas_stok' => $kuantitas_stok,
            'vendor_id' => $vendor_id
        ]);
        header("Location: vendor_list.php");
        exit(); // Ensure no further code is executed after redirect
        $message = "Vendor dan barang berhasil ditambahkan ke inventory!";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Add Vendor</title>
</head>
<body>
<?php include('../partials/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('../partials/sidebar.php'); ?>
        </div>
        <div class="col-md-9">
            <h1 class="mt-4">Add Vendor</h1>

            <?php if (isset($message)): ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Add Vendor</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nama">Nama Vendor</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="kontak">Kontak Vendor</label>
                            <input type="text" name="kontak" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="kuantitas_stok">Kuantitas Stok</label>
                            <input type="number" name="kuantitas_stok" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_invoice">Nomor Invoice</label>
                            <input type="text" name="nomor_invoice" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Vendor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../partials/footer.php'); ?>
</body>
</html>
