<div class="mobile-filter-header" :class="{ 'filter-visible': mobileFilterVisible }">
    <div class="mobile-filter-header-title-container" @click="mobileFilterVisible = !mobileFilterVisible">
        <div class="mobile-filter-header-title">Filter</div>
        <div class="mobile-filter-header-button"></div>
    </div>
    <div id="sidebar-search">
        <input id="sidebar-search-input" type="text" placeholder="Suche (Titel, Herausgeber*in, etc.)" x-model="searchQuery">
    </div>
    <div class="mobile-filter-header-content">
        <div class="sidebar-options">
            <!-- <div class="options-container">
                <div class="options-title">Ansicht:</div>
                <div id="view-switch" class="options-element">
                    <?php snippet('single-select-button', [
                        'variable' => 'view',
                        'value' => 'grid',
                        'label' => 'Kachel',
                        'colorClass' => 'outline'
                    ]) ?>
                    <?php snippet('single-select-button', [
                        'variable' => 'view',
                        'value' => 'list',
                        'label' => 'Liste',
                        'colorClass' => 'outline'
                    ]) ?>
                </div>
            </div> -->
            <div class="options-container">
                <div class="options-title">Mein Hintergrund:</div>
                <div id="audience-filter" class="options-element">
                    <?php snippet('single-select-button', [
                        'variable' => 'audience',
                        'value' => 'all',
                        'label' => 'Alle',
                        'colorClass' => 'black',
                        'showTotal' => true
                    ]) ?>
                    <?php snippet('single-select-button', [
                        'variable' => 'audience',
                        'value' => 'teacher',
                        'label' => 'Pädagogische Fachkraft',
                        'colorClass' => 'purple',
                        'tagKey' => 'paedagogische-fachkraft'
                    ]) ?>
                    <div id="teacher-types-filter" class="options-element">
                        <?php snippet('multi-select-button', [
                            'array' => 'teacherTypes',
                            'value' => 'school',
                            'label' => 'Schule',
                            'colorClass' => 'purple',
                            'tagKey' => 'schule'
                        ]) ?>
                        <?php snippet('multi-select-button', [
                            'array' => 'teacherTypes',
                            'value' => 'kita',
                            'label' => 'Kita',
                            'colorClass' => 'purple',
                            'tagKey' => 'kita'
                        ]) ?>
                        <?php snippet('multi-select-button', [
                            'array' => 'teacherTypes',
                            'value' => 'social',
                            'label' => 'Sozialarbeit, Kinder- und Jugendhilfe',
                            'colorClass' => 'purple',
                            'tagKey' => 'sozialarbeit'
                        ]) ?>
                    </div>
                    <?php snippet('single-select-button', [
                        'variable' => 'audience',
                        'value' => 'parents',
                        'label' => 'Eltern und Angehörige',
                        'colorClass' => 'orange',
                        'tagKey' => 'eltern-und-angehoerige'
                    ]) ?>
                </div>
            </div>
            <div class="options-container">
                <div class="options-title">Ich suche:</div>
                <div id="content-filter" class="options-element">
                    <?php snippet('single-select-button', [
                        'variable' => 'content',
                        'value' => 'all',
                        'label' => 'Alle',
                        'colorClass' => 'black',
                        'showTotal' => true
                    ]) ?>
                    <?php snippet('single-select-button', [
                        'variable' => 'content',
                        'value' => 'case-studies',
                        'label' => 'Fallbeispiele',
                        'colorClass' => 'cyan',
                        'tagKey' => 'fallbeispiele'
                    ]) ?>
                    <?php snippet('single-select-button', [
                        'variable' => 'content',
                        'value' => 'brochures',
                        'label' => 'Literatur & Material',
                        'colorClass' => 'yellow',
                        'tagKey' => 'broschuere-und-information'
                    ]) ?>
                    <?php snippet('single-select-button', [
                        'variable' => 'content',
                        'value' => 'methods',
                        'label' => 'Methoden',
                        'colorClass' => 'magenta',
                        'tagKey' => 'methoden'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>