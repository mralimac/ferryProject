function httpGetAsync(theUrl, callback){
	console.log(theUrl)
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            callback(JSON.parse(xmlHttp.responseText));
		}
    }
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}

function getUsersLastPage(cookie){
	var array = cookie.split("=");
	var cookieValue = array[1];
	httpGetAsync("api/GetLastPage.php?id="+cookieValue, function(response){
		console.log(response);
	});
}