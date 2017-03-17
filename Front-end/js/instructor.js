"use strict";

var httpRequest = new XMLHttpRequest()

function byId(id) {
	return document.getElementById(id)
}

function ajaxThenReload(url, body) {
	var httpRequest = new XMLHttpRequest()

	httpRequest.open("POST", url)
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body);

	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status == 200) {
				location.reload()
			}
		}
	}
}

byId('submit').onclick = function(e) {
	var name = encodeURIComponent(byId("name").value)
	var body = "name=" + name
	ajaxThenReload("../Front-end/create_test.php", body)
}
