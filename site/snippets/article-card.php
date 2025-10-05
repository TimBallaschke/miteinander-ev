<div class="article-container" 
    x-data="{ 
        articleTags: <?= $filterKeys ?? '[]' ?>,
        searchableText: <?= $searchableText ?? '""' ?>
    }"
    x-show="
        // Search filter
        (searchQuery === '' || searchableText.includes(searchQuery.toLowerCase())) &&
        
        // Content type filter
        (content === 'all' || 
         (content === 'case-studies' && articleTags.includes('fallbeispiele')) ||
         (content === 'brochures' && articleTags.includes('broschuere-und-information')) ||
         (content === 'methods' && articleTags.includes('methoden'))) &&
        
        // Audience filter
        (audience === 'all' || 
         (audience === 'teacher' && articleTags.includes('paedagogische-fachkraft')) ||
         (audience === 'parents' && articleTags.includes('eltern-und-angehoerige'))) &&
        
        // Teacher subcategory filter (only active when teacher is selected)
        (audience !== 'teacher' || (teacherTypes.length > 0 && 
         teacherTypes.some(type => 
            (type === 'school' && articleTags.includes('schule')) ||
            (type === 'kita' && articleTags.includes('kita')) ||
            (type === 'social' && articleTags.includes('sozialarbeit'))
         )))
    ">
    <div class="article-headline"><?= $headline ?? '' ?></div>
    <div class="article-teaser-text">
        <?= $teaser ?? '' ?>
    </div>
    <?php if (isset($publisher) && !empty($publisher)): ?>
        <div class="article-publisher"><?= $publisher ?></div>
    <?php endif ?>
    <div class="article-tags">
        <?php if (isset($tags) && !empty($tags)): ?>
            <?php foreach ($tags as $tag): ?>
                <div class="article-tag <?= $tag['color'] ?? '' ?>"><?= $tag['label'] ?? $tag ?></div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

