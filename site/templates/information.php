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
                    <div id="website-title">Rechtsextremismus in Famlilien<br> und Pädagogik begegnen</div>
                    <div class="mobile-menu-plus-button" :class="{ 'unfolded': mobileMenuUnfolded }" @click="mobileMenuUnfolded = !mobileMenuUnfolded">
                        <div class="plus-line-horizontal"></div>
                        <div class="plus-line-vertical"></div>
                    </div>
                </div>
                <?php snippet('list-view-header') ?>
            </div>
            <div id="header-main-small" :class="{ 'scrolled': isScrolled }">
                <div id="website-title-container-small" :class="{ 'scrolled': isScrolled }">
                    <div id="website-title-small">Rechtsextremismus in Famlilien und Pädagogik begegnen</div>
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
                        <?= $page->question_answer_block()->toBlocks() ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->flow_text_2()->isNotEmpty()): ?>
                    <div class="subpage-flow-text">
                        <?php 
                        $text = $page->flow_text_2()->value();
                        $text = preg_replace("/(?<!\n)\n(?!\n)/", "\n\n", $text);
                        echo kirbytext($text);
                        ?>
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
    <?php snippet('footer') ?>
</body>
</html>

