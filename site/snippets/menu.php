<?php $items = $site->menu()->toStructure() ?>
  <nav class="site-header">
    <?php if ($items->isNotEmpty()) : ?>
    <div class="site-header-inner">
      <?php snippet('logo-object',[]); ?>
      <div class="navigation navigation-desktop">
        <?php snippet('menuitem-list', ['items' => $items, 'accordion__item' => true]) ?>
        <?php if($site->languages_switch()->toBool()): ?>
          <?php 
          $orderedCodes = ['it', 'en', 'es'];
          $langs = [];
          foreach($orderedCodes as $code) {
              if($lang = $kirby->language($code)) {
                  $langs[] = $lang;
              }
          }
          $keys = array_keys($langs);
          $last_key = end($keys);
          ?>
          <?php foreach($langs as $key => $language): ?>
            <a class="title_link language-link <?php e($kirby->language() == $language, 'active') ?>" href="<?= $page->url($language->code()) ?>" hreflang="<?= $language->code() ?>" style="<?php e($key === 0, 'margin-left: 20px;') ?>">
              <?= strtoupper($language->code()) ?>
            </a>
            <?php if($key !== $last_key): ?>
              <span style="font-family: 'Grid'; font-variation-settings: 'wght' 1000;">/</span>
            <?php endif; ?>
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
          <div class="mobile-languages">
            <?php foreach($langs as $key => $language): ?>
              <a class="title_link language-link <?php e($kirby->language() == $language, 'active') ?>" href="<?= $page->url($language->code()) ?>" hreflang="<?= $language->code() ?>">
                <?= strtoupper($language->code()) ?>
              </a>
              <?php if($key !== $last_key): ?>
                <span style="font-family: 'Grid'; font-variation-settings: 'wght' 1000;">/</span>
              <?php endif; ?>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      </div>
    </div>
    <?php endif ?>
</nav>
<?php snippet('hero-pattern') ?>

