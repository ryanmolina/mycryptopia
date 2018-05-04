<?php

get_header();

/*
 The ICO Watchlist public API only allows 1 request per second.
*/
$url = 'https://api.icowatchlist.com/public/v1/';
$response = file_get_contents($url);
$result = json_decode($response);
$icoList = array_merge($result->ico->live, $result->ico->upcoming);
?>

<div class="crypto-table-sorting">
	<div class="crypto-table-sort-category">
		<select id="ico-calendar-sort-category">
			<option value="name">Name</option>
			<option value="start">Start</option>
			<option value="price">End</option>
		</select>
	</div>
	<div class="crypto-table-sorting-arrows" id="ico-calendar-sort-by">
		<i class="icon-arrow-up"></i>
		<i class="icon-arrow-down"></i>
	</div>
</div>
<table class="crypto-table" id="ico-calendar">
  <thead class="crypto-table-head">
	<tr class="crypto-table-row">
	  <th id="ico-calendar-name" class="crypto-table-header">Name</th>
	  <th id="ico-calendar-start" class="crypto-table-header">Start</th>
	  <th id="ico-calendar-end" class="crypto-table-header">End</th>
	</tr>
  </thead>
  <tbody class="crypto-table-body">
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
	} else if ($daysBefore == 1) {
		$daysBefore = 'in '.$daysBefore.' day';
	} else {
		$daysBefore = '<span class="status is-ending">Today</span>';
	}

	echo '<tr class="crypto-table-row">';
	echo '<td data-column="Name" class="crypto-table-data">
			<div class="crypto-table-img">
			  <img src="'.$ico->image.'">
			</div>
			<strong>'
			.$ico->name.
			'</strong><p class="crypto-table-desc">'
			.$ico->description.'<a href="'.$ico->icowatchlist_url.'"> Learn more</a>
		  </td>';
	echo '<td data-column="Start" class="crypto-table-data">'
			.date("d.m.y", $start_time).
			'<p class="crypto-table-days">'.$daysAgo.'</p>
		  </td>';
	echo '<td data-column="End" class="crypto-table-data">'
			.date("d.m.y", $end_time).
			'<p class="crypto-table-days">'.$daysBefore.'</p>
		  </td>';
	echo '</tr>';
	
  endforeach;?>
  </tbody>
</table>
<div class="load-more-container">
	<button id="ico-calendar-load-more" class="load-more hvr-sweep-to-right">Load more</button>
</div>
<?php get_footer(); ?>