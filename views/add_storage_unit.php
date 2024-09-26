<?php
session_start();
include('../auth/auth.php');
checkAuth();
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_gudang = $_POST['nama_gudang'];
    $lokasi = $_POST['lokasi'];

    try {
        // Insert ke tabel storage_unit
        $stmt = $conn->prepare("INSERT INTO storage_unit (nama_gudang, lokasi) VALUES (:nama_gudang, :lokasi)");
        $stmt->execute([
            'nama_gudang' => $nama_gudang,
            'lokasi' => $lokasi
        ]);
        header("Location: storage_unit.php");
        exit(); // Ensure no further code is executed after redirect
        $message = "Storage Unit berhasil ditambahkan!";
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
    <title>Add Storage Unit</title>
</head>
<body>
<?php include('../partials/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('../partials/sidebar.php'); ?>
        </div>
        <div class="col-md-9">
            <h1 class="mt-4">Add Storage Unit</h1>

            <?php if (isset($message)): ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>Add Storage Unit</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nama_gudang">Nama Gudang</label>
                            <input type="text" name="nama_gudang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Storage Unit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../partials/footer.php'); ?>
</body>
</html>
