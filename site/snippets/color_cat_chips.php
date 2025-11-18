        <?php foreach($tutte_le_categorie as $cat_item): ?>
            <?php if($cat_item->nome() == $category): ?>
                background-color: <?= $cat_item->colore_categoria() ?>;
            <?php endif; ?>
        <?php endforeach; ?>
        
