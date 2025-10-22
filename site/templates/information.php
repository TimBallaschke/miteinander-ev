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
        const menuHeightRem = getComputedStyle(document.documentElement).getPropertyValue('--top-menu-element-height').trim();
        const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);
        const menuHeightPx = parseFloat(menuHeightRem) * rootFontSize;
        this.scrollThreshold = menuHeightPx * 4;
        
        // Watch scroll state
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
                <?php if ($page->flow_text_1()->isNotEmpty()): ?>
                    <div class="content-flow-text">
                        <?= $page->flow_text_1()->kt() ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->question_answer_block()->isNotEmpty()): ?>
                    <div class="content-qa-block">
                        <?= $page->question_answer_block()->toBlocks() ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->flow_text_2()->isNotEmpty()): ?>
                    <div class="content-flow-text">
                        <?= $page->flow_text_2()->kt() ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->content_blocks_2()->isNotEmpty()): ?>
                    <div class="content-blocks">
                        <?php foreach ($page->content_blocks_2()->toStructure() as $block): ?>
                            <div class="content-block">
                                <?php if ($block->question()->isNotEmpty()): ?>
                                    <h3><?= $block->question() ?></h3>
                                <?php endif ?>
                                <?php if ($block->answers()->isNotEmpty()): ?>
                                    <div class="content-block-answers">
                                        <?php foreach ($block->answers()->toStructure() as $answer): ?>
                                            <div class="content-block-answer <?= $answer->highlight()->toBool() ? 'highlighted' : '' ?>">
                                                <?= $answer->text()->kt() ?>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>
</html>

