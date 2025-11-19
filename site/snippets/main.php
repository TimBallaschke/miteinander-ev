<div id="main" :class="view">
    <div id="header-main">
        <div id="header-main-large" :class="{ 'scrolled': isScrolled }">
            <div id="website-title-container" :class="{ 'scrolled': isScrolled }">
                <a href="<?= url() ?>" id="website-title">Rechtsextremismus in Familien<br> und Pädagogik begegnen</a>
                <div class="mobile-menu-plus-button" :class="{ 'unfolded': mobileMenuUnfolded }" @click="mobileMenuUnfolded = !mobileMenuUnfolded">
                    <div class="plus-line-horizontal"></div>
                    <div class="plus-line-vertical"></div>
                </div>
            </div>
            <?php snippet('list-view-header') ?>
        </div>
        <div id="header-main-small" :class="{ 'scrolled': isScrolled }">
            <div id="website-title-container-small" :class="{ 'scrolled': isScrolled }">
                <a href="<?= url() ?>" id="website-title-small">Rechtsextremismus in Familien und Pädagogik begegnen</a>
            </div>
            <?php snippet('mobile-menu-header') ?>
            <?php snippet('mobile-filter-header') ?>
            <?php snippet('list-view-header') ?>
        </div>
    </div>
    <div id="content" :class="view + (isScrolled ? ' scrolled' : '') + (mobileFilterVisible ? ' filter-visible' : '')">
        <div id="intro-text" :class="{ 'unfolded': introTextUnfolded }" @click="introTextUnfolded = !introTextUnfolded"
             x-data="{ isMobile: window.innerWidth <= 767 }"
             @resize.window="isMobile = window.innerWidth <= 767">
            <?php 
            $fullText = page('startseite')?->flow_text()->value() ?? '';
            // Convert *italic* to <em>italic</em>
            $processedText = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $fullText);
            // Split by spaces, preserving UTF-8 characters (strip tags for word count)
            $words = preg_split('/\s+/u', strip_tags($processedText), -1, PREG_SPLIT_NO_EMPTY);
            
            // Create mobile version (12 words)
            $truncatedWordsMobile = array_slice($words, 0, 12);
            $truncatedTextMobile = $processedText;
            foreach ($words as $i => $word) {
                if ($i >= 12) {
                    $pattern = '/(' . preg_quote($truncatedWordsMobile[11], '/') . ').*$/us';
                    $truncatedTextMobile = preg_replace($pattern, '$1', $processedText);
                    break;
                }
            }
            if (count($words) > 12) {
                $truncatedTextMobile .= ' ... <em>(mehr lesen)</em>';
            }
            
            // Create desktop version (40 words)
            $truncatedWordsDesktop = array_slice($words, 0, 40);
            $truncatedTextDesktop = $processedText;
            foreach ($words as $i => $word) {
                if ($i >= 40) {
                    $pattern = '/(' . preg_quote($truncatedWordsDesktop[39], '/') . ').*$/us';
                    $truncatedTextDesktop = preg_replace($pattern, '$1', $processedText);
                    break;
                }
            }
            if (count($words) > 40) {
                $truncatedTextDesktop .= ' ... <em>(mehr lesen)</em>';
            }
            ?>
            <div x-show="!introTextUnfolded">
                <span x-show="isMobile"><?= $truncatedTextMobile ?></span>
                <span x-show="!isMobile"><?= $truncatedTextDesktop ?></span>
            </div>
            <div x-show="introTextUnfolded">
                <?= page('startseite')?->flow_text()->kt() ?> <em>(weniger lesen)</em>
            </div>
            <div class="intro-text-plus">
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
                'broschuere-und-information' => ['label' => 'Literatur & Material', 'color' => 'yellow'],
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
                    $article->title()->value() . ' ' . 
                    $article->publisher()->value() . ' ' . 
                    $article->intro_text()->value()
                );
                $searchableJson = htmlspecialchars(json_encode($searchableText), ENT_QUOTES, 'UTF-8');
                
                // Brochures: Check for PDF, then check for related posts link
                $isExternal = false;
                $isBrochure = $article->new_category()->value() === 'broschuere-und-information';
                
                if ($isBrochure) {
                    // Brochure: First try to get PDF file
                    $pdfFile = $article->files()->first();
                    if ($pdfFile) {
                        $articleUrl = $pdfFile->url();
                        $isExternal = true;
                    } else {
                        // No PDF, check for related posts (Weiterführende Materialien)
                        $hasLink = false;
                        if ($article->related_posts()->isNotEmpty()) {
                            $firstPost = $article->related_posts()->toStructure()->first();
                            if ($firstPost) {
                                // Prefer external link over internal link
                                if ($firstPost->external_link()->isNotEmpty()) {
                                    // Use external link
                                    $articleUrl = $firstPost->external_link()->value();
                                    $isExternal = true;
                                    $hasLink = true;
                                } else {
                                    // Check if there's an internal link
                                    $linkedPage = $firstPost->internal_link()->toPage();
                                    if ($linkedPage) {
                                        $articleUrl = $linkedPage->url();
                                        $isExternal = false;
                                        $hasLink = true;
                                    }
                                }
                            }
                        }
                        // If no link found, set to #
                        if (!$hasLink) {
                            $articleUrl = '#';
                        }
                    }
                } else {
                    // Fallbeispiel or Methode: Link to detail page
                    $articleUrl = $article->url();
                }
            ?>
                <?php snippet('article-card', [
                    'url' => $articleUrl,
                    'isExternal' => $isExternal,
                    'headline' => $article->title()->value(),
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

