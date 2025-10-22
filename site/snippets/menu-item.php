<?php if (isset($url)): ?>
<a href="<?= $url ?>" class="top-menu-element-container <?= ($active ?? false) ? 'active' : '' ?>">
    <div class="top-menu-element"><?= $label ?? '' ?></div>
</a>
<?php else: ?>
<div class="top-menu-element-container <?= ($active ?? false) ? 'active' : '' ?>">
    <div class="top-menu-element"><?= $label ?? '' ?></div>
</div>
<?php endif ?>

