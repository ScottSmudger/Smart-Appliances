<script>
	Highcharts.chart('container', {
		title: {
			text: '<?=$user->graph["title"]?>'
		},

		// X axis (time)
		xAxis: {
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

		// Formats the legend representing each series
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle'
		},

		// json_encode()'d for plotting on the graph
		series: <?=json_encode($user->graph["devices"])?>
	});
</script>
