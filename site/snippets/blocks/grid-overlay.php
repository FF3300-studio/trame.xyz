<?php
/** @var \Kirby\Cms\Block $block */
$text = nl2br($block->text()->or('Grid Overlay'));
$fontSize = $block->font_size()->or(4);
$link = $block->link()->toUrl();

// Bottom Layer
$colorBottom = $block->color_bottom()->or('#000000');
$wghtBottom = $block->wght_bottom()->or(100);
$backBottom = $block->back_bottom()->or(0);
$shapBottom = $block->shap_bottom()->or(100);
$settingsBottom = "'wght' $wghtBottom, 'BACK' $backBottom, 'SHAP' $shapBottom";

// Top Layer
$colorTop = $block->color_top()->or('#000000');
$wghtTop = $block->wght_top()->or(900);
$backTop = $block->back_top()->or(0);
$shapTop = $block->shap_top()->or(100);
$settingsTop = "'wght' $wghtTop, 'BACK' $backTop, 'SHAP' $shapTop";

$tag = $link ? 'a' : 'div';
$href = $link ? 'href="' . $link . '"' : '';
?>

<<?= $tag ?> <?= $href ?> class="block-grid-overlay" style="
  display: block;
  position: relative;
  font-family: 'Grid', sans-serif;
  font-size: <?= $fontSize ?>rem;
  line-height: 1;
  overflow: hidden;
  padding: 1rem 0;
  text-decoration: none;
  --color-bottom: <?= $colorBottom ?>;
  --color-top: <?= $colorTop ?>;
">
  <style>
    .block-grid-overlay:hover .layer-bottom {
      color: var(--color-top) !important;
    }
  </style>

  <!-- Bottom Layer -->
  <div class="grid-layer layer-bottom" style="
    font-variation-settings: <?= $settingsBottom ?>;
    color: var(--color-bottom);
    transition: color 0.3s ease;
  ">
    <?= $text ?>
  </div>

  <!-- Top Layer -->
  <div class="grid-layer layer-top" style="
    position: absolute;
    top: 1rem; /* Matches padding-top of container */
    left: 0;
    font-variation-settings: <?= $settingsTop ?>;
    color: var(--color-top);
    pointer-events: none; /* Let clicks pass through to the container/link */
  ">
    <?= $text ?>
  </div>
</<?= $tag ?>>
