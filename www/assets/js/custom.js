// This function changes the style sheet
function changeStyle()
{
	switch ($("#colourChange option:selected").val())
	{
		case "red":
			document.getElementById('pagestyle').setAttribute('href', "http://uni.scottsmudger.website/assets/css/red.css");
			break;
		
		case "default":
			document.getElementById('pagestyle').setAttribute('href', "http://uni.scottsmudger.website/assets/css/default.css");
			break;
		
		case "green":
			document.getElementById('pagestyle').setAttribute('href', "http://uni.scottsmudger.website/assets/css/green.css");
			break;
		
		default:
			document.getElementById('pagestyle').setAttribute('href', "http://uni.scottsmudger.website/assets/css/default.css");
	}

	$.cookie("sheet", $("#colourChange option:selected").val(), {expires: 10});
}

// Checks the javascript cookie to see what style sheet has been set
function checkCookie()
{
	var sheet = $.cookie("sheet");

	if(sheet !== undefined)
	{
		document.getElementById('pagestyle').setAttribute('href', "http://uni.scottsmudger.website/assets/css/" + sheet + ".css" );
	}
}

checkCookie();
