<div class="article-container">
    <div class="article-headline"><?= $headline ?? '' ?></div>
    <div class="article-teaser-text">
        <?= $teaser ?? '' ?>
    </div>
    <?php if (isset($publisher) && !empty($publisher)): ?>
        <div class="article-publisher"><?= $publisher ?></div>
    <?php endif ?>
    <div class="article-tags">
        <?php if (isset($tags) && !empty($tags)): ?>
            <?php foreach ($tags as $tag): ?>
                <div class="article-tag <?= $tag['color'] ?? '' ?>"><?= $tag['label'] ?? $tag ?></div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

