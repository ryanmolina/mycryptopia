<?php

get_header();

$url = 'https://api.icowatchlist.com/public/v1/';
$response = file_get_contents($url);
$result = json_decode($response);
$icoList = array_merge($result->ico->live, $result->ico->upcoming);
?>
<table class="ico-calendar">
  <thead class="ico-calendar-head">
	<tr class="ico-calendar-row">
	  <th class="ico-calendar-header">Name</th>
	  <th class="ico-calendar-header">Start</th>
	  <th class="ico-calendar-header">End</th>
	</tr>
  </thead>
  <tbody class="ico-calendar-body">
  <?php
  foreach($icoList as $ico):
	$now = time();
	$start_time = strtotime($ico->start_time);
	$end_time = strtotime($ico->end_time);

	$daysBefore = $end_time - $now;
	$daysBefore = round($daysBefore / (60 * 60 * 24));
	
	$daysAgo = ($now > $start_time) ? '<span class="status is-live">Live</span>' : '<span class="status is-upcoming">Upcoming</span>';

	if ($daysBefore > 1) {
		$daysBefore = 'in '.$daysBefore.' days';
	} else if ($daysBefore == 0) {
		$daysBefore = '<span class="status is-ending">Today</span>';
	} else {
		$daysBefore = 'in '.$daysBefore.' day';
	}

	echo '<tr class="ico-calendar-row">';
	echo '<td data-column="Name" class="ico-calendar-data">
			<div class="ico-calendar-img">
			  <img src="'.$ico->image.'">
			</div>
			<strong>'
			.$ico->name.
			'</strong><p class="ico-calendar-desc">'
			.$ico->description.'<a href="'.$ico->url.'"> Learn more</a>
		  </td>';
	echo '<td data-column="Start" class="ico-calendar-data">'
			.date("M jS, Y", $start_time).
			'<p class="ico-calendar-days">'.$daysAgo.'</p>
		  </td>';
	echo '<td data-column="End" class="ico-calendar-data">'
			.date("M jS, Y", $end_time).
			'<p class="ico-calendar-days">'.$daysBefore.'</p>
		  </td>';
	echo '</tr>';
	
  endforeach;?>
  </tbody>
</table>
<div class="load-more-container">
	<button class="load-more">Load more</button>
</div>
<?php get_footer(); ?>