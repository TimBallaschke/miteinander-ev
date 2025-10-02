<button 
    class="multi-select-button" 
    @click="if (audience === 'teacher') { <?= $array ?>.includes('<?= $value ?>') ? <?= $array ?> = <?= $array ?>.filter(item => item !== '<?= $value ?>') : <?= $array ?>.push('<?= $value ?>') }" 
    :class="{ 'active': audience === 'teacher' && <?= $array ?>.includes('<?= $value ?>') }">
    <?= $label ?>
</button>

