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
                
                <?php if ($page->impressum_sections()->isNotEmpty()): ?>
                    <div class="impressum-section">
                        <h2>Impressum</h2>
                        <?php foreach ($page->impressum_sections()->toStructure() as $section): ?>
                            <div class="impressum-block">
                                <?php if ($section->title()->isNotEmpty()): ?>
                                    <h3><?= $section->title() ?></h3>
                                <?php endif ?>
                                <?php if ($section->text()->isNotEmpty()): ?>
                                    <div class="impressum-text">
                                        <?php 
                                        $text = $section->text()->value();
                                        $text = preg_replace("/(?<!\n)\n(?!\n)/", "\n\n", $text);
                                        echo kirbytext($text);
                                        ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->datenschutz_sections()->isNotEmpty()): ?>
                    <div class="datenschutz-section">
                        <h2>Datenschutz</h2>
                        <?php foreach ($page->datenschutz_sections()->toStructure() as $section): ?>
                            <div class="datenschutz-block">
                                <?php if ($section->title()->isNotEmpty()): ?>
                                    <h3><?= $section->title() ?></h3>
                                <?php endif ?>
                                <?php if ($section->text()->isNotEmpty()): ?>
                                    <div class="datenschutz-text">
                                        <?php 
                                        $text = $section->text()->value();
                                        $text = preg_replace("/(?<!\n)\n(?!\n)/", "\n\n", $text);
                                        echo kirbytext($text);
                                        ?>
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

