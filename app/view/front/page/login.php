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
</head>

<body class="bg-primary">
    <?php $this->getJsFooter(); ?>
    <?php $this->getJsReady(); ?>
    <main>
        <?php $this->getThemeContent() ?>
    </main>
</body>

</html>