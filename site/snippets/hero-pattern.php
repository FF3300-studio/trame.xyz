<?php if($page->hero_pattern_active()->isTrue()): ?>
<style>
  @font-face {
  font-family: "GTL Trame Texture";
  src: url("<?= url('assets/build/fonts/GTLTrameTextureVF.ttf') ?>") format("truetype");
  }
  @font-face {
  font-family: "GTL Trame 1";
  src: url("<?= url('assets/build/fonts/GTLTrame1VF.ttf') ?>") format("truetype");
  }
  @font-face {
  font-family: "GTL Trame 2";
  src: url("<?= url('assets/build/fonts/GTLTrame2VF.ttf') ?>") format("truetype");
  }
  @font-face {
  font-family: "GTL Trame 3";
  src: url("<?= url('assets/build/fonts/GTLTrame3VF.ttf') ?>") format("truetype");
  }
  @font-face {
  font-family: "GTL Trame 4";
  src: url("<?= url('assets/build/fonts/GTLTrame4VF.ttf') ?>") format("truetype");
  }
  @font-face {
  font-family: "GTL Trame 5";
  src: url("<?= url('assets/build/fonts/GTLTrame5VF.ttf') ?>") format("truetype");
  }
  @font-face {
  font-family: "GTL Trame 6";
  src: url("<?= url('assets/build/fonts/GTLTrame6VF.ttf') ?>") format("truetype");
  }
  @font-face {
  font-family: "Grid";
  src: url("<?= url('assets/build/fonts/Grid.ttf') ?>") format("truetype");
  }

  .hero-pattern-container {
    position: relative;
    width: 100%;
    margin: 0;
    margin-bottom: 30px; /* 2 spacers (15px * 2) */
    padding: 0;
    /* font-size set via style attribute for reuse */
    font-size: var(--hero-fs);
    font-family: "GTL Trame Texture", sans-serif;
    line-height: 0.998;
    overflow: hidden;
    user-select: none;
    pointer-events: none;
    white-space: nowrap;
  }
  
  .hero-pattern-layer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* mix-blend-mode removed */
  }

  .hero-pattern-layer.layer-1 {
    position: relative;
    z-index: 12; /* Topmost */
    font-family: "GTL Trame Texture", sans-serif;
  }
  .hero-pattern-layer.layer-2 {
    z-index: 11;
    font-family: "GTL Trame 1", sans-serif;
  }
  .hero-pattern-layer.layer-3 {
    z-index: 10;
    font-family: "GTL Trame 1", sans-serif;
  }
  .hero-pattern-layer.layer-4 {
    z-index: 20; /* Overlay on top of everything */
  }
  .hero-pattern-layer.layer-subtitle {
     z-index: 25;
     position: absolute;
     top: calc(var(--hero-fs) * 1.5); /* Moved down further */
     left: 0;
     width: 100%;
     font-size: clamp(20px, 5vw, 50px);
     text-align: left;
     letter-spacing: -0.02em; /* Reduced spacing */
     line-height: 1.1;
     pointer-events: none;
     padding-left: 0.5em; /* Increased spacing */
  }

  .pattern-row {
    display: block;
    width: 100%;
    overflow: hidden;
    /*height: 0.84em; Enforce strict grid height */
    /*line-height: 0.85em; Match height */
  }

  /* Animation Styles */
  @keyframes fadeSwap {
    0%, 45% { opacity: 1; }
    50%, 95% { opacity: 0; }
    100% { opacity: 1; }
  }
  @keyframes fadeSwapAlt {
    0%, 45% { opacity: 0; }
    50%, 95% { opacity: 1; }
    100% { opacity: 0; }
  }

  .layer-1-anim-main {
    animation: fadeSwap 2s infinite step-end;
  }
  .layer-1-anim-alt {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    animation: fadeSwapAlt 2s infinite step-end;
  }
</style>

<?php 
// No spaces added to the text
$text1 = $page->hero_pattern_text_1()->esc();
$repeatedText1 = str_repeat($text1, 40);
$weight1 = $page->hero_pattern_weight_1()->or(100)->toInt();

// Optional Animation Logic
$animActive = $page->hero_pattern_animation_1()->isTrue();
$text1Alt = $page->hero_pattern_text_1_alt()->esc();
$repeatedText1Alt = $animActive ? str_repeat($text1Alt, 40) : '';

$text2 = $page->hero_pattern_text_2()->esc();
$repeatedText2 = str_repeat($text2, 40); 
$weight2 = $page->hero_pattern_weight_2()->or(100)->toInt();

$text3 = $page->hero_pattern_text_3()->esc();
$repeatedText3 = str_repeat($text3, 40); 
$weight3 = $page->hero_pattern_weight_3()->or(100)->toInt();

// Overlay settings
$overlayText = $page->hero_pattern_overlay_text()->esc();
$repeatedOverlayText = str_repeat($overlayText, 40);
$overlayFont = $page->hero_pattern_overlay_font()->or('GTL Trame 1');
$overlayLineHeight = $page->hero_pattern_overlay_line_height()->or(1)->toFloat();
$overlayWeight = $page->hero_pattern_overlay_weight()->or(100)->toInt();

// Subtitle settings
$subtitleActive = $page->hero_pattern_subtitle_active()->isTrue();
?>

<div class="hero-pattern-container" style="--hero-fs: min(20vw, 22vh);">
  
  <!-- Layer 1 -->
  <div class="hero-pattern-layer layer-1" style="color: <?= $page->hero_pattern_color_1() ?>; font-variation-settings: 'wght' <?= $weight1 ?>;">
    
    <!-- Main Text Wrapper -->
    <div class="<?= $animActive ? 'layer-1-anim-main' : '' ?>">
      <?php for($i=0; $i<3; $i++): ?>
        <div class="pattern-row"><?= $repeatedText1 ?></div>
      <?php endfor; ?>
    </div>

    <!-- Alt Text Wrapper (Absolute Overlay) -->
    <?php if($animActive && $text1Alt): ?>
    <div class="layer-1-anim-alt">
      <?php for($i=0; $i<3; $i++): ?>
        <div class="pattern-row"><?= $repeatedText1Alt ?></div>
      <?php endfor; ?>
    </div>
    <?php endif; ?>

  </div>

  <!-- Layer 2 -->
  <div class="hero-pattern-layer layer-2" style="color: <?= $page->hero_pattern_color_2() ?>; font-variation-settings: 'wght' <?= $weight2 ?>;">
    <?php for($i=0; $i<3; $i++): ?>
      <div class="pattern-row"><?= $repeatedText2 ?></div>
    <?php endfor; ?>
  </div>

  <!-- Layer 3 -->
  <div class="hero-pattern-layer layer-3" style="color: <?= $page->hero_pattern_color_3() ?>; font-variation-settings: 'wght' <?= $weight3 ?>;">
    <?php for($i=0; $i<3; $i++): ?>
      <div class="pattern-row"><?= $repeatedText3 ?></div>
    <?php endfor; ?>
  </div>

  <!-- Layer Subtitle -->
  <?php if($subtitleActive): ?>
  <div class="hero-pattern-layer layer-subtitle" style="color: <?= $page->hero_pattern_overlay_color() ?>; font-family: 'Grid', sans-serif; font-variation-settings: 'wght' 0, 'BACK' 900, 'SHAP' 100;">
    <span>Scuola di tessitura<br>contemporanea</span>
  </div>
  <?php endif; ?>

  <!-- Layer 4 (Overlay) -->
  <?php if($overlayText->isNotEmpty()): ?>
  <div class="hero-pattern-layer layer-4" style="color: <?= $page->hero_pattern_overlay_color() ?>; font-family: '<?= $overlayFont ?>', sans-serif; line-height: <?= $overlayLineHeight ?>; font-variation-settings: 'wght' <?= $overlayWeight ?>;">
    <div class="pattern-row"><?= $overlayText ?></div>
  </div>
  <?php endif; ?>

</div>
<?php endif; ?>
