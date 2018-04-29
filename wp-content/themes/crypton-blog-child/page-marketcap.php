<?php
get_header();
?>
	<div class="marketcap-sorting">
		<div class="marketcap-sort-category">
			<select id="sort-category">
				<option value="rank">Rank</option>
				<option value="name">Name</option>
				<option value="price">Price</option>
				<option value="cap">Market Cap</option>
				<option value="volume">Volume 24H</option>
				<option value="change">Change 24H</option>
			</select>
		</div>

		<div id="sort-by">
			<i class="icon-arrow-up"></i>
			<i class="icon-arrow-down"></i>
		</div>
	</div>
    <table class="marketcap-table" id="marketcap">
      	<thead class="marketcap-table-head">
        	<tr class="marketcap-table-row">
	          <th id="marketcap-rank" class="marketcap-table-header">Rank</th>
	          <th id="marketcap-name" class="marketcap-table-header">Name</th>
	          <th id="marketcap-price" class="marketcap-table-header">Price</th>
	          <th id="marketcap-cap" class="marketcap-table-header">Market Cap</th>
	          <th id="marketcap-volume" class="marketcap-table-header">Volume 24H</th> 
	          <th id="marketcap-change" class="marketcap-table-header">Change 24H</th>
      		</tr>
    	</thead>
    	<tbody class="marketcap-table-body"></tbody>
    </table>
    <div class="load-more-container">
    	<button id="marketcap-load-more" class="load-more hvr-sweep-to-right">Load More</button>
	</div>
<?php
get_footer();
?>