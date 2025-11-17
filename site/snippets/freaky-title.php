<?php
// Manteniamo solo l'output testuale senza applicare stylistic set casuali.
$input = mb_convert_encoding($input, 'UTF-8', 'auto');
$classes = ['title'];

if (isset($big) && $big === true && $page->parent() !== null) {
    $classes[] = 'big';
}
?>

<h2 class="<?= implode(' ', $classes) ?>" style="margin:0;">
    <?= nl2br(esc($input)) ?>
</h2>

