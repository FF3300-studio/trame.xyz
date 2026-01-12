<?php $items = $site->menu()->toStructure() ?>
  <nav class="site-header">
    <?php if ($items->isNotEmpty()) : ?>
    <div class="site-header-inner">
      <?php snippet('logo-object',[]); ?>
      <div class="navigation navigation-desktop">
        <?php snippet('menuitem-list', ['items' => $items, 'accordion__item' => true]) ?>
        <?php if($site->languages_switch()->toBool()): ?>
          <?php foreach($kirby->languages() as $language): ?>
            <a class="title_link <?php e($kirby->language() == $language, 'active') ?>" href="<?= $page->url($language->code()) ?>" hreflang="<?php echo $language->code() ?>" style="font-family: 'Grid'; font-variation-settings: 'wght' 1000;">
              <?= html($language->code()) ?>
            </a>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      <div class="navbar-toggler closed">
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
		  </div>
    </div>
    <div class="navigation navigation-mobile">
      <div class="navigation-mobile-flexbox">
        <?php snippet('mobile-menuitem-list', ['items' => $items, 'accordion__item' => true]) ?>
        <?php if($site->languages_switch()->toBool()): ?>
          <?php foreach($kirby->languages() as $language): ?>
            <a class="title_link <?php e($kirby->language() == $language, 'active') ?>" href="<?= $page->url($language->code()) ?>" hreflang="<?php echo $language->code() ?>" style="font-family: 'Grid'; font-variation-settings: 'wght' 1000;">
              <?= html($language->code()) ?>
            </a>
          <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>
    <?php endif ?>
</nav>

