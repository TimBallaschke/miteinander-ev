<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miteinander e.V.</title>
    <link rel="stylesheet" href="<?= url('assets/style/style.css') ?>?v=3">
    <script src="<?= url('assets/js/alpine.min.js') ?>" defer></script>
</head>
<body x-data="{ view: 'grid' }">
    <div id="sidebar">
        <div id="top-menu">
            <div class="top-menu-element-container">
                <div class="top-menu-element">Inhalte</div>
            </div>
            <div class="top-menu-element-container">
                <div class="top-menu-element">Informationen</div>
            </div>
            <div class="top-menu-element-container">
                <div class="top-menu-element">Beratungsangebote</div>
            </div>
            <div class="top-menu-element-container">
                <div class="top-menu-element">Kontakt</div>
            </div>
        </div>
        <div class="sidebar-options">
            <div class="options-container">
                <div class="options-title">Ansicht:</div>
                <div id="view-switch" class="options-element">
                    <button @click="view = 'grid'" :class="{ 'active': view === 'grid' }">Grid</button>
                    <button @click="view = 'list'" :class="{ 'active': view === 'list' }">List</button>
                </div>
            </div>
        </div>
    </div>
    <div id="main">
        <div id="website-title-container">
            <div id="website-title">Rechtsextremismus in Famlilien<br> und Pädagogik begegnen</div>
        </div>
        <div id="content" :class="view">
            <div class="article-container">
                <div class="article-headline">Extrem rechtes Elternhaus</div>
                <div class="article-teaser-text">
                    what if I wanted to make this some kind of component as it gets repeated multiple times. There will be multiple options-container always with a title element and a options element. Would it make sense to use alpine.js for this? Please do not implement any code but explain to me if this would make sense.
                </div>
                <div class="article-tags"></div>
            </div>
        </div>
    </div>  
</body>
</html>