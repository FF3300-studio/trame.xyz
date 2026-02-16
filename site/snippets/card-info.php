<?php $deadline_exist = "off"; ?>
<?php $deadline_toggle = "off"; ?>
<?php $deadline = $item->deadline() OR NULL ?>
<?php $facilitato = false ?>
<div class="cards-details cards-info" style="padding: 15px; margin: 0; <?php if($direction == "row"): ?>margin-left: 15px;<?php endif; ?>">
<?php
// Data di oggi
$today = date('Y-m-d', strtotime('today'));

// Deadline in formato corretto (Y-m-d)
$deadline = $item->deadline()->isNotEmpty() ? $item->deadline()->toDate('Y-m-d') : null;

// deadline è definita e successiva o uguale a oggi?
$deadline_bool = $deadline && ($deadline >= $today);

// Data tra tre giorni
$next_three_days = date('Y-m-d', strtotime('+3 days'));

// deadline è entro i prossimi 3 giorni e non nel passato?
$incoming_deadline_bool = $deadline && ($deadline >= $today && $deadline <= $next_three_days);

$current = $item ?? $page;
$formData = $formData($current);
$hasAvailableSeats = !isset($formData['available']) || $formData['available'] > 0;

// Controlla appuntamenti imminenti solo se non c'è deadline
$incoming_appointment_bool = false;
if (!$deadline && $current->appuntamenti()->isNotEmpty()) {
    foreach ($current->appuntamenti()->toStructure() as $appuntamento) {
        $giorno_appuntamento = $appuntamento->giorno()->toDate('Y-m-d');
        if ($giorno_appuntamento >= $today && $giorno_appuntamento <= $next_three_days) {
            $incoming_appointment_bool = true;
            break;
        }
    }
}
?>

<?php if($tag_toggle == true AND $item->child_category_selector()->isNotEmpty()): ?>
<div class="cards-categories">
    <span class="tag parent"><?= $item->parent()->title() ?></span>
    <?php foreach($item->child_category_selector()->split() as $category): ?>
        <?php $tutte_le_categorie = $item->parent()->parent_category_manager()->toStructure() ?>
        <span class="tag" style="<?php snippet('color_cat_chips',[
            'tutte_le_categorie' => $tutte_le_categorie,
            'category' => $category, 
        ]) ?>"><?= $category ?></span>
        <?php if(strtolower($category) == "workshop"): ?>
            <?php $facilitato = true ?>
        <?php endif; ?>
    <?php endforeach; ?>    
</div>
<?php endif; ?>


    <div class="cards-thumbnail">
      <?php if ($thumb_toggle && $item->thumbnail()->isNotEmpty()): ?>
        <?php
          $image = $item->thumbnail()->toFile();
          $ratio = $image->width() / $image->height();
        ?>
        <div class="card-image-container" <?php if(isset($padding_top)): ?>style="padding-top: <?= $padding_top ?>;"<?php endif; ?>>
          <img
            class="lazyload"
            data-sizes="auto"
            data-src="<?= $image->resize(1280)
                            ->thumb(['format' => 'webp', 'quality' => 75])
                            ->url() ?>"
            data-srcset="<?= $image->srcset(
                              [320, 640, 960, 1280, 1600, 1920],
                              ['format' => 'webp', 'quality' => 75]
                            ) ?>"
            width="<?= $image->width() ?>"
            height="<?= $image->height() ?>"
            alt="<?= html($image->alt() ?? $image->filename()) ?>"
            style="
              <?php if (isset($min_height) && $min_height !== ''): ?>min-height: <?= $min_height ?>;<?php endif ?>
              <?php if (isset($min_width)  && $min_width  !== ''): ?>min-width: <?= $min_width  ?>;<?php endif ?>
              <?php if (isset($max_height) && $max_height !== ''): ?>max-height: <?= $max_height ?>;<?php endif ?>
              <?php if (isset($max_width)  && $max_width  !== ''): ?>max-width: <?= $max_width  ?>;<?php endif ?>
              aspect-ratio: <?= $ratio ?>;
              object-fit: <?= ($contain ?? false) ? 'contain' : 'cover' ?>;
              width: 100%;
            "
          >
          <?php if (($incoming_deadline_bool || $incoming_appointment_bool) && $hasAvailableSeats): ?>
              <span class="deadline-badge manca-poco">MANCA<br>POCO!</span>
          <?php elseif ($deadline_toggle == "on" && $deadline_bool && $hasAvailableSeats): ?>
              <span class="deadline-badge iscriviti">ISCRIZIONI<br>APERTE</span>
          <?php elseif ($deadline_exist == "on"): ?>
              <span class="deadline-badge chiuse">ISCRIZIONI<br>CHIUSE</span>
          <?php endif; ?>
        </div>
      <?php endif ?>
    </div>


<?php if($item->appuntamenti()->isNotEmpty()): ?>
    <div>
        <?php $appuntamenti = $item->appuntamenti()->toStructure() ?>
        <div class="cards-dates" style="display: flex; width: 100%; justify-content: space-between; flex-wrap:nowrap;">
            <?php foreach($appuntamenti as $appuntamento): ?>
            <?php 
            $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
            $formatter->setPattern('d.MM.Y'); // Modello simile a %d – %b – %Y;
            ?>
            <span style=" text-transform: capitalize;" class="time"><?= $formatter->format($appuntamento->giorno()->toDate()) ?></span>  <span class="time" style=""><?= $appuntamento->orario_inizio()->toDate('H:i') ?>-<?= $appuntamento->orario_fine()->toDate('H:i') ?></span>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<div class="cards-title" style="margin:0!important;">
    <h2><?= $item->title() ?></h2>
</div>

<?php if ($item->deadline()->isNotEmpty()): ?>
    <?php $deadline_exist = "on" ?>
<?php endif; ?>
<?php if ($item->deadline()->isNotEmpty() && strtotime($item->deadline()) >= strtotime('today')): ?>
    <?php $deadline_toggle = "on" ?>
    <?php $deadline = $item->deadline() ?>
    <div class="cards-dates" style="display: flex; width: 100%; justify-content: center; flex-wrap:wrap; text-align: center;">
        <?php 
        $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
        $formatter->setPattern('d MMM Y'); // Modello simile a %d – %b – %Y;
        ?>
        <span id="deadline" class="center" style="min-width: fit-content; max-width: 100%; text-transform: uppercase; text-align: center; padding-top: 15px; padding-bottom: 15px;" class="time"><strong>ISCRIVITI ENTRO</strong> → <strong><?= $formatter->format($deadline->toDate()) ?></strong></span>
    </div>
<?php else: ?>
<?php endif; ?>

<div class="cards-text">
    <?php echo $item->descrizione()->kirbytext(); ?>
</div>

<?php if ($item->team()->isNotEmpty()): ?>

    <?php if($facilitato == false): ?>
        <div class="team-label"><p style="margin: 0; margin-top: 15px; margin-bottom: 15px;">Con la partecipazione di:</p></div>
    <?php else: ?>
        <div class="team-label"><p style="margin: 0; margin-top: 15px; margin-bottom: 7.5px;">Attività facilitata da:</p></div>
    <?php endif; ?>
    
    <?php foreach($item->team()->toStructure() as $team_member): ?>
        <p class="team" style="margin-top:0; margin-bottom: 5px;">✨ <strong><?= $team_member->persona() ?></strong> / <?= $team_member->ruolo() ?></p>
    <?php endforeach; ?>

    <div class="cards-team" style="display: flex; width: 100%; justify-content: center; flex-wrap:wrap; text-align: center;">
    
    </div>

<?php endif; ?>


<?php if($item->dove()->isNotEmpty()): ?>
<div class="location">
    📍 <?= $item->dove() ?>
</div>
<?php endif; ?>

    <?php 
    $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
    $formatter->setPattern('d MMM Y'); // Modello simile a %d – %b – %Y;
    ?>

        <?php if($page->parent() !== NULL AND $page->parent()->collection_options() == "calendar"): ?>
            <?php if(strtotime($page->deadline()) >= strtotime('today')): ?>
            <?php snippet('form-request-counter',[
            'page' => $page,
            ])?>
            <?php endif; ?>
        <?php else: ?>
            <?php if(strtotime($item->deadline()) >= strtotime('today')): ?>
            <?php snippet('form-request-counter',[
            'page' => $item,
            ])?>
            <?php endif; ?>
        <?php endif; ?>

        <?php



?>

</div>