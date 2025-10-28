<div class="mobile-menu-header top-menu" :class="{ 'mobile-menu-unfolded': mobileMenuUnfolded }">
    <div class="mobile-menu-content">
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
    </div>
</div>

