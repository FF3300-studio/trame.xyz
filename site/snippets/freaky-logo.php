<?php
// Logo testuale senza suddivisione in lettere o stylistic set.
$input = mb_convert_encoding($input, 'UTF-8', 'auto');
$classes = ['title'];

if (isset($big) && $big === true && $page->parent() !== null) {
    $classes[] = 'big';
}
?>

<h1 class="<?= implode(' ', $classes) ?>" style="margin:0; padding:0;">
    <?= nl2br(esc($input)) ?>
</h1>

