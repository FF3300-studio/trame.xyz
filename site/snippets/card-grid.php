<div class="single-cards col-lg-4 col-sm-12 col-12">
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
    ]) ?>
  </a>
</div>
