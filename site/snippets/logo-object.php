<?php if($site->logo_switch() == "logo"): ?>
  <div class="logo">
    <?php if($site->logo()->isNotEmpty()): ?>
    <a href="<?= $site->url() ?>" title="<?= $site->title() ?>">
      <?= svg($site->logo()->toFile()) ?>
    </a>
    <?php else: ?>
    Carica un logo
    <?php endif; ?>
  </div>
<?php elseif($site->logo_switch() == "logotype"): ?>
  <div class="logotype_container">
    <a href="<?= $site->url() ?>" title="<?= $site->logotype() ?>">
      <h2 class="logotype">
        <?php
          $text = $site->logotype()->value();
          $first = mb_substr($text, 0, 1);
          $rest = mb_substr($text, 1);
        ?>
        <span class="logotype-initial"><?= $first ?></span><span class="logotype-rest"><?= $rest ?></span>
      </h2>
    </a>
  </div>
<?php endif; ?>
 