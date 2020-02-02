
function Characters(event) {

	var elements = event.currentTarget;
	document.getElementById("characters").textContent = elements[0].value.length;
	}
}

document.getElementById("questionCreat").addEventListener("submit",
		questionCreatFrom, false);
document.getElementById("questionCreat").addEventListener("reset", ResetForm,
		false);
document.getElementById("questionCreat").addEventListener("keyup", Characters,
		false);
