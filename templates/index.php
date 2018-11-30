<?php require_once 'templates/header.php';?>
    <div class="container mb-5">
        <?php if ($mailer->validation != ''): ?>
            <div class="alert <?=$mailer->validationClass?>">
                <?=$mailer->validation;?>
                <?php if ($mailer->validationClass == 'alert-success'): ?>
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
    <script src="https://unpkg.com/coriander@1.2.4/index.js"></script>
    <script src="templates/js/index.js"></script>
</body>
</html>
