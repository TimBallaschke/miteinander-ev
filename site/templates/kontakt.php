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
                    <div id="website-title">Kontakt</div>
                </div>
            </div>
            <div id="header-main-small" :class="{ 'scrolled': isScrolled }">
                <div id="website-title-container-small" :class="{ 'scrolled': isScrolled }">
                    <div id="website-title-small">Kontakt</div>
                </div>
            </div>
        </div>
        <div id="content">
            <div id="article-content">
                <?php if ($page->flow_text()->isNotEmpty()): ?>
                    <div class="content-flow-text">
                        <?= $page->flow_text()->kt() ?>
                    </div>
                <?php endif ?>
                
                <div class="contact-projects">
                    <?php if ($page->projekt_1_name()->isNotEmpty()): ?>
                        <div class="contact-project">
                            <h2><?= $page->projekt_1_name() ?></h2>
                            
                            <?php if ($page->projekt_1_adresse()->isNotEmpty()): ?>
                                <div class="contact-detail">
                                    <strong>Adresse:</strong><br>
                                    <?= nl2br($page->projekt_1_adresse()) ?>
                                </div>
                            <?php endif ?>
                            
                            <?php if ($page->projekt_1_emails()->isNotEmpty()): ?>
                                <div class="contact-detail">
                                    <strong>E-Mail:</strong><br>
                                    <?php foreach ($page->projekt_1_emails()->toStructure() as $email): ?>
                                        <a href="mailto:<?= $email->email() ?>"><?= $email->email() ?></a><br>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                            
                            <?php if ($page->projekt_1_website()->isNotEmpty()): ?>
                                <div class="contact-detail">
                                    <strong>Website:</strong><br>
                                    <a href="<?= $page->projekt_1_website() ?>" target="_blank" rel="noopener noreferrer"><?= $page->projekt_1_website() ?></a>
                                </div>
                            <?php endif ?>
                            
                            <?php if ($page->projekt_1_socials()->isNotEmpty()): ?>
                                <div class="contact-detail">
                                    <strong>Social Media:</strong><br>
                                    <?php foreach ($page->projekt_1_socials()->toStructure() as $social): ?>
                                        <a href="<?= $social->url() ?>" target="_blank" rel="noopener noreferrer">
                                            <?= ucfirst($social->plattform()->value()) ?>
                                        </a><br>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                    
                    <?php if ($page->projekt_2_name()->isNotEmpty()): ?>
                        <div class="contact-project">
                            <h2><?= $page->projekt_2_name() ?></h2>
                            
                            <?php if ($page->projekt_2_adresse()->isNotEmpty()): ?>
                                <div class="contact-detail">
                                    <strong>Adresse:</strong><br>
                                    <?= nl2br($page->projekt_2_adresse()) ?>
                                </div>
                            <?php endif ?>
                            
                            <?php if ($page->projekt_2_emails()->isNotEmpty()): ?>
                                <div class="contact-detail">
                                    <strong>E-Mail:</strong><br>
                                    <?php foreach ($page->projekt_2_emails()->toStructure() as $email): ?>
                                        <a href="mailto:<?= $email->email() ?>"><?= $email->email() ?></a><br>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                            
                            <?php if ($page->projekt_2_website()->isNotEmpty()): ?>
                                <div class="contact-detail">
                                    <strong>Website:</strong><br>
                                    <a href="<?= $page->projekt_2_website() ?>" target="_blank" rel="noopener noreferrer"><?= $page->projekt_2_website() ?></a>
                                </div>
                            <?php endif ?>
                            
                            <?php if ($page->projekt_2_socials()->isNotEmpty()): ?>
                                <div class="contact-detail">
                                    <strong>Social Media:</strong><br>
                                    <?php foreach ($page->projekt_2_socials()->toStructure() as $social): ?>
                                        <a href="<?= $social->url() ?>" target="_blank" rel="noopener noreferrer">
                                            <?= ucfirst($social->plattform()->value()) ?>
                                        </a><br>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

