<button 
    class="option-button <?= $colorClass ?? '' ?>" 
    @click="<?= $variable ?> = '<?= $value ?>'" 
    :class="{ 'active': <?= $variable ?> === '<?= $value ?>' }">
    <div class="button-dot"></div>
    <div class="button-content"><?= $label ?><?php if (isset($showTotal) && $showTotal && isset($GLOBALS['totalArticles'])): ?> (<?= $GLOBALS['totalArticles'] ?>)<?php elseif (isset($tagKey) && isset($GLOBALS['tagCounts'][$tagKey])): ?> (<?= $GLOBALS['tagCounts'][$tagKey] ?>)<?php endif ?></div>
</button>

