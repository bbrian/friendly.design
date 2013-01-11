var editor = CodeMirror.fromTextArea(document.getElementById("newcontent"), {
	
	lineNumbers: true,
	matchBrackets: true,
	mode: "application/x-httpd-php",
	indentUnit: 4,
	indentWithTabs: true,
	enterMode: "keep",
	tabMode: "shift",
	lineWrapping: true,
	fixedGutter: true,
	tabSize: 2,
	theme: "monokai",
	onCursorActivity: function() {
		editor.setLineClass(hlLine, null);
		hlLine = editor.setLineClass(editor.getCursor().line, "activeline");
	}
	
});
  
var hlLine = editor.setLineClass(0, "activeline");