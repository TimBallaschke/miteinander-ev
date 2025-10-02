<div id="sidebar">
    <div id="top-menu">
        <?php snippet('menu-item', ['label' => 'Inhalte']) ?>
        <?php snippet('menu-item', ['label' => 'Informationen']) ?>
        <?php snippet('menu-item', ['label' => 'Beratungsangebote']) ?>
        <?php snippet('menu-item', ['label' => 'Kontakt']) ?>
    </div>
    <div class="sidebar-options">
        <div class="options-container">
            <div class="options-title">Ansicht:</div>
            <div id="view-switch" class="options-element">
                <?php snippet('single-select-button', [
                    'variable' => 'view',
                    'value' => 'grid',
                    'label' => 'Kachel'
                ]) ?>
                <?php snippet('single-select-button', [
                    'variable' => 'view',
                    'value' => 'list',
                    'label' => 'Liste'
                ]) ?>
            </div>
        </div>
        <div class="options-container">
            <div class="options-title">Mein Hintergrund:</div>
            <div id="audience-filter" class="options-element">
                <?php snippet('single-select-button', [
                    'variable' => 'audience',
                    'value' => 'all',
                    'label' => 'Alle'
                ]) ?>
                <?php snippet('single-select-button', [
                    'variable' => 'audience',
                    'value' => 'teacher',
                    'label' => 'Pädagogische Fachkraft'
                ]) ?>
                <?php snippet('single-select-button', [
                    'variable' => 'audience',
                    'value' => 'parents',
                    'label' => 'Eltern und Angehörige'
                ]) ?>
            </div>
        </div>
        <div class="options-container">
            <div class="options-title">Arbeitsbereich:</div>
            <div id="teacher-types-filter" class="options-element">
                <?php snippet('multi-select-button', [
                    'array' => 'teacherTypes',
                    'value' => 'school',
                    'label' => 'Schule'
                ]) ?>
                <?php snippet('multi-select-button', [
                    'array' => 'teacherTypes',
                    'value' => 'kita',
                    'label' => 'Kita'
                ]) ?>
                <?php snippet('multi-select-button', [
                    'array' => 'teacherTypes',
                    'value' => 'social',
                    'label' => 'Sozialarbeit, Kinder- und Jugendhilfe'
                ]) ?>
            </div>
        </div>
        <div class="options-container">
            <div class="options-title">Ich suche:</div>
            <div id="content-filter" class="options-element">
                <?php snippet('single-select-button', [
                    'variable' => 'content',
                    'value' => 'all',
                    'label' => 'Alle'
                ]) ?>
                <?php snippet('single-select-button', [
                    'variable' => 'content',
                    'value' => 'methods',
                    'label' => 'Methoden'
                ]) ?>
                <?php snippet('single-select-button', [
                    'variable' => 'content',
                    'value' => 'case-studies',
                    'label' => 'Fallbeispiele'
                ]) ?>
                <?php snippet('single-select-button', [
                    'variable' => 'content',
                    'value' => 'brochures',
                    'label' => 'Broschüren und Informationen'
                ]) ?>
            </div>
        </div>
    </div>
</div>


