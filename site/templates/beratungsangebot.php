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
                        $html = kirbytext($text);
                        // Remove all &nbsp; entities from the final HTML
                        $html = str_replace('&nbsp;', '', $html);
                        echo $html;
                        ?>
                    </div>
                <?php endif ?>
                
                <?php if ($page->bundesweite_beratungsangebote()->isNotEmpty()): ?>
                    <div class="counseling-section">
                        <div class="bundesland-section">
                            <div class="bundesland-title">Bundesweite Angebote</div>
                            <div class="counseling-list">
                                <?php foreach ($page->bundesweite_beratungsangebote()->toStructure() as $counseling): ?>
                                    <div class="counseling-item">
                                        <div class="counseling-title"><?= $counseling->titel_beratungsstelle() ?></div>
                                        <?php if ($counseling->traeger()->isNotEmpty()): ?>
                                            <div class="counseling-detail">
                                                <span>Träger:</span> <?= $counseling->traeger() ?>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($counseling->email()->isNotEmpty()): ?>
                                            <div class="counseling-detail">
                                                <span>E-Mail:</span> <a href="mailto:<?= $counseling->email() ?>"><?= $counseling->email() ?></a>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($counseling->telefon()->isNotEmpty()): ?>
                                            <div class="counseling-detail">
                                                <span>Telefon:</span> <a href="tel:<?= $counseling->telefon() ?>"><?= $counseling->telefon() ?></a>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($counseling->website()->isNotEmpty()): ?>
                                            <div class="counseling-detail">
                                                <span>Website:</span> <a href="<?= $counseling->website() ?>" target="_blank" rel="noopener noreferrer"><?= $counseling->website() ?></a>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
                
                <?php if ($page->bundeslaender()->isNotEmpty()): ?>
                    <div class="counseling-section">
                        <?php foreach ($page->bundeslaender()->toStructure() as $bundesland): ?>
                            <div class="bundesland-section">
                                <div class="bundesland-title"><?= $bundesland->bundesland() ?></div>
                                <?php if ($bundesland->beratungsstellen()->isNotEmpty()): ?>
                                    <div class="counseling-list">
                                        <?php foreach ($bundesland->beratungsstellen()->toStructure() as $beratungsstelle): ?>
                                            <div class="counseling-item">
                                                <div class="counseling-title"><?= $beratungsstelle->titel() ?></div>
                                                <?php if ($beratungsstelle->email()->isNotEmpty()): ?>
                                                    <div class="counseling-detail">
                                                        <span>E-Mail:</span> <a href="mailto:<?= $beratungsstelle->email() ?>"><?= $beratungsstelle->email() ?></a>
                                                    </div>
                                                <?php endif ?>
                                                <?php if ($beratungsstelle->telefon()->isNotEmpty()): ?>
                                                    <div class="counseling-detail">
                                                        <span>Telefon:</span> <a href="tel:<?= $beratungsstelle->telefon() ?>"><?= $beratungsstelle->telefon() ?></a>
                                                    </div>
                                                <?php endif ?>
                                                <?php if ($beratungsstelle->website()->isNotEmpty()): ?>
                                                    <div class="counseling-detail">
                                                        <span>Website:</span> <a href="<?= $beratungsstelle->website() ?>" target="_blank" rel="noopener noreferrer"><?= $beratungsstelle->website() ?></a>
                                                    </div>
                                                <?php endif ?>
                                                
                                                <?php if ($beratungsstelle->unterberatungsstellen()->isNotEmpty()): ?>
                                                    <div class="sub-counseling-list">
                                                        <?php foreach ($beratungsstelle->unterberatungsstellen()->toStructure() as $unter): ?>
                                                            <div class="counseling-sub-item">
                                                                <div class="counseling-sub-title"><?= $unter->titel() ?></div>
                                                                <?php if ($unter->email()->isNotEmpty()): ?>
                                                                    <div class="counseling-detail">
                                                                        <span>E-Mail:</span> <a href="mailto:<?= $unter->email() ?>"><?= $unter->email() ?></a>
                                                                    </div>
                                                                <?php endif ?>
                                                                <?php if ($unter->telefon()->isNotEmpty()): ?>
                                                                    <div class="counseling-detail">
                                                                        <span>Telefon:</span> <a href="tel:<?= $unter->telefon() ?>"><?= $unter->telefon() ?></a>
                                                                    </div>
                                                                <?php endif ?>
                                                                <?php if ($unter->website()->isNotEmpty()): ?>
                                                                    <div class="counseling-detail">
                                                                        <span>Website:</span> <a href="<?= $unter->website() ?>" target="_blank" rel="noopener noreferrer"><?= $unter->website() ?></a>
                                                                    </div>
                                                                <?php endif ?>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                <?php endif ?>
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

