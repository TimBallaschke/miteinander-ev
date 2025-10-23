<?php 
$footerPage = page('footer');
$logoTitles = [];
?>
<footer id="footer">
    <div id="footer-content">
        <div class="footer-sender">
            <?php if ($footerPage && $footerPage->sender()->isNotEmpty()): ?>
                <?= $footerPage->sender()->kt() ?>
            <?php endif ?>
            <a href="<?= page('impressum-und-datenschutz')?->url() ?? '#' ?>" id="imprint-button">
                Impressum und Datenschutz
            </a>
        </div>
        
        <?php if ($footerPage && $footerPage->logos()->isNotEmpty()): ?>
            <div class="footer-logos">
                <?php foreach ($footerPage->logos()->toStructure() as $logo): ?>
                    <?php
                    // Collect logo titles for later
                    if ($logo->logo_title()->isNotEmpty()) {
                        $logoTitles[] = $logo->logo_title()->value();
                    }
                    ?>
                    <div class="footer-logo-item">
                        <?php if ($logo->logo_file()->isNotEmpty()): ?>
                            <?php $logoFile = $logo->logo_file()->toFile(); ?>
                            <?php if ($logoFile): ?>
                                <?php if ($logoFile->extension() === 'pdf'): ?>
                                    <a href="<?= $logoFile->url() ?>" target="_blank" rel="noopener noreferrer" class="footer-logo-link">
                                        <div class="footer-logo-pdf">PDF</div>
                                    </a>
                                <?php else: ?>
                                    <img src="<?= $logoFile->url() ?>" alt="<?= $logo->logo_title() ?>" class="footer-logo-image">
                                <?php endif ?>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
        
        <?php if (!empty($logoTitles)): ?>
            <div class="logo-titles-bottom">
                <?php foreach ($logoTitles as $title): ?>
                    <div class="logo-title-item"><?= $title ?></div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</footer>

