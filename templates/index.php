<?php require_once 'templates/header.php';?>
    <div class="container mb-5">
        <?php if ($validation != ''): ?>
            <div class="alert <?=$validationClass?>">
                <?=$validation;?>
                <?php if ($validationClass == 'alert-success'): ?>
                    <i class="ml-2 fa fa-check"></i>
                <?php endif;?>
            </div>
        <?php endif;?>
        <div class="row">
            <div class="col-md-12">
                <?php require_once 'templates/form.php';?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once 'templates/footer.php';?>
            </div>
        </div>
    </div>
</body>
</html>
