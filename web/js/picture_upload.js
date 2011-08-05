var progressKey;
var uploadForm;
var firstLoading;
var uploadProgressUrl = null;

function updateProgressBar() {
	var percentage = parseInt($.ajax({
	  url: uploadProgressUrl,
	  async: false
	 }).responseText);
	
	if ( percentage == 100 ) {
		$("#progressbar").fadeOut();
		$("#progressbar_wrapper").children('p').first().html('Processing pictures... <img src="/images/progress.gif" height="15" width="15" alt="..."/>');
	}
	else {
		$("#progressbar").progressbar("value", percentage);
	}
	setTimeout("updateProgressBar()", 750);
}

$(document).ready(function(){
	// Add the progress bar
	$("#progressbar").progressbar();
	
	// Set initial variables
	progressKey = $("#progress_key").val();
	uploadForm = $("#progressbar_wrapper").closest('form');
	firstLoading = true;
	
	// Build custom upload progress URL
	regexp = /^(\/.*.php)?\/(\w+)\/.*$/;
	if ( matches = regexp.exec($(uploadForm).attr('action')) ) {
		uploadProgressUrl = '/' + matches[2] + '/uploadProgress/' + progressKey;
	}

	// Fades in the progress bar and starts polling the upload progress
	$(uploadForm).submit(function(){
		var nFiles = 0;
		$(".model_picture_filename").each(function(index, element){
			nFiles += $(element).children('input').val().length;
		})

		if ( nFiles == 0 ) {
			$("#progress_key").remove();	// AVOID APC 3.1.6 bug
		}
		else {
			$("#progressbar_wrapper").fadeIn();
			
			if ( firstLoading ) {
				var percentage = $.ajax({
				  url: uploadProgressUrl,
				  async: false
				 }).responseText;
				
				$("#progressbar").progressbar("value", parseInt(percentage));
				firstLoading = false;
				$(uploadForm).submit();
				updateProgressBar();
				
				return false;
			}
			else {
				return true;
			}
		}
	});
});