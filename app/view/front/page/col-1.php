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

<body>
    <?php $this->getJsFooter(); ?>
    <?php $this->getJsReady(); ?>
    <header>
        <!-- place navbar here -->
        <?php $this->getThemeElement('page/html/header', $__forward) ?>
    </header>
    <main>
        <div class="d-flex flex-row">
            <?php $this->getThemeElement('page/html/sidebar', $__forward)?>
            <div class="w-100 container py-4">
                <?php $this->getThemeContent() ?>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
        <?php $this->getThemeElement('page/html/footer', $__forward) ?>
    </footer>
</body>

</html>