<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - Miteinander e.V.</title>
    <link rel="stylesheet" href="<?= url('assets/style/style.css') ?>?v=<?= filemtime(kirby()->root('index') . '/assets/style/style.css') ?>">
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
                <?php if ($page->flow_text()->isNotEmpty()): ?>
                    <div class="subpage-flow-text">
                        <?php 
                        $text = $page->flow_text()->value();
                        $text = preg_replace("/(?<!\n)\n(?!\n)/", "\n\n", $text);
                        $html = kirbytext($text);
                        // Remove all &nbsp; entities from the final HTML
                        $html = str_replace('&nbsp;', '', $html);
                        echo $html;
                        ?>
                    </div>
                <?php endif ?>
                
                <div class="contact-section">
                    <?php if ($page->projekt_1_name()->isNotEmpty()): ?>
                        <div class="contact-project-section">
                            <div class="contact-project-title"><?= $page->projekt_1_name() ?></div>
                            <div class="contact-project-details">
                                <?php if ($page->projekt_1_adresse()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">Adresse:</div>
                                        <div class="contact-detail-content">
                                            <?= nl2br($page->projekt_1_adresse()) ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_1_telefon()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">Telefon:</div>
                                        <div class="contact-detail-content">
                                            <a href="tel:<?= preg_replace('/[^\d+]/', '', $page->projekt_1_telefon()) ?>"><?= $page->projekt_1_telefon() ?></a>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_1_emails()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">E-Mail:</div>
                                        <div class="contact-detail-content">
                                            <?php foreach ($page->projekt_1_emails()->toStructure() as $email): ?>
                                                <a href="mailto:<?= $email->email() ?>"><?= $email->email() ?></a><br>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_1_website()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">Website:</div>
                                        <div class="contact-detail-content">
                                            <a href="<?= $page->projekt_1_website() ?>" target="_blank" rel="noopener noreferrer"><?= $page->projekt_1_website() ?></a>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_1_socials()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">Social Media:</div>
                                        <div class="contact-detail-content">
                                            <?php foreach ($page->projekt_1_socials()->toStructure() as $social): ?>
                                                <?php 
                                                $platform = $social->plattform()->value();
                                                // Map platform values to display names
                                                $platformNames = [
                                                    'andere' => 'Bluesky',
                                                    'bluesky' => 'Bluesky',
                                                ];
                                                $displayName = $platformNames[$platform] ?? ucfirst($platform);
                                                ?>
                                                <a href="<?= $social->url() ?>" target="_blank" rel="noopener noreferrer">
                                                    <?= $displayName ?>
                                                </a><br>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endif ?>
                    
                    <?php if ($page->projekt_2_name()->isNotEmpty()): ?>
                        <div class="contact-project-section">
                            <div class="contact-project-title"><?= $page->projekt_2_name() ?></div>
                            <div class="contact-project-details">
                                <?php if ($page->projekt_2_adresse()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">Adresse:</div>
                                        <div class="contact-detail-content">
                                            <?= nl2br($page->projekt_2_adresse()) ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_2_telefon()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">Telefon:</div>
                                        <div class="contact-detail-content">
                                            <a href="tel:<?= preg_replace('/[^\d+]/', '', $page->projekt_2_telefon()) ?>"><?= $page->projekt_2_telefon() ?></a>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_2_emails()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">E-Mail:</div>
                                        <div class="contact-detail-content">
                                        <?php foreach ($page->projekt_2_emails()->toStructure() as $email): ?>
                                                <a href="mailto:<?= $email->email() ?>"><?= $email->email() ?></a><br>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_2_website()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">Website:</div>
                                        <div class="contact-detail-content">
                                            <a href="<?= $page->projekt_2_website() ?>" target="_blank" rel="noopener noreferrer"><?= $page->projekt_2_website() ?></a>
                                        </div>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_2_socials()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <div class="contact-detail-title">Social Media:</div>
                                        <div class="contact-detail-content">
                                        <?php foreach ($page->projekt_2_socials()->toStructure() as $social): ?>
                                            <?php 
                                            $platform = $social->plattform()->value();
                                            // Map platform values to display names
                                            $platformNames = [
                                                'andere' => 'Bluesky',
                                                'bluesky' => 'Bluesky',
                                            ];
                                            $displayName = $platformNames[$platform] ?? ucfirst($platform);
                                            ?>
                                            <a href="<?= $social->url() ?>" target="_blank" rel="noopener noreferrer">
                                                <?= $displayName ?>
                                                </a><br>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <?php snippet('footer') ?>
</body>
</html>

