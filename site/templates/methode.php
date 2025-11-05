<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->title() ?> - Miteinander e.V.</title>
    <link rel="stylesheet" href="<?= url('assets/style/style.css') ?>?v=3">
    <script src="<?= url('assets/js/alpine.min.js') ?>" defer></script>
</head>
<body x-data="{ 
    view: 'grid', 
    audience: 'all', 
    content: 'all', 
    teacherTypes: [],
    searchQuery: '',
    isScrolled: false,
    scrollThreshold: 0,
    menuUnfolded: false,
    introTextUnfolded: false,
    mobileFilterVisible: false,
    mobileMenuUnfolded: false,
    init() {
        this.$watch('audience', (value) => {
            if (value === 'teacher') {
                this.teacherTypes = ['school', 'kita', 'social'];
            } else {
                this.teacherTypes = [];
            }
        });
        this.$watch('mobileMenuUnfolded', (value) => {
            if (value === true) {
                this.mobileFilterVisible = false;
            }
        });
        this.$watch('mobileFilterVisible', (value) => {
            if (value === true) {
                this.mobileMenuUnfolded = false;
            }
        });
    }
}" 
@scroll.window="isScrolled = (window.pageYOffset > 0) && (window.innerWidth > 767)">
    <?php snippet('sidebar') ?>
    <div id="main" :class="view">
        <div id="header-main">
            <div id="header-main-large" :class="{ 'scrolled': isScrolled }">
                <div id="website-title-container" :class="{ 'scrolled': isScrolled }">
                    <a href="<?= url() ?>" id="website-title">Rechtsextremismus in Famlilien<br> und Pädagogik begegnen</a>
                    <div class="mobile-menu-plus-button" :class="{ 'unfolded': mobileMenuUnfolded }" @click="mobileMenuUnfolded = !mobileMenuUnfolded">
                        <div class="plus-line-horizontal"></div>
                        <div class="plus-line-vertical"></div>
                    </div>
                </div>
                <?php snippet('list-view-header') ?>
            </div>
            <div id="header-main-small" :class="{ 'scrolled': isScrolled }">
                <div id="website-title-container-small" :class="{ 'scrolled': isScrolled }">
                    <a href="<?= url() ?>" id="website-title-small">Rechtsextremismus in Famlilien und Pädagogik begegnen</a>
                </div>
                <?php snippet('mobile-menu-header') ?>
                <?php snippet('list-view-header') ?>
            </div>
        </div>
        <div id="content" class="not-landing" :class="view + (isScrolled ? ' scrolled' : '') + (mobileFilterVisible ? ' filter-visible' : '')">
            <div class="article-content">
                <div class="article-page-title"><?= $page->title() ?></div>
                
                <div class="article-tags">
                    <?php 
                    // Tag configuration
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
                    
                    // Add Inhaltsart (new_category)
                    if ($page->new_category()->isNotEmpty()) {
                        $key = $page->new_category()->value();
                        $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                        echo '<div class="article-tag ' . $tagData['color'] . '">' . $tagData['label'] . '</div>';
                    }
                    
                    // Add Kategorie (category)
                    if ($page->category()->isNotEmpty()) {
                        $key = $page->category()->value();
                        $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                        echo '<div class="article-tag ' . $tagData['color'] . '">' . $tagData['label'] . '</div>';
                    }
                    
                    // Add Unterkategorie (subcategory)
                    if ($page->subcategory()->isNotEmpty()) {
                        $key = $page->subcategory()->value();
                        $tagData = $tagConfig[$key] ?? ['label' => $key, 'color' => ''];
                        echo '<div class="article-tag ' . $tagData['color'] . '">' . $tagData['label'] . '</div>';
                    }
                    ?>
                </div>
                                                
                <?php if ($page->flow_text_1()->isNotEmpty()): ?>
                    <div class="article-disclaimer orange">
                        <?php 
                        $text = $page->flow_text_1()->value();
                        $text = preg_replace("/(?<!\n)\n(?!\n)/", "\n\n", $text);
                        echo kirbytext($text);
                        ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->flow_text_2()->isNotEmpty()): ?>
                    <div class="article-flow-text">
                        <?php 
                        $text = $page->flow_text_2()->value();
                        $text = preg_replace("/(?<!\n)\n(?!\n)/", "\n\n", $text);
                        echo kirbytext($text);
                        ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->headline_1()->isNotEmpty()): ?>
                    <div><?= $page->headline_1() ?></div>
                <?php endif ?>
                
                <?php if ($page->question_answer_block()->isNotEmpty()): ?>
                    <div class="article-qa-block no-question-circles">
                        <?= $page->question_answer_block()->toBlocks() ?>
                    </div>
                <?php endif ?>
                
            </div>
            
            <?php if ($page->related_posts()->isNotEmpty()): ?>
            <div class="article-related-materials mobile-only">
                <div class="related-materials-title">Weiterführende Materialien:</div>
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
                        $isBrochure = $linkedPage->new_category()->value() === 'broschuere-und-information';
                        $showExternalTag = false; // Only show tag for actual external links, not brochures
                        
                        if ($isBrochure) {
                            // Brochure: First try to get PDF file
                            $pdfFile = $linkedPage->files()->first();
                            if ($pdfFile) {
                                $url = $pdfFile->url();
                                $isExternal = true;
                            } else {
                                // No PDF, check for external link in brochure's related posts
                                $hasLink = false;
                                if ($linkedPage->related_posts()->isNotEmpty()) {
                                    $firstBrochurePost = $linkedPage->related_posts()->toStructure()->first();
                                    if ($firstBrochurePost && $firstBrochurePost->external_link()->isNotEmpty()) {
                                        $url = $firstBrochurePost->external_link()->value();
                                        $isExternal = true;
                                        $hasLink = true;
                                    }
                                }
                                // If no link found, set to #
                                if (!$hasLink) {
                                    $url = '#';
                                    $isExternal = false;
                                }
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
                        $showExternalTag = true; // Show tag for actual external links
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
                        'showExternalTag' => $showExternalTag ?? false,
                        'tags' => $tags ?? []
                    ]) ?>
                <?php endforeach ?>
            </div>
            <?php endif ?>
        </div>
    <?php snippet('footer') ?>
    </div>
</body>
</html>

