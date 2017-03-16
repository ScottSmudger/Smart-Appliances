<?php
// This file is so the graph code can be edited separately from the Dash page.
// This shouldn't be called directly.
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	var today = <?=json_encode($user->graph["devices"])?>;

	
	// the button action
	$('#button').click(function () {
		var chart = $('#container').highcharts();
	    chart.xAxis[0].setExtremes(1489618512, 1489618992, true, true);
	    chart.series = today;
	});

	
	
	var thisweek = [
		[1487188233000, 3]
	];
	
	var thismonth = [
		[1487188233000, 6]
	];
	

	Highcharts.stockChart('container', {
		chart: {
			zoomType: 'x'
		},
	
		title: {
			text: '<?=$user->graph["title"]?>'
		},

		// X axis (time)
		xAxis: {
			title: {
				text: 'Time'
			},

			events: {
				afterSetExtremes: function(e) {
					var chart = $('#container').highcharts();
					
					this.isDirty = true;
					chart.yAxis.isDirty = true;
					chart.redraw();
				}
			},

			type: 'datetime'
		},

		// Y axis (Device state)
		yAxis: {
			title: {
				text: 'State'
			},

			labels: {
				formatter: function () {
					return this.value;
				}
			},

			opposite: false

			//categories:['Closed', 'Open']
		},

		// Display the legend
		legend: {
			enabled: true
		},

		// Customise the range options
		rangeSelector: {
			allButtonsEnabled: true,
			buttons: [{
				type: 'day',
				count: 1,
				text: 'Day',
				dataGrouping: {
					forced: true,
					units: [['day', [1]]]
				}
			}, {
				type: 'week',
				count: 1,
				text: 'Week',
				dataGrouping: {
					forced: true,
					units: [['week', [1]]]
				}
			}, {
				type: 'month',
				count: 1,
				text: 'Month'
			}, {
				type: 'all',
				text: 'All'
			}],

		   buttonTheme: {
				width: 60
			}
		},

		// Temporary fix until alternative is found
		navigator: {
			enabled: false
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
</script>
