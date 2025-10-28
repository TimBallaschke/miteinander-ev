<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->page_title() ?> - Miteinander e.V.</title>
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
    <div id="sidebar" class="no-sidebar">
        <div id="top-menu" :class="{ 'scrolled': isScrolled, 'menu-unfolded': menuUnfolded }">
            <div id="top-menu-content">
                <?php snippet('menu-item', [
                    'label' => 'Inhalte',
                    'url' => url(),
                    'active' => $page->isHomePage() || $page->template()->name() === 'fallbeispiel' || $page->template()->name() === 'methode'
                ]) ?>
                <?php snippet('menu-item', [
                    'label' => 'Grundlagen & Kontext',
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
    </div>
    <div id="main" class="no-sidebar" :class="view">
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
            <div class="subpage-content">
                <div class="subpage-title"><?= $page->title() ?></div>
                <?php if ($page->flow_text_1()->isNotEmpty()): ?>
                    <div class="subpage-flow-text">
                        <?php 
                        $text = $page->flow_text_1()->value();
                        $text = preg_replace("/(?<!\n)\n(?!\n)/", "\n\n", $text);
                        echo kirbytext($text);
                        ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->question_answer_block()->isNotEmpty()): ?>
                    <div class="article-qa-block">
                        <?php 
                        // Get the HTML output from blocks
                        $blocksHtml = (string)$page->question_answer_block()->toBlocks();
                        
                        // Split by h2 tags, keeping the h2 in the split
                        $parts = preg_split('/(<h2[^>]*>.*?<\/h2>)/is', $blocksHtml, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
                        
                        $sections = [];
                        for ($i = 0; $i < count($parts); $i++) {
                            // Check if this part is an h2
                            if (preg_match('/<h2[^>]*>.*?<\/h2>/is', $parts[$i])) {
                                // This is a heading, next part should be content
                                $sections[] = [
                                    'heading' => $parts[$i],
                                    'content' => isset($parts[$i + 1]) ? $parts[$i + 1] : ''
                                ];
                                $i++; // Skip the content part in next iteration
                            }
                        }
                        
                        // If no sections were found, just output the original HTML
                        if (empty($sections)) {
                            echo $blocksHtml;
                        } else {
                            // Output each section with collapsible functionality
                            foreach ($sections as $index => $section):
                                $sectionId = 'section_' . $index;
                                
                                // Extract plain text from content for truncation
                                $contentText = strip_tags($section['content']);
                                $words = preg_split('/\s+/u', trim($contentText), -1, PREG_SPLIT_NO_EMPTY);
                                $truncatedWords = array_slice($words, 0, 20);
                                $truncatedText = implode(' ', $truncatedWords);
                                
                                // Add "mehr lesen" if there are more than 20 words
                                $hasMoreText = count($words) > 20;
                            ?>
                                <div x-data="{ <?= $sectionId ?>Unfolded: false }">
                                    <?= $section['heading'] ?>
                                    
                                    <div class="qa-section-content" :class="{ 'unfolded': <?= $sectionId ?>Unfolded }" @click="<?= $sectionId ?>Unfolded = !<?= $sectionId ?>Unfolded">
                                        <div x-show="!<?= $sectionId ?>Unfolded">
                                            <p><?= $truncatedText ?><?php if ($hasMoreText): ?> ... <em class="read-more-toggle">(mehr lesen)</em><?php endif; ?></p>
                                        </div>
                                        <div x-show="<?= $sectionId ?>Unfolded">
                                            <?= $section['content'] ?>
                                            <p><em class="read-more-toggle">(weniger lesen)</em></p>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                            endforeach;
                        }
                        ?>
                    </div>
                <?php endif ?>
                
            </div>
        </div>
    </div>
    <?php snippet('footer') ?>
</body>
</html>

