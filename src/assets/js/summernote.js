$(document).ready(function() {
	$('#summernote').summernote({
		placeholder: '',
		height: 200,                 
		minHeight: null,             
		maxHeight: null,             
		focus: false,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview', 'undo', 'redo']]
        ]
	});
});
