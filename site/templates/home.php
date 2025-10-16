<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miteinander e.V.</title>
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
    init() {
        this.$watch('audience', (value) => {
            if (value === 'teacher') {
                this.teacherTypes = ['school', 'kita', 'social'];
            } else {
                this.teacherTypes = [];
            }
        });
        
        // Calculate scroll threshold: 4x the CSS variable --top-menu-element-height
        // Get the value in rem and convert to pixels
        const menuHeightRem = getComputedStyle(document.documentElement).getPropertyValue('--top-menu-element-height').trim();
        const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);
        const menuHeightPx = parseFloat(menuHeightRem) * rootFontSize;
        this.scrollThreshold = menuHeightPx * 4;
        
        console.log('Scroll threshold set to:', this.scrollThreshold, 'px');
        
        // Watch scroll state and log to console
        this.$watch('isScrolled', (value) => {
            if (value) {
                console.log('Page is scrolled down');
            } else {
                console.log('Page is at the top');
            }
        });
    }
}" 
@scroll.window="isScrolled = (window.pageYOffset > 0)">
    <?php
    // Calculate tag counts before rendering sidebar
    $fallbeispiele = page('fallbeispiele')?->children()->listed();
    $methoden = page('methoden')?->children()->listed();
    $broschueren = page('broschueren-und-informationen')?->children()->listed();
    
    $allArticles = new Pages([]);
    if ($fallbeispiele) $allArticles = $allArticles->add($fallbeispiele);
    if ($methoden) $allArticles = $allArticles->add($methoden);
    if ($broschueren) $allArticles = $allArticles->add($broschueren);
    
    $tagCounts = [];
    foreach ($allArticles as $article) {
        if ($article->new_category()->isNotEmpty()) {
            $key = $article->new_category()->value();
            $tagCounts[$key] = ($tagCounts[$key] ?? 0) + 1;
        }
        if ($article->category()->isNotEmpty()) {
            $key = $article->category()->value();
            $tagCounts[$key] = ($tagCounts[$key] ?? 0) + 1;
        }
        if ($article->subcategory()->isNotEmpty()) {
            $key = $article->subcategory()->value();
            $tagCounts[$key] = ($tagCounts[$key] ?? 0) + 1;
        }
    }
    
    $GLOBALS['tagCounts'] = $tagCounts;
    $GLOBALS['totalArticles'] = $allArticles->count();
    ?>
    <?php snippet('sidebar') ?>
    <?php snippet('main') ?>
</body>
</html>