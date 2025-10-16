<!DOCTYPE html>
<html lang="en">
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
@scroll.window="isScrolled = (window.pageYOffset > 0)">
    <?php snippet('sidebar') ?>
    <div id="main" class="list">
        <div id="header-main">
            <div id="header-main-large" :class="{ 'scrolled': isScrolled }">
                <div id="website-title-container" :class="{ 'scrolled': isScrolled }">
                    <div id="website-title"><?= $page->page_title() ?></div>
                </div>
            </div>
            <div id="header-main-small" :class="{ 'scrolled': isScrolled }">
                <div id="website-title-container-small" :class="{ 'scrolled': isScrolled }">
                    <div id="website-title-small"><?= $page->page_title() ?></div>
                </div>
            </div>
        </div>
        <div id="content">
            <div id="article-content">
                <h1><?= $page->page_title() ?></h1>
                
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
                
                <?php if ($page->related_posts()->isNotEmpty()): ?>
                    <div class="article-related-posts">
                        <h2>Weiterführende Materialien</h2>
                        <ul>
                            <?php foreach ($page->related_posts()->toStructure() as $link): ?>
                                <li>
                                    <?php if ($link->type()->value() === 'internal'): ?>
                                        <?php $linkedPage = $link->internal_link()->toPage() ?>
                                        <?php if ($linkedPage): ?>
                                            <a href="<?= $linkedPage->url() ?>">
                                                <?= $link->internal_link_title() ?>
                                            </a>
                                        <?php endif ?>
                                    <?php elseif ($link->type()->value() === 'external'): ?>
                                        <a href="<?= $link->external_link() ?>" target="_blank" rel="noopener noreferrer">
                                            <?= $link->external_link_title() ?>
                                        </a>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>
</html>

