function byId(id) {
	return document.getElementById(id)
}

byId('filter-search-btn').onclick = function(e) {
	var httpRequest = new XMLHttpRequest()
	var keyword = encodeURIComponent(byId("filter-search").value)
	var body = "keyword=" + keyword
	httpRequest.open("POST", "../Front-end/search_for_question.php")
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body)

	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status >= 200 && httpRequest.status < 300) {
				performSearch(JSON.parse(httpRequest.responseText))
			}
		}
	}
}

byId('filter-type').onchange = function() {
	var type = "Conditional"
	switch (this.selectedIndex) {
		case 0: type = "Category"; break
		case 1: type = "Conditional"; break
		case 2: type = "Control Flow"; break
		case 3: type = "Recursion"; break
		case 4: type = "Other"; break
		default: type = "Question Type"; break
	}
	byId('filter-type-label').innerHTML = type
	performFilter()
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
	performFilter()
}

function performFilter() {
	let category = byId('filter-type').value
	let difficulty = byId('filter-difficulty').value
	let body = "category=" + category + "&difficulty=" + difficulty
	var httpRequest = new XMLHttpRequest()
	httpRequest.open("POST", "../Front-end/filter_questions.php")
	httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	httpRequest.send(body)
	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status >= 200 && httpRequest.status < 300) {
				performSearch(JSON.parse(httpRequest.responseText))
			}
		}
	}
}

function performSearch(results) {
	let list = byId('question-list')
	while (list.firstChild) {
	    list.removeChild(list.firstChild);
	}
	for (let i in results) {
    	var li = document.createElement('li')
    	var p = document.createElement('p')
    	p.classList.add(results[i].difficulty_str)
    	p.innerHTML = generateQuestionDescription(results[i])
    	li.appendChild(p)
    	if (typeof ajaxThenReload == 'function') {
			li.onclick = function(e) {
				var body = "test_id=" + test_id + "&question_id=" + results[i].id
				ajaxThenReload("../Front-end/add_question_to_test.php", body)
			}
    	} else {
	    	console.log("not defined")
    	}
    	list.appendChild(li)
	}
}

function generateQuestionDescription(question) {
	var argumentStr = "arguments"
	if (question.arguments.length == 1) {
		argumentStr = "argument"
	}
	return '\
		Write a function of type <strong>' + question.function_type_str + '</strong>\
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
