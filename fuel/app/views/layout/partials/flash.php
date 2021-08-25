<?php if (Session::get_flash('success')): ?>
    <div class="alert alert-success rounded-corners">
        <i class="close-dialog fa fa-times-circle-o close"></i>
        <h4>Success</h4>
        <p>
            <?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
        </p>
    </div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
    <div class="alert alert-error rounded-corners">
        <i class="close-dialog fa fa-times-circle-o close"></i>
        <h4>Error</h4>
        <p>
            <?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
        </p>
    </div>
<?php endif; ?>
<?php if (Session::get_flash('info')): ?>
    <div class="alert alert-info rounded-corners close">
        <i class="close-dialog fa fa-times-circle-o close"></i>
        <h4>Info</h4>
        <p>
            <?php echo implode('</p><p>', e((array) Session::get_flash('info'))); ?>
        </p>
    </div>
<?php endif; ?>