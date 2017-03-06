"use strict";

var argumentTemplate = '\
	<tr id="row{ID}">\
		<td><input class="argname" id="argname{ID}" type="text" /></td>\
		<td>\
			<select class="argtype" id="argtype{ID}">\
				<option value="0">Int</option>\
				<option value="1">Float</option>\
				<option value="2">Double</option>\
				<option value="3">String</option>\
				<option value="4">Bool</option>\
			</select>\
		</td>\
		<td><button id="delete{ID}">Delete</button></td>\
	</tr>\
';

var httpRequest = new XMLHttpRequest()

function byId(id) {
	return document.getElementById(id)
}

function deleteArgument(e) {
	var id = e.target.id.substring(6)
	byId('row' + id).remove()
	var count = byId("arguments").children.length
	byId('argumentCounter').innerHTML = count
}

byId('add-arg').onclick = function(e) {
	var a = byId("arguments")
	var names = []
	var types = []
	var i = 0
	while (true) {
		if (a.children[i] == undefined) { break }
		var id = a.children[i].id.substring(3)
		names[id] = byId('argname' + id).value
		var j = 0
		var options = byId('argtype' + id).options
		while (true) {
			if (options[j] == undefined) { break }
			if (options[j].selected) { types[id] = options[j].value }
			j++
		}
		i++
	}

	var count = a.children.length
	var html = argumentTemplate.replace("{ID}", count).replace("{ID}", count).replace("{ID}", count).replace("{ID}", count)
	a.innerHTML = a.innerHTML + html
	byId('argumentCounter').innerHTML = count + 1

	var i = 0
	var args = byId("arguments").children
	while (true) {
		if (args[i] == undefined) { return }
		var id = args[i].id.substring(3)
		byId('delete' + id).onclick = deleteArgument
		byId('argname' + id).value = (names[id] === undefined ? "" : names[id])
		byId('argtype' + id).selectedIndex = (types[id] === undefined ? -1 : types[id])
		i++
	}
}

byId('submit').onclick = function(e) {
	var type = byId("question-type").selectedIndex
	var diff = byId("question-difficulty").selectedIndex
	var name = encodeURIComponent(byId("function-name").value)
	var returns = byId("func-type").selectedIndex
	var solution = encodeURIComponent(byId("solution").value)

	var body = "type=" + type + "&difficulty=" + diff + "&name=" + name + "&returns=" + returns + "&solution=" + solution

	var c = byId("arguments").children
	var i = 0
	while (true) {
		if (c[i] == undefined) { break }
		var id = c[i].id.substring(3)
		var name = encodeURIComponent(byId("argname" + id).value)
		var type = byId("argtype" + id).selectedIndex
		body += "&argname[]=" + name + "&argtype[]=" + type
		i++
	}

	httpRequest.open("POST", "../Middle-end/create_question.php")
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body);

	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status >= 200 && httpRequest.status < 300) {
				location.reload()
			} else {
				var data = JSON.parse(httpRequest.responseText)
				byId('error').innerHTML = data.error
			}
		}
	}
}
