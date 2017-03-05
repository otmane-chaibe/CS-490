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

function deleteArgument(e) {
	var id = e.target.id.substring(6)
	document.getElementById('row' + id).remove()
	var count = document.getElementById("arguments").children.length
	document.getElementById('argumentCounter').innerHTML = count
}

document.getElementById('add-arg').onclick = function(e) {
	var a = document.getElementById("arguments")
	var names = []
	var types = []
	var i = 0
	while (true) {
		if (a.children[i] == undefined) { break }
		var id = a.children[i].id.substring(3)
		names[id] = document.getElementById('argname' + id).value
		var j = 0
		var options = document.getElementById('argtype' + id).options
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
	document.getElementById('argumentCounter').innerHTML = count + 1

	var i = 0
	var args = document.getElementById("arguments").children
	while (true) {
		if (args[i] == undefined) { return }
		var id = args[i].id.substring(3)
		document.getElementById('delete' + id).onclick = deleteArgument
		document.getElementById('argname' + id).value = (names[id] === undefined ? "" : names[id])
		document.getElementById('argtype' + id).selectedIndex = (types[id] === undefined ? -1 : types[id])
		i++
	}
}

document.getElementById('submit').onclick = function(e) {

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

}
