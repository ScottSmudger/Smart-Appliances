<?php
// This file is so the graph code can be edited separately from the Dash page.
// This shouldn't be called directly.
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	var today = <?=json_encode($user->graph["devices"])?>;
	
	var thisweek = [
		[1487188233000, 3]
	];
	
	var thismonth = [
		[1487188233000, 6]
	];
	

	Highcharts.stockChart('container', {
		title: {
			text: '<?=$user->graph["title"]?>: '
		},

		// X axis (time)
		xAxis: {
			title: {
				text: 'Time'
			},

			type: 'datetime'
		},

		// Y axis (Device state)
		yAxis: {
			categories: ['Closed', 'Open'],

			labels: {
				formatter: function () {
					return this.value;
				}
			},

			title: {
				text: 'State'
			}
		},

		// Formats the unix time properly so we can see
		// the hour and minute
		tooltip: {
			xDateFormat: '%a. %e %B %Y - %H:%M',
			shared: true
		},

		// json_encode()'d for plotting on the graph
		series: today
	});

//--------------------------------------------------------------------

	// Redraw chart depending on which option is selected
	function test() 
	{
		var timeSelection = $("#dropdown1").val();
		
		Highcharts.stockChart('container', {
			title: {
				text: '<?=$user->graph["title"]?>: ' + timeSelection
			},

			// X axis (time)
			xAxis: {
				title: {
					text: 'change Time'
				},

				type: 'datetime'
			},

			// Y axis (Device state)
			yAxis: {
				categories: ['Closed', 'Open'],

				labels: {
					formatter: function () {
						return this.value;
					}
				},

				title: {
					text: 'change State'
				}
			},

			// Formats the unix time properly so we can see
			// the hour and minute
			tooltip: {
				xDateFormat: '%a. %e %B %Y - %H:%M',
				shared: true
			},

			// json_encode()'d for plotting on the graph
			series: timeSelection
		});
	}
</script>
