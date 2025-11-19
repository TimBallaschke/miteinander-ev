<!DOCTYPE html>
<html lang="de">
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
    <?php snippet('footer') ?>
</body>
</html>