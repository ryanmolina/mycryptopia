<?php

get_header();

$url = 'https://api.icowatchlist.com/public/v1/';
$response = file_get_contents($url);
$result = json_decode($response);
$icoList = array_merge($result->ico->live, $result->ico->upcoming);
?>
<div class="container">
  <div class="row">
	<table class="ico-calendar">
	  <thead>
		<tr class="ico-calendar-row-header">
		  <th class="ico-calendar-header">Name</th>
		  <th class="ico-calendar-header">Start</th>
		  <th class="ico-calendar-header">End</th>
		</tr>
	  </thead>
	  <tbody>
	  <?php
	  foreach($icoList as $ico):
		$now = time();
		$start_time = strtotime($ico->start_time);
		$end_time = strtotime($ico->end_time);

		$daysBefore = $end_time - $now;
		$daysBefore = round($daysBefore / (60 * 60 * 24));
		
		$daysAgo = ($now > $start_time) ? '<span class="status is-live">Live</span>' : '<span class="status is-upcoming">Upcoming</span>';
		$daysBefore = ($daysBefore > 1) ? 'in '.$daysBefore.' days' : 'in '.$daysBefore.' day';

		echo '<tr class="ico-calendar-row">';
		echo '<td class="ico-calendar-data">
				<div class="ico-calendar-img">
				  <img src="'.$ico->image.'">
				</div>'
				.$ico->name.
				'<p class="ico-calendar-desc">'
				.$ico->description.'<a href="'.$ico->url.'"> Learn more</a>
			  </td>';
		echo '<td class="ico-calendar-data">'
				.date("M jS, Y", $start_time).
				'<p class="ico-calendar-days">'.$daysAgo.'</p>
			  </td>';
		echo '<td class="ico-calendar-data">'
				.date("M jS, Y", $end_time).
				'<p class="ico-calendar-days">'.$daysBefore.'</p>
			  </td>';
		echo '</tr>';
		
	  endforeach;?>
	  </tbody>
	</table>
	<button class="load-more">Load more</button>
  </div>
</div>
<?php get_footer(); ?>