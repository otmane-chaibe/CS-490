
// Maurice Achtenhagen

"use strict"

function byId(id) {
	return document.getElementById(id)
}

function ajaxThenReload(url, body) {
	var httpRequest = new XMLHttpRequest()
	httpRequest.open("POST", url)
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body)
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
	ajaxThenReload("../Front-end/remove_question_from_test.php", body)
}

questions.forEach(function(id) {
	byId('delete' + id).onclick = function(e) { handleDelete(id) }
})

byId('update-weight-btn').onclick = function(e) {
	var sum = 0
	questions.forEach(function(id) {
		sum += parseInt(byId('weight-' + id).value)
	})
	if (sum != 100) {
		byId('test-msg-output').innerHTML = "The total sum must be equal to 100."
		return
	}
	questions.forEach(function(id) {
		var weight = byId('weight-' + id).value
		if (weight > 0 && weight < 100) {
			var body = "test_question_id=" + id + "&weight=" + weight
			var httpRequest = new XMLHttpRequest()
			httpRequest.open("POST", "../Front-end/update_question_weight.php")
			httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			httpRequest.send(body)
		}
	})
	byId('test-msg-output').innerHTML = "Changes saved successfully."
}

question_bank.forEach(function(id) {
	let li = byId('q-' + id)
	li.onclick = function(e) {
		var body = "test_id=" + test_id + "&question_id=" + id
		ajaxThenReload("../Front-end/add_question_to_test.php", body)
	}
})
