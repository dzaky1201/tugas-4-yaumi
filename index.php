<?php
session_start();


if (!isset($_SESSION['guest'])) {
    $_SESSION['guest'] = array();
}

if ($_POST) {

    if ($_POST["method"] == 'DELETE') {
        $namaLengkap = $_POST["nama_lengkap"];
        if (!empty($namaLengkap)) {
            $_SESSION['guest'] = array_filter($_SESSION['guest'], function ($var) use ($namaLengkap) {
                return ($var["nama_lengkap"] != $namaLengkap);
            });
        }
    } else {
        // handle upload
        $nama_file = $_FILES['photo']['name'];
        $nama_tmp = $_FILES['photo']['tmp_name'];

        // kemana foto akan diupload
        $folder = "uploads/";
        $upload = move_uploaded_file($nama_tmp, $folder . $nama_file);

        $_POST["photo"] = $folder . $nama_file;

        array_push($_SESSION['guest'], $_POST);
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

// print_r($_SESSION['guest']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Contact US</title>
</head>

<style>
    /* Import Google font - Poppins */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        display: flex;
        padding: 0 10px;
        min-height: 100vh;
        background: #0D6EFD;
        align-items: center;
        justify-content: center;
    }

    img {
        width: 50px;
        height: 50px;
        background-size: cover;
        border-radius: 50%;
        margin: 0 10px 0 0;
    }

    .container {
        display: flex;
        margin-bottom: 25px;
        justify-content: space-between;
    }

    .section-input,
    .section-output {
        background: #fff;
        border-radius: 5px;
        padding: 25px;
        margin: 25px;
        height: 80vh;
        box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.05);
    }

    .section-output {
        overflow: scroll;
        position: relative;
    }

    .output::-webkit-scrollbar {
        display: none;
    }

    input,
    textarea,
    .btn-add-task {
        width: 100%;
        height: 100%;
        outline: none;
        padding: 0 18px 0;
        font-size: 16px;
        border-radius: 5px;
    }

    .text {
        margin: 10px 60px;
    }

    .message {
        margin: 20px 0;
    }

    .user {
        display: flex;
        justify-content: start;
        align-items: center;
        position: relative;
        flex-wrap: wrap;
    }

    .hapus {
        position: absolute;
        right: 10px;
        top: 14px;
    }
</style>

<body>
    <div class="container">
        <div class="section-input">
            <h1>Contact US !</h1>
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
            <h1>Pesan dari pengunjung</h1>
            <?php foreach ($_SESSION['guest'] as $data) { ?>
                <div class="message">
                    <div class="user">
                        <?php if ($data["photo"] == "uploads/") { ?>
                            <img src="uploads/foto.jpeg" alt="">
                        <?php } else { ?>
                            <img src="<?php echo $data["photo"]; ?>" alt="">
                        <?php } ?>
                        <p class="username"><?php echo $data["nama_lengkap"]; ?> <span>(<?php echo $data["email_ku"]; ?>)</span></p>
                        <form method="POST">
                            <input type="hidden" name="method" value="DELETE">
                            <input type="hidden" name="nama_lengkap" value="<?php echo $data["nama_lengkap"]; ?>">
                            <button type="submit" class="hapus" name="delete" onclick="return confirm('Yakin Hapus?')">Delete</button>
                        </form>
                    </div>

                    <p class="text"><?php echo $data["pesan_ku"]; ?></p>
                    <hr>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>
