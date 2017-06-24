function get_page(action_form){
	document.forms[0].action = "index.php?action="+action_form
	return true;
}