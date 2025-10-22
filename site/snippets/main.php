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
        <div id="intro-text" :class="{ 'unfolded': introTextUnfolded }">
            <?php 
            $fullText = page('startseite')?->flow_text()->value() ?? '';
            // Convert *italic* to <em>italic</em>
            $processedText = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $fullText);
            // Split by spaces, preserving UTF-8 characters (strip tags for word count)
            $words = preg_split('/\s+/u', strip_tags($processedText), -1, PREG_SPLIT_NO_EMPTY);
            $truncatedWords = array_slice($words, 0, 18);
            // Re-apply formatting to truncated text
            $truncatedText = $processedText;
            foreach ($words as $i => $word) {
                if ($i >= 18) {
                    // Find and cut after the 18th word
                    $pattern = '/(' . preg_quote($truncatedWords[17], '/') . ').*$/us';
                    $truncatedText = preg_replace($pattern, '$1', $processedText);
                    break;
                }
            }
            if (count($words) > 18) {
                $truncatedText .= ' ... <em>(mehr lesen)</em>';
            }
            ?>
            <div x-show="!introTextUnfolded">
                <?= $truncatedText ?>
            </div>
            <div x-show="introTextUnfolded">
                <?= page('startseite')?->flow_text()->kt() ?>
            </div>
            <div class="intro-text-plus" @click="introTextUnfolded = !introTextUnfolded">
                <div class="plus-line-horizontal"></div>
                <div class="plus-line-vertical"></div>
            </div>
        </div>
        <div id="article-overview" :class="view">
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
                
                // Brochures: Open PDF directly, otherwise open detail page
                $isExternal = false;
                $isBrochure = $article->new_category()->value() === 'broschuere-und-information';
                
                if ($isBrochure) {
                    // Brochure: Try to get PDF file
                    $pdfFile = $article->files()->first();
                    if ($pdfFile) {
                        $articleUrl = $pdfFile->url();
                        $isExternal = true;
                    } else {
                        $articleUrl = '#';
                    }
                } else {
                    // Fallbeispiel or Methode: Link to detail page
                    $articleUrl = $article->url();
                }
            ?>
                <?php snippet('article-card', [
                    'url' => $articleUrl,
                    'isExternal' => $isExternal,
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
</div>

