
<?php /** @var \Kirby\Cms\Block $block */ ?>
<?php $text = $block->text(); ?>

<h2 class="title">
    <?= nl2br(esc($text)) ?>
</h2>
