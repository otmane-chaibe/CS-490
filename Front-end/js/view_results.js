
// Maurice Achtenhagen

"use strict"

function byId(id) { return document.getElementById(id) }

identifiers.forEach(function(id) {
	byId('score-counter-' + id).onchange = function(e) {
		var body = "id=" + this.dataset.id + "&test_id=" + testID + "&score=" + this.value
		var httpRequest = new XMLHttpRequest()
		httpRequest.open("POST", "../Front-end/update_question_score.php")
		httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		httpRequest.send(body)
		httpRequest.onreadystatechange = function() {
			if (httpRequest.readyState === XMLHttpRequest.DONE) {
				if (httpRequest.status >= 200 && httpRequest.status < 300) {
					console.log("Success.")
				}
			}
		}
	}
	byId('question-edit-btn-' + id).onclick = function(e) {
		var body = "id=" + this.dataset.id + "&remark=" + byId('remark-' + id).value
		var httpRequest = new XMLHttpRequest()
		httpRequest.open("POST", "../Front-end/update_question_remark.php")
		httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		httpRequest.send(body)
		httpRequest.onreadystatechange = function() {
			if (httpRequest.readyState === XMLHttpRequest.DONE) {
				if (httpRequest.status >= 200 && httpRequest.status < 300) {
					location.reload()
				}
			}
		}
	}
})
