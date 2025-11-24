<?php
/** @var \Kirby\Cms\Block $block */
$align = $block->align()->or('left');
$weight = $block->weight()->or(100);
$vertical_align_setting = $block->vertical_align()->or('top');
$vertical_align_map = [
    'top' => 'flex-start',
    'center' => 'center',
    'bottom' => 'flex-end'
];
$vertical_align = $vertical_align_map[$vertical_align_setting->value()] ?? 'flex-start';
?>
<div class="block-custom-text" style="--align: <?= $align ?>; --weight: <?= $weight ?>; --vertical-align: <?= $vertical_align ?>;">
  <?php foreach ($block->lines()->toStructure() as $line): ?>
    <?php 
    $tag = $line->link()->isNotEmpty() ? 'a' : 'div';
    $href = $line->link()->isNotEmpty() ? 'href="' . $line->link()->toUrl() . '"' : '';
    $color = $line->color()->or('#000000');
    ?>
    <<?= $tag ?> class="custom-text-line" <?= $href ?> style="--color: <?= $color ?>;">
      <?= $line->text() ?>
    </<?= $tag ?>>
  <?php endforeach ?>
</div>
