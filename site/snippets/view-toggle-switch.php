<div class="view-toggle-switch" @click="view = view === 'grid' ? 'list' : 'grid'">
    <div class="toggle-track">
        <div class="toggle-pill" :class="{ 'list-active': view === 'list' }"></div>
        <div 
            class="toggle-option toggle-option-1" 
            :class="{ 'active': view === 'grid' }">
            Kachel
        </div>
        <div 
            class="toggle-option toggle-option-2" 
            :class="{ 'active': view === 'list' }">
            Liste
        </div>
    </div>
</div>

