// Maurice Achtenhagen

"use strict";

var httpRequest = new XMLHttpRequest();

document.getElementById("submit").addEventListener("click", function() {
	var ucid = document.getElementById("ucid").value;
	var pass = document.getElementById("pass").value;
	if (ucid === "" || pass === "") { return; }
	var body = "ucid=" + ucid + "&pass=" + pass;
	httpRequest.open("POST", "dologin.php");
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	httpRequest.send(body);
});

httpRequest.onreadystatechange = function() {
	var status = document.getElementById("status");
	if (httpRequest.readyState === XMLHttpRequest.DONE) {
		var data = JSON.parse(httpRequest.responseText);
		if (!data) {
			status.innerHTML = "<span class='error'>Error - Bad response data</span>";
			status.style.display = "block";
			return;
		}
		if (httpRequest.status === 200) {
			status.innerHTML = "NJIT: <span class='" + (data.njit.status == 200 ? 'ok' : 'error') + "'>" + data.njit.response + "</span>, ";
			status.innerHTML += "database: <span class='" + (data.db.status == 200 ? 'ok' : 'error') + "'>" + data.db.response + "</span>";
		} else {
			status.innerHTML = "<span class='error'>HTTP " + data.status + " - " + data.response + "</span>";
		}
	}
	status.style.display = "block";
};