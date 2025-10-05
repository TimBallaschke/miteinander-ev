<button 
    class="multi-select-button <?= $colorClass ?? '' ?>"
    @click="if (audience === 'teacher') { <?= $array ?>.includes('<?= $value ?>') ? <?= $array ?> = <?= $array ?>.filter(item => item !== '<?= $value ?>') : <?= $array ?>.push('<?= $value ?>') }" 
    :class="{ 'active': audience === 'teacher' && <?= $array ?>.includes('<?= $value ?>') }">
    <div class="button-dot"></div>
    <div class="button-content"><?= $label ?></div>
</button>

