<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MVCore :: <?= $title ?? ''; ?></title>
    <link rel="icon" href="<?= PATH; ?>assets/images/framework.png">
    <!--
        <a href="https://www.flaticon.com/free-icons/framework" title="framework icons">Framework icons created by SBTS2018 - Flaticon
    </a>-->
</head>
<body>

<?= $this->content; ?>

</body>
</html>