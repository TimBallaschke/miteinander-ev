<a href="<?= $url ?? '#' ?>" 
   class="related-post-link"
   <?= ($isExternal ?? false) ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>
    <div class="related-post-container">
        <div class="related-post-headline"><?= $title ?? '' ?></div>
        <div class="related-post-tags">
            <?php if (isset($tags) && !empty($tags)): ?>
                <?php foreach ($tags as $tag): ?>
                    <div class="article-tag <?= $tag['color'] ?? '' ?> <?= $tag['type'] ?? '' ?> <?= $tag['key'] ?? '' ?>"><?= $tag['label'] ?? $tag ?></div>
                <?php endforeach ?>
            <?php endif ?>
            <?php if ($showExternalTag ?? false): ?>
                <div class="article-tag red external-link">Externer Link</div>
            <?php endif ?>
        </div>
    </div>
</a>

