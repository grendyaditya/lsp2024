<?php
session_start();
include('../auth/auth.php');
checkAuth();
include('../config/db.php');

// Ambil ID inventory dari parameter URL
$id = $_GET['id'];

// Ambil data inventory yang akan diedit
$stmt = $conn->prepare("SELECT * FROM inventory WHERE id = :id");
$stmt->execute(['id' => $id]);
$inventory = $stmt->fetch();

// Ambil daftar storage units untuk dropdown
$stmt = $conn->query("SELECT * FROM storage_unit");
$storage_units = $stmt->fetchAll();

// Proses update inventory
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $jenis_barang = $_POST['jenis_barang'];
    $kuantitas_stok = $_POST['kuantitas_stok'];
    $barcode = $_POST['barcode']; // Ambil input barcode dari form
    $harga = $_POST['harga']; // Ambil input harga dari form
    $storage_unit_id = $_POST['storage_unit_id']; // Ambil ID storage unit dari form

    // Dapatkan nama gudang untuk diupdate ke inventory
    $stmt = $conn->prepare("SELECT nama_gudang FROM storage_unit WHERE id = :id");
    $stmt->execute(['id' => $storage_unit_id]);
    $storage_unit = $stmt->fetch();

    try {
        // Update inventory
        $stmt = $conn->prepare("UPDATE inventory SET nama_barang = :nama_barang, jenis_barang = :jenis_barang, kuantitas_stok = :kuantitas_stok, barcode = :barcode, harga = :harga, lokasi_gudang = :lokasi_gudang, storage_unit_id = :storage_unit_id WHERE id = :id");
        $stmt->execute([
            'nama_barang' => $nama_barang,
            'jenis_barang' => $jenis_barang,
            'kuantitas_stok' => $kuantitas_stok,
            'barcode' => $barcode, // Update barcode
            'harga' => $harga, // Update harga
            'lokasi_gudang' => $storage_unit['nama_gudang'], // Set lokasi_gudang berdasarkan nama_gudang
            'storage_unit_id' => $storage_unit_id,
            'id' => $id
        ]);

        // Redirect to inventory_list.php after successful update
        header("Location: inventory_list.php?message=Inventory item successfully updated!");
        exit(); // Ensure no further code is executed after redirect
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
    <title>Edit Inventory</title>
</head>
<body>
<?php include('../partials/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('../partials/sidebar.php'); ?>
        </div>
        <div class="col-md-9">
            <h1 class="mt-4">Edit Inventory</h1>

            <?php if (isset($message)): ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="<?php echo $inventory['nama_barang']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="jenis_barang">Jenis Barang</label>
                    <input type="text" name="jenis_barang" class="form-control" value="<?php echo $inventory['jenis_barang']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="kuantitas_stok">Kuantitas Stok</label>
                    <input type="number" name="kuantitas_stok" class="form-control" value="<?php echo $inventory['kuantitas_stok']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" step="0.01" name="harga" class="form-control" value="<?php echo $inventory['harga']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="barcode">Barcode</label>
                    <input type="text" name="barcode" class="form-control" value="<?php echo $inventory['barcode']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="storage_unit_id">Lokasi Gudang</label>
                    <select name="storage_unit_id" class="form-control" required>
                        <?php foreach ($storage_units as $storage_unit): ?>
                            <option value="<?php echo $storage_unit['id']; ?>" <?php echo ($inventory['storage_unit_id'] == $storage_unit['id']) ? 'selected' : ''; ?>>
                                <?php echo $storage_unit['nama_gudang']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update Inventory</button>
            </form>
        </div>
    </div>
</div>

<?php include('../partials/footer.php'); ?>
</body>
</html>
