<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - Miteinander e.V.</title>
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
                    'label' => 'Informationen',
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
                <?php if ($page->flow_text()->isNotEmpty()): ?>
                    <div class="subpage-flow-text">
                        <?php 
                        $text = $page->flow_text()->value();
                        $text = preg_replace("/(?<!\n)\n(?!\n)/", "\n\n", $text);
                        echo kirbytext($text);
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
                                        <span>Adresse:</span><br>
                                        <?= nl2br($page->projekt_1_adresse()) ?>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_1_emails()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <span>E-Mail:</span><br>
                                        <?php foreach ($page->projekt_1_emails()->toStructure() as $email): ?>
                                            <a href="mailto:<?= $email->email() ?>"><?= $email->email() ?></a><br>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_1_website()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <span>Website:</span><br>
                                        <a href="<?= $page->projekt_1_website() ?>" target="_blank" rel="noopener noreferrer"><?= $page->projekt_1_website() ?></a>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_1_socials()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <span>Social Media:</span><br>
                                        <?php foreach ($page->projekt_1_socials()->toStructure() as $social): ?>
                                            <a href="<?= $social->url() ?>" target="_blank" rel="noopener noreferrer">
                                                <?= ucfirst($social->plattform()->value()) ?>
                                            </a><br>
                                        <?php endforeach ?>
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
                                        <span>Adresse:</span><br>
                                        <?= nl2br($page->projekt_2_adresse()) ?>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_2_emails()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <span>E-Mail:</span><br>
                                        <?php foreach ($page->projekt_2_emails()->toStructure() as $email): ?>
                                            <a href="mailto:<?= $email->email() ?>"><?= $email->email() ?></a><br>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_2_website()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <span>Website:</span><br>
                                        <a href="<?= $page->projekt_2_website() ?>" target="_blank" rel="noopener noreferrer"><?= $page->projekt_2_website() ?></a>
                                    </div>
                                <?php endif ?>
                                
                                <?php if ($page->projekt_2_socials()->isNotEmpty()): ?>
                                    <div class="contact-detail">
                                        <span>Social Media:</span><br>
                                        <?php foreach ($page->projekt_2_socials()->toStructure() as $social): ?>
                                            <a href="<?= $social->url() ?>" target="_blank" rel="noopener noreferrer">
                                                <?= ucfirst($social->plattform()->value()) ?>
                                            </a><br>
                                        <?php endforeach ?>
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

