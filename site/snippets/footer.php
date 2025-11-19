<?php 
$footerPage = page('footer');
?>
<footer id="footer">
    <div id="footer-content">
        <div class="footer-sender">
            <?php if ($footerPage && $footerPage->sender()->isNotEmpty()): ?>
                <div class="footer-sender-text">
                    <?= $footerPage->sender()->kt() ?>
                </div>
            <?php endif ?>
            <a class="footer-sender-link" href="<?= page('impressum-und-datenschutz')?->url() ?? '#' ?>" id="imprint-button">
                Impressum und Datenschutz
            </a>
        </div>
        
        <?php if ($footerPage && $footerPage->logos()->isNotEmpty()): ?>
            <div class="footer-logos">
                <?php foreach ($footerPage->logos()->toStructure() as $logo): ?>
                    <?php if ($logo->logo_file()->isNotEmpty()): ?>
                        <?php $logoFile = $logo->logo_file()->toFile(); ?>
                        <?php if ($logoFile): ?>
                            <?php if ($logo->logo_link()->isNotEmpty()): ?>
                                <a href="<?= $logo->logo_link() ?>" target="_blank" rel="noopener noreferrer">
                                    <img src="<?= $logoFile->url() ?>" alt="<?= $logo->logo_title() ?>" class="footer-logo-image">
                                </a>
                            <?php else: ?>
                                <img src="<?= $logoFile->url() ?>" alt="<?= $logo->logo_title() ?>" class="footer-logo-image">
                            <?php endif ?>
                        <?php endif ?>
                    <?php endif ?>
                    
                    <div class="footer-logo-title"><?= $logo->logo_title() ?></div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</footer>

