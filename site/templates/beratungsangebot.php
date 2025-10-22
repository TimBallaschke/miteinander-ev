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
                
                <?php if ($page->bundesweite_beratungsangebote()->isNotEmpty()): ?>
                    <div class="counseling-section">
                        <h2>Bundesweite Beratungsangebote</h2>
                        <div class="counseling-list">
                            <?php foreach ($page->bundesweite_beratungsangebote()->toStructure() as $counseling): ?>
                                <div class="counseling-item">
                                    <h3><?= $counseling->titel_beratungsstelle() ?></h3>
                                    <?php if ($counseling->traeger()->isNotEmpty()): ?>
                                        <div class="counseling-detail">
                                            <strong>Träger:</strong> <?= $counseling->traeger() ?>
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
                        <h2>Beratungsangebote nach Bundesland</h2>
                        <?php foreach ($page->bundeslaender()->toStructure() as $bundesland): ?>
                            <div class="bundesland-section">
                                <h3><?= $bundesland->bundesland() ?></h3>
                                <?php if ($bundesland->beratungsstellen()->isNotEmpty()): ?>
                                    <div class="counseling-list">
                                        <?php foreach ($bundesland->beratungsstellen()->toStructure() as $beratungsstelle): ?>
                                            <div class="counseling-item">
                                                <h4><?= $beratungsstelle->titel() ?></h4>
                                                <?php if ($beratungsstelle->email()->isNotEmpty()): ?>
                                                    <div class="counseling-detail">
                                                        <strong>E-Mail:</strong> <a href="mailto:<?= $beratungsstelle->email() ?>"><?= $beratungsstelle->email() ?></a>
                                                    </div>
                                                <?php endif ?>
                                                <?php if ($beratungsstelle->telefon()->isNotEmpty()): ?>
                                                    <div class="counseling-detail">
                                                        <strong>Telefon:</strong> <a href="tel:<?= $beratungsstelle->telefon() ?>"><?= $beratungsstelle->telefon() ?></a>
                                                    </div>
                                                <?php endif ?>
                                                <?php if ($beratungsstelle->website()->isNotEmpty()): ?>
                                                    <div class="counseling-detail">
                                                        <strong>Website:</strong> <a href="<?= $beratungsstelle->website() ?>" target="_blank" rel="noopener noreferrer"><?= $beratungsstelle->website() ?></a>
                                                    </div>
                                                <?php endif ?>
                                                
                                                <?php if ($beratungsstelle->unterberatungsstellen()->isNotEmpty()): ?>
                                                    <div class="sub-counseling-list">
                                                        <?php foreach ($beratungsstelle->unterberatungsstellen()->toStructure() as $unter): ?>
                                                            <div class="counseling-sub-item">
                                                                <h5><?= $unter->titel() ?></h5>
                                                                <?php if ($unter->email()->isNotEmpty()): ?>
                                                                    <div class="counseling-detail">
                                                                        <strong>E-Mail:</strong> <a href="mailto:<?= $unter->email() ?>"><?= $unter->email() ?></a>
                                                                    </div>
                                                                <?php endif ?>
                                                                <?php if ($unter->telefon()->isNotEmpty()): ?>
                                                                    <div class="counseling-detail">
                                                                        <strong>Telefon:</strong> <a href="tel:<?= $unter->telefon() ?>"><?= $unter->telefon() ?></a>
                                                                    </div>
                                                                <?php endif ?>
                                                                <?php if ($unter->website()->isNotEmpty()): ?>
                                                                    <div class="counseling-detail">
                                                                        <strong>Website:</strong> <a href="<?= $unter->website() ?>" target="_blank" rel="noopener noreferrer"><?= $unter->website() ?></a>
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
</body>
</html>

