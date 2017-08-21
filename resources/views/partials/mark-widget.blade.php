<?

//оценки
if (!isset($marks)) $marks = [
  [
    'rate'    => 1,
    'caption' => __('Очень недоволен'),
  ],
  [
    'rate'    => 2,
    'caption' => __('Недоволен'),
  ],
  [
    'rate'    => 3,
    'caption' => __('Нейтральный') . ' &laquo;ОК&raquo;',
  ],
  [
    'rate'    => 4,
    'caption' => __('Доволен'),
  ],
  [
    'rate'    => 5,
    'caption' => __('Очень доволен'),
  ],
];

$bars_count = count($marks);

if (!isset($rating)) $rating = 0;
if (!isset($value)) $value = 0;
if (!isset($size)) $size = 22; // 14, 22, 30
if (!isset($show_number)) $show_number = false;
if (!isset($input_name)) $input_name = false;
$is_control = $input_name ? true : false;
if (!isset($show_title_rating)) $show_title_rating = false;
if (!isset($show_rating_caption)) $show_rating_caption = false;

//get max rating
$max_rating = $marks[0]['rate'];
foreach ($marks as $mark) {
  if ($mark['rate'] > $max_rating) $max_rating = $mark['rate'];
}

$rating_per_bar = $max_rating / $bars_count;

for ($i = 0; $i < $bars_count; $i++) {
  $rating_in_bar = $rating - $i * $rating_per_bar;
  if ($rating_in_bar > $rating_per_bar) $rating_in_bar = $rating_per_bar;
  elseif ($rating_in_bar < 0) $rating_in_bar = 0;
  $marks[$i]['percent'] = $rating_in_bar / $rating_per_bar * 100;
}

$start_caption = isset($caption) ? $caption : '';
$caption = $start_caption;

$rating_caption = '';
foreach ($marks as $mark) {
  if ($rating >= $mark['rate']) {
    $rating_caption = $mark['caption'];
  }
}

?>
<div class="mark-widget mark-widget-{{ $size }}{{ $is_control ? ' mark-widget-control' : '' }}"<? if ($show_title_rating) echo ' title="' . $rating_caption . '"'; ?>>
  <div class="mark-widget-marks<? if (isset($err)) echo ' mark-widget-error' ?>">
    <? foreach ($marks as $mark) {

      $rate = $mark['rate'];
      $mark_caption = $mark['caption'];

      $class = '';
      if ($is_control && $value >= $rate) {
        $class = ' curr-active active';
        $caption = $mark_caption;
      }

      ?>
      <div class="mark<?=$class?>"<? if ($is_control) echo 'data-rate="' . $rate . '" data-caption="' . $mark_caption . '"' ?>>
        <div class="mark-fill" style="width:<?=$mark['percent']?>%">
          <div class="fill"></div>
        </div>
        <div class="mark-inner"><i class="fa fa-fw fa-star"></i></div>
      </div>
    <? } ?>
  </div>
  <? if ($show_number) { ?>
    <div class="mark-rating<? if (!$rating) echo ' no-rating' ?>"><?=number_format($rating, 1)?></div>
  <? } ?>
  <? if ($is_control) { ?>
    <input type="number" class="mark-widget-input" name="<?=$input_name?>" placeholder="<?=$input_name?>" min="0" max="<?=$max_rating?>" value="<?=$value ? $value : null?>">
  <? } ?>
  <small class="mark-widget-caption" data-start-caption="<?=$start_caption?>"><?
    if (($is_control || $show_rating_caption) && !empty($rating_caption))
      echo $rating_caption; else echo $caption ?></small>
</div>