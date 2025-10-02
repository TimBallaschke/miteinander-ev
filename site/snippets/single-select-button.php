<button 
    class="option-button" 
    @click="<?= $variable ?> = '<?= $value ?>'" 
    :class="{ 'active': <?= $variable ?> === '<?= $value ?>' }">
    <div class="button-dot"></div>
    <div class="button-content"><?= $label ?></div>
</button>

