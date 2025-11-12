<?php
$correlati = $page->correlati()->toPages();

if ($correlati->count() > 0):

  // Raggruppo i correlati per genitore (chiave = id del genitore)
  $groups   = [];
  $parents  = []; // mappa id => Page (genitore)

  foreach ($correlati as $child) {
    if ($parent = $child->parent()) {
      $pid = $parent->id();
      $groups[$pid][]  = $child;
      $parents[$pid]   = $parent; // mantiene unici
    }
  }

  // Genitori unici e condizione per mostrare i titoli
  $genitori         = array_values($parents);
  $showParentTitle  = count($genitori) >= 2;
?>
<div class="blocks related-content-container" style="margin-top: 60px;">
  <h5 class="label-grid correlati" style="color: white"><strong>Contenuti correlati:</strong></h5>

  <?php foreach ($genitori as $genitore): ?>
    <div class="related-group" style="margin-top: 40px;">
      <?php if ($showParentTitle): ?>
        <h6 class="related-parent-title">
          <?= $genitore->title()->escape() ?>
        </h6>
      <?php endif; ?>

      <div class="block-grid-a-list" style="justify-content: space-evenly; display: flex; flex-wrap: wrap;">
        <?php foreach ($groups[$genitore->id()] as $child): ?>
          <?php snippet('card-grid', [
            'item' => $child,
            'thumb_toggle' => true,
            'tag_toggle' => false,
            'correlati' => true,
            'direction' => 'column',
            'category_color' => false,
            'big' => false,
          ]) ?>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
