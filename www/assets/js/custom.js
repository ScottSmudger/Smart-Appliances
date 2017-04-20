// This function changes the style sheet
function changeStyle()
{
	var colour = $("#colourChange option:selected").val();
	var dropdown = document.getElementById("pagestyle");

	if(colour)
	{
		dropdown.setAttribute("href", "http://uni.scottsmudger.website/assets/css/" + colour + ".css");

		// Change graph colour because why not
		changeGraphColour(colour);
	}
	else
	{
		dropdown.setAttribute("href", "http://uni.scottsmudger.website/assets/css/default.css");
	}

	$.cookie("sheet", colour, {expires: 10});
}

// Change the graph colour only if there is 1 device being displayed
function changeGraphColour(colour)
{
	if(chart.series.length == 1)
	{
		// Set the specific hex colours that the style sheet is set to
		if(colour == "blue")
		{
			hex = "#005691";
		}
		else if(colour == "red")
		{
			hex = "#CC0000";
		}
		else if(colour == "green")
		{
			hex = "#006600";
		}

		// Change the colour
		chart.series[0].update({
			color: hex
		});
	}
}

// jQuery for the cookie bar
window.addEventListener("load", function(){
window.cookieconsent.initialise({
	"palette": {
		"popup": {
			"background": "#edeff5",
			"text": "#838391"
		},
		"button": {
			"background": "#4b81e8"
		}
	}
})
});

// Things that need setting on page load
// Checks the javascript cookie to see what style sheet has been set
// Then set the style sheet to that value
$(document).ready(function()
{
	var colour = $.cookie("sheet");

	// Setting default sheet on dropdown
	$('#colourChange').val(colour);

	if(colour !== undefined)
	{
		document.getElementById("pagestyle").setAttribute("href", "http://uni.scottsmudger.website/assets/css/" + colour + ".css" );

		// Change graph colour because why not
		changeGraphColour(colour);
	}
});
