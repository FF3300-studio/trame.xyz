<?php
/** @var \Kirby\Cms\Block $block */
$words = $block->words()->toStructure();
$wordList = [];
foreach ($words as $w) {
    $wordList[] = $w->word()->value();
}
$jsonWords = json_encode($wordList);
$id = 'cycling-text-' . $block->id();
$align = $block->align()->or('left');
$weight = $block->weight()->or(400);
?>

<div class="cycling-text-container" style="padding: 0px; text-align: <?= $align ?>;">
    <h3>
        <?= $block->prefix() ?>
        <span id="<?= $id ?>" style="font-weight: <?= $weight ?>;"><?= $words->first() ? $words->first()->word() : '' ?></span>
        <?= $block->suffix() ?>
    </h3>
</div>

<script>
    (function() {
        const words = <?= $jsonWords ?>;
        if (words.length === 0) return;
        
        let currentIndex = 0;
        const wordElement = document.getElementById('<?= $id ?>');

        setInterval(() => {
            currentIndex = (currentIndex + 1) % words.length;
            wordElement.textContent = words[currentIndex];
        }, 1000);
    })();
</script>
