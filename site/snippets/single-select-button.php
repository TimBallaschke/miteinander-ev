<button 
    class="option-button <?= $colorClass ?? '' ?>" 
    @click="<?= $variable ?> = '<?= $value ?>'" 
    :class="{ 'active': <?= $variable ?> === '<?= $value ?>' }">
    <div class="button-dot"></div>
    <div class="button-content"><?= $label ?></div>
</button>

