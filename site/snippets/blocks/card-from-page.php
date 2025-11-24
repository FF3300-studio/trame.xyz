<?php snippet('card-from-page', [
    'item' => $block->source()->toPage(),
    'thumb_toggle' => true, 
    'tag_toggle' => true,
    'direction' => 'column',
    'category_color' => $category_color ?? false,
]) ?> 
