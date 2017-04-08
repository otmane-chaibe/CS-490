
// Maurice Achtenhagen

"use strict"

var argumentTemplate = '\
	<tr id="row{ID}">\
		<td><input id="argname{ID}" type="text" placeholder="Argument" required></td>\
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
		<ul id="inputs{ID}" class="inputs"></ul>\
		<div class="output-wrapper">\
			<input id="outputval{ID}" class="unit-output-txt" type="text" placeholder="Output">\
			<button id="deleteunit{ID}" class="button red">Delete</button>\
		</div>\
	</td>\
';

function byId(id) {
	return document.getElementById(id)
}

function addUnitTestInput(list) {
	var html = '\
		<input type="text" class="unit-input-txt" placeholder="Input" required>\
		<select class="input-type-selector">\
			<option value="0" selected>Int</option>\
			<option value="1">Float</option>\
			<option value="2">Double</option>\
			<option value="3">String</option>\
			<option value="4">Bool</option>\
		</select>\
	';
	var li = document.createElement("li")
	li.innerHTML = html
	list.appendChild(li)
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
	var tests = byId("unit-tests")
	var count = tests.children.length
	var html = unitTestInputTemplate.replace("{ID}", count).replace("{ID}", count).replace("{ID}", count).replace("{ID}", count).replace("{ID}", count).replace("{ID}", count)
	var tr = document.createElement("tr")
	tr.setAttribute("id", "inputrow" + count)
	tr.innerHTML = html
	tests.appendChild(tr)
	// Add the same number of unit test inputs as function arguments
	var list = byId("inputs" + count)
	var argCount = byId("arguments").children.length
	for (var i = 0; i < argCount; i++) {
		addUnitTestInput(list)
	}
	var i = 0
	var unitTests = byId("unit-tests").children
	while (true) {
		if (unitTests[i] == undefined) { return }
		var id = unitTests[i].id.substring(8)
		byId('deleteunit' + id).onclick = deleteUnitTest
		i++
	}
}

byId('submit').onclick = function(e) {
	var httpRequest = new XMLHttpRequest()
	var type = byId("question-type").selectedIndex
	var diff = byId("question-difficulty").selectedIndex
	var name = encodeURIComponent(byId("function-name").value)
	var description = encodeURIComponent(byId("description").value)
	var returnType = byId("func-type").selectedIndex
	var body = "category=" + type + "&difficulty=" + diff + "&fname=" + name + "&return_type=" + returnType + "&description=" + description
	var args = byId("arguments").children
	var i = 0
	while (true) {
		if (args[i] == undefined) { break }
		var id = args[i].id.substring(3)
		var name = encodeURIComponent(byId("argname" + id).value)
		var type = byId("argtype" + id).selectedIndex
		body += "&arg_name[]=" + name + "&arg_type[]=" + type
		i++
	}
	httpRequest.open("POST", "../Front-end/create_question.php")
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body)

	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status >= 200 && httpRequest.status < 300) {
				var question_id = JSON.parse(httpRequest.responseText)
				createUnitTest(question_id)
			} else {
				var data = JSON.parse(httpRequest.responseText)
				byId('error').innerHTML = data.error
			}
		}
	}
}

function createUnitTest(question_id) {
	var httpRequest = new XMLHttpRequest()
	var unitTests = byId("unit-tests").children
	for (var i = 0; i < unitTests.length; i++) {
		if (unitTests[i] == undefined) { break }
		var httpRequest = new XMLHttpRequest()
		var id = unitTests[i].id.substring(8)
		var output = byId("outputval" + id).value
		var body = "question_id=" + question_id + "&output=" + encodeURIComponent(output)
		var inputs = byId("inputs" + id).children
		for (var j = 0; j < inputs.length; j++) {
			var inputTexts = inputs[j].getElementsByClassName('unit-input-txt')
			var inputSelectors = inputs[j].getElementsByClassName('input-type-selector')
			var input = encodeURIComponent(inputTexts[0].value)
			var type = inputSelectors[0].selectedIndex
			body += "&input[]=" + input + "&input_type[]=" + type
		}
		httpRequest.open("POST", "../Front-end/create_unit_test.php")
		httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		httpRequest.send(body)
	}

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

byId('filter-search-btn').onclick = function(e) {
	var httpRequest = new XMLHttpRequest()
	var keyword = encodeURIComponent(byId("filter-search").value)
	var body = "keyword=" + keyword
	var args = byId("arguments").children
	httpRequest.open("POST", "../Front-end/search_for_question.php")
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body)

	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status >= 200 && httpRequest.status < 300) {
				performSearch(JSON.parse(httpRequest.responseText))
			} else {
				// var data = JSON.parse(httpRequest.responseText)
				// byId('error').innerHTML = data.error
			}
		}
	}
}

byId('filter-type').onchange = function() {
	var type = "Conditional"
	switch (this.selectedIndex) {
		case 0: type = "Question Type"; break
		case 1: type = "Conditional"; break
		case 2: type = "Control Flow"; break
		case 3: type = "Recursion"; break
		case 4: type = "Other"; break
		default: type = "Question Type"; break
	}
	byId('filter-type-label').innerHTML = type
}

byId('filter-difficulty').onchange = function() {
	var type = "Difficulty"
	switch (this.selectedIndex) {
		case 0: type = "Difficulty"; break
		case 1: type = "Easy"; break
		case 2: type = "Medium"; break
		case 3: type = "Difficult"; break
		default: type = "Difficulty"; break
	}
	byId('filter-difficulty-label').innerHTML = type
}

function performSearch(results) {
	let list = byId('question-list')
	while (list.firstChild) {
	    list.removeChild(list.firstChild);
	}
	for (let i in results) {
    	var li = document.createElement('li')
    	var p = document.createElement('p')
    	p.classList.add(results[i].difficulty)
    	p.innerHTML = generateQuestionDescription(results[i])
    	li.appendChild(p)
    	list.appendChild(li)
	}
}

function generateQuestionDescription(question) {
	var argumentStr = "arguments"
	if (question.arguments.length == 1) {
		argumentStr = "argument"
	}
	return '\
		Write a function of type <strong>' + question.function_type + '</strong>\
		 named <strong>' + question.function_name + '</strong>\
		that accepts ' + question.arguments.length + ' ' + argumentStr + '  of type (' + getArgs(question.arguments) + '), ' + question.description
}

function getArgs(args) {
	var argStr = ""
	for (let i in args) {
		argStr += "<strong>" + args[i].type + "</strong>"
		if (i != args.length - 1) { argStr += ", " }
	}
	return argStr
}
