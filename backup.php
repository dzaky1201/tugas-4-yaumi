<?php foreach ($_SESSION['simpan_foto'] as $foto) { ?>
    <?php if ($foto == "uploads/") { ?>
        <img src="isi link default foto" alt="">
    <?php } else { ?>
        <img src="<?= $foto ?>" alt="">
    <?php } ?>
<?php } ?>