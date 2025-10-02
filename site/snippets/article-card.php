<div class="article-container">
    <div class="article-headline"><?= $headline ?? '' ?></div>
    <div class="article-teaser-text">
        <?= $teaser ?? '' ?>
    </div>
    <div class="article-tags">
        <?php if (isset($tags) && !empty($tags)): ?>
            <?php foreach ($tags as $tag): ?>
                <span class="tag"><?= $tag ?></span>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

