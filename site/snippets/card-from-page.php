<div class="card-from-page">
  <a
    href="<?= $item->url() ?>"
    class="card-master <?php if ($category_color): ?><?= strtolower($item->child_category_selector()) ?><?php endif ?>"
    style="flex-direction: <?= $direction ?>"
  >
    <?php snippet('card-info', [
      'item'       => $item,
      'direction'  => $direction,
      'tag_toggle' => $tag_toggle,
      'big'        => $big ?? true,
      'thumb_toggle' => $thumb_toggle,
      'padding_top' => '66%',
    ]) ?>
  </a>
</div>
