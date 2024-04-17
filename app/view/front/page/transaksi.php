<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php $this->getAdditionalBefore(); ?>
    <?php $this->getAdditional(); ?>
    <?php $this->getAdditionalAfter(); ?>
    <style>
        body {
            background: url('<?= base_url("skin/img/bekgron2.jpg") ?>');
            background-repeat: no-repeat;
            background-size: 100% 100%;
            --webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body>
    <?php $this->getJsFooter(); ?>
    <?php $this->getJsReady(); ?>
    <main class="py-4">
        <?php $this->getThemeContent() ?>
    </main>
</body>

</html>