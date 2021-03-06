<?php
session_start();


if (!isset($_SESSION['guest'])) {
    $_SESSION['guest'] = array();
}

if (!isset($_SESSION['simpan_foto'])) {
    $_SESSION['simpan_foto'] = array();
}

if ($_POST) {
    array_push($_SESSION['guest'], $_POST);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    // handle upload
    $nama_file = $_FILES['photo']['name'];
    $nama_tmp = $_FILES['photo']['tmp_name'];

    // kemana foto akan diupload
    $folder = "uploads/";
    $upload = move_uploaded_file($nama_tmp, $folder . $nama_file);

    $data_foto = ($_POST["photo"] = $folder . $nama_file);

    array_push($_SESSION['simpan_foto'], $data_foto);
}

print_r($_SESSION['guest']);
print_r($_SESSION['simpan_foto']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <div class="main-app">
        <div class="container">
            <h1 class="title">Contact US !</h1>
            <div class="section-input">
                <form method="post" enctype="multipart/form-data">
                    <label for="nama">masukan nama:</label><br>
                    <input type="text" name="nama_lengkap" id="nama"><br>

                    <br>

                    <label for="email">masukan email:</label><br>
                    <input type="text" name="email_ku" id="email"><br>

                    <br>

                    <label for="">Profile Picture (Opsional)</label> <br>
                    <input type="file" name="photo"> <br>

                    <br>

                    <label for="pesan">masukan pesan :</label><br>
                    <textarea name="pesan_ku" rows="5" id="pesan"></textarea><br>

                    <button type="submit" class="btn-add-task" name="kirim">Kirim</button>
                </form>
            </div>
            <div class="section-output">

                <?php foreach ($_SESSION['guest'] as $data) { ?>
                    <ul>
                        <li><?php echo $data["nama_lengkap"]; ?></li>
                        <li><?php echo $data["email_ku"]; ?></li>
                        <li><?php echo $data["pesan_ku"]; ?></li>
                    </ul>
                <?php } ?>

                <?php foreach ($_SESSION['simpan_foto'] as $foto) { ?>
                    <?php if ($foto == "uploads/") { ?>
                        <img src="isi link default foto" alt="">
                    <?php } else { ?>
                        <img src="<?= $foto ?>" alt="">
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>