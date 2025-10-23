<!DOCTYPE html>
<html lang="en">
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
    init() {
        this.$watch('audience', (value) => {
            if (value === 'teacher') {
                this.teacherTypes = ['school', 'kita', 'social'];
            } else {
                this.teacherTypes = [];
            }
        });
        
        // Calculate scroll threshold: 4x the CSS variable --top-menu-element-height
        // Get the value in rem and convert to pixels
        const menuHeightRem = getComputedStyle(document.documentElement).getPropertyValue('--top-menu-element-height').trim();
        const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);
        const menuHeightPx = parseFloat(menuHeightRem) * rootFontSize;
        this.scrollThreshold = menuHeightPx * 4;
        
        console.log('Scroll threshold set to:', this.scrollThreshold, 'px');
        
        // Watch scroll state and log to console
        this.$watch('isScrolled', (value) => {
            if (value) {
                console.log('Page is scrolled down');
            } else {
                console.log('Page is at the top');
            }
        });
    }
}" 
@scroll.window="isScrolled = (window.pageYOffset > scrollThreshold)">
    <?php snippet('sidebar') ?>
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
            <div id="article-content">
                <h1><?= $page->title() ?></h1>
                
                <?php if ($page->intro_text()->isNotEmpty()): ?>
                    <div class="article-intro">
                        <?= $page->intro_text()->kt() ?>
                    </div>
                <?php endif ?>
                
                <div class="article-meta">
                    <?php if ($page->publisher()->isNotEmpty()): ?>
                        <div><strong>Herausgeber*in:</strong> <?= $page->publisher() ?></div>
                    <?php endif ?>
                    <?php if ($page->year()->isNotEmpty()): ?>
                        <div><strong>Jahr:</strong> <?= $page->year() ?></div>
                    <?php endif ?>
                </div>
                
                <?php if ($page->disclaimer()->isNotEmpty()): ?>
                    <div class="article-disclaimer">
                        <?= $page->disclaimer()->kt() ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->flow_text_1()->isNotEmpty()): ?>
                    <div class="article-flow-text">
                        <?= $page->flow_text_1()->kt() ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->headline_1()->isNotEmpty()): ?>
                    <h2><?= $page->headline_1() ?></h2>
                <?php endif ?>
                
                <?php if ($page->question_answer_block()->isNotEmpty()): ?>
                    <div class="article-qa-block">
                        <?= $page->question_answer_block()->toBlocks() ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->images()->isNotEmpty()): ?>
                    <div class="article-images">
                        <?php foreach ($page->images() as $image): ?>
                            <figure>
                                <img src="<?= $image->url() ?>" alt="<?= $image->alt() ?>">
                                <?php if ($image->caption()->isNotEmpty()): ?>
                                    <figcaption><?= $image->caption() ?></figcaption>
                                <?php endif ?>
                            </figure>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>
</html>

