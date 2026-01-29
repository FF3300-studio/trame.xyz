<div class="blocks-container">
    <div class="blocks-container-inner">
        <!-- FILTRI -->
        <?php snippet('collection-filters',[
            'logic' => 'and' // oppure 'or'
        ]); ?>
        <!-- GRIGLIA -->
        <?php snippet('collection-grid',[
            'collection' => $collection,
            'category_color' => false,
        ]) ?>
    </div>
</div>


