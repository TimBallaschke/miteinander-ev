<div id="main" :class="view">
    <div id="header-main">
        <div id="website-title-container">
            <div id="website-title">Rechtsextremismus in Famlilien<br> und Pädagogik begegnen</div>
        </div>
        <div id="list-view-header-container">
            <div id="list-view-header">
                <div class="list-view-header-item">Titel</div>
                <div class="list-view-header-item">Herausgeber*in</div>
                <div class="list-view-header-item">Zielgruppe</div>
                <div class="list-view-header-item">Art des Inhalts</div>
            </div>
        </div>
    </div>
    <div id="content" :class="view">
        <?php 
        // Get all articles from the three main sections
        $fallbeispiele = page('fallbeispiele')?->children()->listed();
        $methoden = page('methoden')?->children()->listed();
        $broschueren = page('broschueren-und-informationen')?->children()->listed();
        
        // Combine all articles into one collection
        $allArticles = new Pages([]);
        if ($fallbeispiele) $allArticles = $allArticles->add($fallbeispiele);
        if ($methoden) $allArticles = $allArticles->add($methoden);
        if ($broschueren) $allArticles = $allArticles->add($broschueren);
        
        // Loop through all articles and display them
        foreach ($allArticles as $article): 
        ?>
            <?php snippet('article-card', [
                'headline' => $article->page_title()->value(),
                'teaser' => '',
                'tags' => []
            ]) ?>
        <?php endforeach ?>
    </div>
</div>

