<div id="sidebar">
    <div id="top-menu" :class="{ 'scrolled': isScrolled, 'menu-unfolded': menuUnfolded }">
        <div id="top-menu-content">
            <?php snippet('menu-item', [
                'label' => 'Inhalte',
                'url' => url(),
                'active' => $page->isHomePage() || $page->template()->name() === 'fallbeispiel' || $page->template()->name() === 'methode'
            ]) ?>
            <?php snippet('menu-item', [
                'label' => 'Informationen',
                'url' => page('information')?->url() ?? '#',
                'active' => $page->is('information')
            ]) ?>
            <?php snippet('menu-item', [
                'label' => 'Beratungsangebote',
                'url' => page('beratungsangebot')?->url() ?? '#',
                'active' => $page->is('beratungsangebot')
            ]) ?>
            <?php snippet('menu-item', [
                'label' => 'Kontakt',
                'url' => page('kontakt')?->url() ?? '#',
                'active' => $page->is('kontakt')
            ]) ?>
            <div class="top-menu-plus" @click="menuUnfolded = !menuUnfolded">
                <div class="plus-line-horizontal"></div>
                <div class="plus-line-vertical"></div>
            </div>
        </div>
    </div>
    <div id="sidebar-content" :class="{ 'scrolled': isScrolled, 'menu-unfolded': menuUnfolded }">
        <?php if ($page->isHomePage()): ?>
        <div id="sidebar-search">
            <input id="sidebar-search-input" type="text" placeholder="Suche (Titel, Herausgeber*in, etc.)" x-model="searchQuery">
        </div>
        <div class="sidebar-options">
            <div class="options-container">
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
            </div>
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
        <?php elseif ($page->template()->name() === 'fallbeispiel' || $page->template()->name() === 'methode'): ?>
            <?php if ($page->related_posts()->isNotEmpty()): ?>
        <div id="sidebar-related-materials">
            <div class="sidebar-section-title options-title">Weiterführende Materialien:</div>
                <?php 
                // Tag config for related posts
                $tagConfig = [
                    'fallbeispiele' => ['label' => 'Fallbeispiele', 'color' => 'cyan'],
                    'methoden' => ['label' => 'Methoden', 'color' => 'magenta'],
                    'broschuere-und-information' => ['label' => 'Literatur & Material', 'color' => 'yellow'],
                    'paedagogische-fachkraft' => ['label' => 'Pädagogische Fachkraft', 'color' => 'purple'],
                    'eltern-und-angehoerige' => ['label' => 'Eltern und Angehörige', 'color' => 'orange'],
                    'schule' => ['label' => 'Schule', 'color' => 'purple'],
                    'kita' => ['label' => 'Kita', 'color' => 'purple'],
                    'sozialarbeit' => ['label' => 'Sozialarbeit, Kinder- und Jugendhilfe', 'color' => 'purple']
                ];
                
                foreach ($page->related_posts()->toStructure() as $post): 
                    // Always prioritize internal links over external links
                    $linkedPage = $post->internal_link()->toPage();
                    
                    // Validate that internal link points to an actual article (not overview page)
                    // Check by new_category field since templates may be 'default'
                    $validArticleCategories = ['fallbeispiele', 'methoden', 'broschuere-und-information'];
                    $isValidArticle = $linkedPage && 
                                     $linkedPage->new_category()->isNotEmpty() && 
                                     in_array($linkedPage->new_category()->value(), $validArticleCategories);
                    
                    if ($isValidArticle) {
                        // Internal link exists and points to valid article - use it
                        $title = $post->internal_link_title()->value();
                        
                        // Check if it's a brochure - if so, link to PDF
                        $isBrochure = $linkedPage->new_category()->value() === 'broschuere-und-information';
                        if ($isBrochure) {
                            // Brochure: Try to get PDF file
                            $pdfFile = $linkedPage->files()->first();
                            if ($pdfFile) {
                                $url = $pdfFile->url();
                                $isExternal = true;
                            } else {
                                $url = '#';
                                $isExternal = false;
                            }
                        } else {
                            // Fallbeispiel or Methode: Link to detail page
                            $url = $linkedPage->url();
                            $isExternal = false;
                        }
                        
                        // Get tags from the linked page
                        $tags = [];
                        if ($linkedPage->new_category()->isNotEmpty()) {
                            $key = $linkedPage->new_category()->value();
                            $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                            $tagData['type'] = 'content-type';
                            $tagData['key'] = $key;
                            $tags[] = $tagData;
                        }
                        if ($linkedPage->category()->isNotEmpty()) {
                            $key = $linkedPage->category()->value();
                            $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                            $tagData['type'] = 'audience';
                            $tagData['key'] = $key;
                            $tags[] = $tagData;
                        }
                        if ($linkedPage->subcategory()->isNotEmpty()) {
                            $key = $linkedPage->subcategory()->value();
                            $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                            $tagData['type'] = 'subcategory';
                            $tagData['key'] = $key;
                            $tags[] = $tagData;
                        }
                    } elseif ($post->external_link()->isNotEmpty()) {
                        // No internal link - use external link
                        $url = $post->external_link()->value();
                        $title = $post->external_link_title()->value();
                        $isExternal = true;
                        $tags = [];
                    } else {
                        // Neither internal nor external link available - skip
                        continue;
                    }
                ?>
                    <?php snippet('related-post-card', [
                        'url' => $url,
                        'title' => $title,
                        'isExternal' => $isExternal,
                        'tags' => $tags ?? []
                    ]) ?>
                <?php endforeach ?>
        </div>
            <?php endif ?>
        <?php endif ?>
    </div>
</div>


