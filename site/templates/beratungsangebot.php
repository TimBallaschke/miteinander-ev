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
    }
}" 
@scroll.window="isScrolled = (window.pageYOffset > 0)">
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
                
                <?php if ($page->bundesweite_beratungsangebote()->isNotEmpty()): ?>
                    <div class="counseling-section">
                        <div class="counseling-list">
                            <?php foreach ($page->bundesweite_beratungsangebote()->toStructure() as $counseling): ?>
                                <div class="counseling-item">
                                    <h3><?= $counseling->titel_beratungsstelle() ?></h3>
                                    <?php if ($counseling->traeger()->isNotEmpty()): ?>
                                        <div class="counseling-detail">
                                            <?= $counseling->traeger() ?>
                                        </div>
                                    <?php endif ?>
                                    <?php if ($counseling->email()->isNotEmpty()): ?>
                                        <div class="counseling-detail">
                                            <strong>E-Mail:</strong> <a href="mailto:<?= $counseling->email() ?>"><?= $counseling->email() ?></a>
                                        </div>
                                    <?php endif ?>
                                    <?php if ($counseling->telefon()->isNotEmpty()): ?>
                                        <div class="counseling-detail">
                                            <strong>Telefon:</strong> <a href="tel:<?= $counseling->telefon() ?>"><?= $counseling->telefon() ?></a>
                                        </div>
                                    <?php endif ?>
                                    <?php if ($counseling->website()->isNotEmpty()): ?>
                                        <div class="counseling-detail">
                                            <strong>Website:</strong> <a href="<?= $counseling->website() ?>" target="_blank" rel="noopener noreferrer"><?= $counseling->website() ?></a>
                                        </div>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
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

