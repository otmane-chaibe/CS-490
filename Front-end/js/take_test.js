
// Maurice Achtenhagen

"use strict"

function byId(id) { return document.getElementById(id) }

byId('submit-btn').onclick = function(e) {
	byId('scrim').style.display = "block"
	document.body.style.overflow = "hidden"
	var body = ""
	var i = 0
	while (true) {
		if (i == identifiers.length) { break }
		var solution = byId("solution-" + identifiers[i]).value
		if (i == 0) {
			body += "solution[]=" + encodeURIComponent(solution) + "&qid[]=" + identifiers[i]
		} else {
			body += "&solution[]=" + encodeURIComponent(solution) + "&qid[]=" + identifiers[i]
		}
		i++
	}
	if (body == "") { return }
	body += "&test_id=" + testID
	var httpRequest = new XMLHttpRequest()
	httpRequest.open("POST", "../Front-end/submit_test.php")
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body);
	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status >= 200 && httpRequest.status < 300) {
				window.location.href = 'student.php'
			} else {
				var data = JSON.parse(httpRequest.responseText)
				byId('error').innerHTML = data.error
			}
		}
	}
}
