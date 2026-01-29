        <?php foreach($tutte_le_categorie as $cat_item): ?>
            <?php 
            $catName = ($p = $cat_item->nome()->toPage()) ? $p->title()->value() : $cat_item->nome()->value(); 
            ?>
            <?php if($catName == $category): ?>
                background-color: <?= $cat_item->colore_categoria() ?>;
                <?php if($cat_item->colore_testo()->isNotEmpty()): ?>
                    color: <?= $cat_item->colore_testo() ?> !important;
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        
