<p>
        <i class="icon icon-thumbs-up"></i> (<span id="likes"><?php echo $videoke->thumbs_up(); ?></span>)
        <i class="icon icon-thumbs-down"></i> (<span id="dislikes"><?php echo $videoke->thumbs_down(); ?></span>)
</p>
<p>
    <em><?php echo Html::anchor("#", "VOTES (".($videoke->votes()).")"); ?></em>
</p>
