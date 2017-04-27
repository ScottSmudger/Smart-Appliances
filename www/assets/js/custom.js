// This function changes the style sheet
function changeStyle(colour = $("#colourChange option:selected").val())
{
	var dropdown = document.getElementById("pagestyle");

	// If colour is set then set the css to that colour
	if(colour)
	{
		dropdown.setAttribute("href", "/assets/css/" + colour + ".css");
		
		// Change graph colour because why not
		changeGraphColour(colour);
	}

	$.cookie("sheet", colour, {expires: 10});
}

// Change the graph colour
function changeGraphColour(colour)
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
	// for all series (this may change in the future
	for(i = 0; i < chart.series.length; i++)
	{
		chart.series[i].update({
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

	if(colour !== undefined)
	{
		// Change style colour
		changeStyle(colour);

		// Change graph colour because why not
		changeGraphColour(colour);

		// Set dropdown to that colour
		$('#colourChange').val(colour);
	}
	else
	{
		// Set to default
		document.getElementById("pagestyle").setAttribute("href", "/assets/css/blue.css" );
	}
});
