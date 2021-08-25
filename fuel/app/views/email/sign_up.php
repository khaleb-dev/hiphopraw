<div id="middle">
    <div id="content" class="full">
        <p>
            Confirm your registration by click this link.
            <?php echo Html::anchor(Uri::create("users/activate/$activation_code"), "Click here to activate your account!") ?>
        </p>
    </div>
</div>
