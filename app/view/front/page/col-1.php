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
            background: url('<?=base_url("skin/img/bekgron2.jpg")?>');
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
    <header>
        <!-- place navbar here -->

    </header>
    <main>
        <div class="d-flex flex-row" style="align-items:stretch; min-height:100vh">
            <?php $this->getThemeElement('page/html/sidebar', $__forward) ?>
            <div class="w-100">
                <?php $this->getThemeElement('page/html/header', $__forward) ?>
                <div class="container py-4">
                    <?php $this->getThemeContent() ?>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
        <?php $this->getThemeElement('page/html/footer', $__forward) ?>
    </footer>
</body>

</html>