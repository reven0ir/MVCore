<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MVCore :: <?= $title ?? ''; ?></title>
    <link rel="stylesheet" href="<?= base_url('/'); ?>assets/bootstrap/css/bootstrap.css">
    <link rel="icon" href="<?= base_url('/'); ?>assets/images/framework.png">
<!--
    <a href="https://www.flaticon.com/free-icons/framework" title="framework icons">Framework icons created by SBTS2018 - Flaticon
</a>-->
</head>
<body>



<?php get_alerts(); ?>

<?= $this->content; ?>

<script src="<?= base_url('/'); ?>assets/bootstrap/js/bootstrap.js"></script>

<?php if (DEBUG): ?>
    <?php dump(db()->getQueries()) ?>
<?php endif; ?>
</body>
</html>