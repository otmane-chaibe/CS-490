"use strict";

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

function handleDelete(id) {
	var body = "test_id=" + test_id + "&question_id=" + id
	ajaxThenReload("../Middle-end/remove_question_from_test.php", body)
}

questions.forEach(function(id) {
	byId('delete' + id).onclick = function(e) { handleDelete(id) }
})

byId('submit').onclick = function(e) {
	var body = "test_id=" + test_id + "&question_id=" + byId('question').value
	ajaxThenReload("../Middle-end/add_question_to_test.php", body)
}
