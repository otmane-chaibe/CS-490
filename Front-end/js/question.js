
// Maurice Achtenhagen

"use strict"

var argumentTemplate = '\
	<tr id="row{ID}">\
		<td><input id="argname{ID}" type="text" placeholder="Argument" /></td>\
		<td>\
			<select id="argtype{ID}">\
				<option value="0" selected>Int</option>\
				<option value="1">Float</option>\
				<option value="2">Double</option>\
				<option value="3">String</option>\
				<option value="4">Bool</option>\
			</select>\
		</td>\
		<td><button id="delete{ID}" class="button red">Delete</button></td>\
	</tr>\
';

var unitTestInputTemplate = '\
	<td>\
		<ul id="inputs{ID}" class="inputs">\
			<li>\
				<input id="inputval{ID}" type="text" class="unit-input-txt" placeholder="Input">\
				<select id="unittype{ID}">\
					<option value="0" selected>Int</option>\
					<option value="1">Float</option>\
					<option value="2">Double</option>\
					<option value="3">String</option>\
					<option value="4">Bool</option>\
				</select>\
				<button id="addinput{ID}" class="button blue">Add Input</button>\
			</li>\
		</ul>\
		<div class="output-wrapper">\
			<input id="outputval{ID}" class="unit-output-txt" type="text" placeholder="Output">\
			<button id="deleteunit{ID}" class="button red">Delete</button>\
		</div>\
	</td>\
';

var httpRequest = new XMLHttpRequest()

function byId(id) {
	return document.getElementById(id)
}

function addUnitTestInput(e) {
	var id = e.target.id.substring(8)
	var inputs = byId("inputs" + id)
	var count = byId("unit-tests").children.length
	var html = '\
		<input id="inputval{ID}" type="text" class="unit-input-txt" placeholder="Input">\
		<select id="unittype{ID}">\
			<option value="0" selected>Int</option>\
			<option value="1">Float</option>\
			<option value="2">Double</option>\
			<option value="3">String</option>\
			<option value="4">Bool</option>\
		</select>\
	';
	html = html.replace("{ID}", count).replace("{ID}", count)
	var li = document.createElement("li")
	li.innerHTML = html
	inputs.appendChild(li)
}

function deleteUnitTest(e) {
	var id = e.target.id.substring(10)
	byId('inputrow' + id).remove()
}

function deleteArgument(e) {
	var id = e.target.id.substring(6)
	byId('row' + id).remove()
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
	var i = 0
	var args = byId("arguments").children
	while (true) {
		if (args[i] == undefined) { return }
		var id = args[i].id.substring(3)
		byId('delete' + id).onclick = deleteArgument
		byId('argname' + id).value = (names[id] === undefined ? "" : names[id])
		i++
	}
}

byId('add-unit-test').onclick = function(e) {
	var a = byId("unit-tests")
	var inputs = []
	var types = []
	var i = 0
	while (true) {
		if (a.children[i] == undefined) { break }
		var id = a.children[i].id.substring(8)
		inputs[id] = byId('inputval' + id).value
		var j = 0
		var options = byId('unittype' + id).options
		while (true) {
			if (options[j] == undefined) { break }
			if (options[j].selected) { types[id] = options[j].value }
			j++
		}
		i++
	}
	var count = a.children.length
	var html = unitTestInputTemplate.replace("{ID}", count).replace("{ID}", count).replace("{ID}", count).replace("{ID}", count).replace("{ID}", count).replace("{ID}", count).replace("{ID}", count)
	var tr = document.createElement("tr")
	tr.setAttribute("id", "inputrow" + count)
	tr.innerHTML = html
	a.appendChild(tr)
	var i = 0
	var unitTests = byId("unit-tests").children
	while (true) {
		if (unitTests[i] == undefined) { return }
		var id = unitTests[i].id.substring(8)
		byId('addinput' + id).onclick = addUnitTestInput
		byId('deleteunit' + id).onclick = deleteUnitTest
		i++
	}
}

byId('submit').onclick = function(e) {
	var type = byId("question-type").selectedIndex
	var diff = byId("question-difficulty").selectedIndex
	var name = encodeURIComponent(byId("function-name").value)
	var description = encodeURIComponent(byId("description").value)
	var returnType = byId("func-type").selectedIndex
	var unitTestInputs = document.getElementById("unit-input").value.split(",")
	var unitTestOutput = document.getElementById("unit-output").value

	var body = "category=" + type + "&difficulty=" + diff + "&fname=" + name + "&returntype=" + returnType
	body += "&description=" + description + "&unitout=" + unitTestOutput

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
	i = 0
	while (true) {
		if (i == unitTestInputs.length) { break }
		body += "&unitin[]=" + unitTestInputs[i]
		i++
	}

	httpRequest.open("POST", "../Front-end/create_question.php")
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body)

	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status >= 200 && httpRequest.status < 300) {
				// location.reload()
			} else {
				var data = JSON.parse(httpRequest.responseText)
				byId('error').innerHTML = data.error
			}
		}
	}
}
