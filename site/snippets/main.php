<div id="main" :class="view">
    <div id="header-main">
        <div id="header-main-large" :class="{ 'scrolled': isScrolled }">
            <div id="website-title-container" :class="{ 'scrolled': isScrolled }">
                <div id="website-title">Rechtsextremismus in Famlilien<br> und Pädagogik begegnen</div>
            </div>
            <?php snippet('list-view-header') ?>
        </div>
        <div id="header-main-small" :class="{ 'scrolled': isScrolled }">
            <div id="website-title-container-small" :class="{ 'scrolled': isScrolled }">
                <div id="website-title-small">Rechtsextremismus in Famlilien und Pädagogik begegnen</div>
            </div>
            <?php snippet('list-view-header') ?>
        </div>
    </div>
    <div id="content" :class="view + (isScrolled ? ' scrolled' : '')">
        <?php 
        // Get all articles from the three main sections
        $fallbeispiele = page('fallbeispiele')?->children()->listed();
        $methoden = page('methoden')?->children()->listed();
        $broschueren = page('broschueren-und-informationen')?->children()->listed();
        
        // Combine all articles into one collection
        $allArticles = new Pages([]);
        if ($fallbeispiele) $allArticles = $allArticles->add($fallbeispiele);
        if ($methoden) $allArticles = $allArticles->add($methoden);
        if ($broschueren) $allArticles = $allArticles->add($broschueren);
        
        // Label and color mappings for tags
        $tagConfig = [
            // Inhaltsart
            'fallbeispiele' => ['label' => 'Fallbeispiele', 'color' => 'cyan'],
            'methoden' => ['label' => 'Methoden', 'color' => 'magenta'],
            'broschuere-und-information' => ['label' => 'Broschüre und Information', 'color' => 'yellow'],
            // Kategorie
            'paedagogische-fachkraft' => ['label' => 'Pädagogische Fachkraft', 'color' => 'purple'],
            'eltern-und-angehoerige' => ['label' => 'Eltern und Angehörige', 'color' => 'orange'],
            // Unterkategorie
            'schule' => ['label' => 'Schule', 'color' => 'purple'],
            'kita' => ['label' => 'Kita', 'color' => 'purple'],
            'sozialarbeit' => ['label' => 'Sozialarbeit, Kinder- und Jugendhilfe', 'color' => 'purple']
        ];
        
        // Loop through all articles and display them
        foreach ($allArticles as $article): 
            // Collect tags from the article fields
            $tags = [];
            $filterKeys = []; // Raw keys for filtering
            
            // Add Inhaltsart (new_category)
            if ($article->new_category()->isNotEmpty()) {
                $key = $article->new_category()->value();
                $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                $tagData['type'] = 'content-type';
                $tagData['key'] = $key;
                $tags[] = $tagData;
                $filterKeys[] = $key;
            }
            
            // Add Kategorie (category)
            if ($article->category()->isNotEmpty()) {
                $key = $article->category()->value();
                $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                $tagData['type'] = 'audience';
                $tagData['key'] = $key;
                $tags[] = $tagData;
                $filterKeys[] = $key;
            }
            
            // Add Unterkategorie (subcategory)
            if ($article->subcategory()->isNotEmpty()) {
                $key = $article->subcategory()->value();
                $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                $tagData['type'] = 'subcategory';
                $tagData['key'] = $key;
                $tags[] = $tagData;
                $filterKeys[] = $key;
            }
            
            // Convert filter keys to JSON for Alpine.js
            $filterKeysJson = htmlspecialchars(json_encode($filterKeys), ENT_QUOTES, 'UTF-8');
            
            // Prepare searchable text (title, publisher, intro text combined)
            $searchableText = strtolower(
                $article->page_title()->value() . ' ' . 
                $article->publisher()->value() . ' ' . 
                $article->intro_text()->value()
            );
            $searchableJson = htmlspecialchars(json_encode($searchableText), ENT_QUOTES, 'UTF-8');
        ?>
            <?php snippet('article-card', [
                'headline' => $article->page_title()->value(),
                'teaser' => $article->intro_text()->value(),
                'publisher' => $article->publisher()->value(),
                'tags' => $tags,
                'filterKeys' => $filterKeysJson,
                'searchableText' => $searchableJson
            ]) ?>
        <?php endforeach ?>
    </div>
</div>

