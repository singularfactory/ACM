/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Js
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

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
		return true;
	}
	else {
		$("#progressbar").progressbar("value", percentage);
		setTimeout("updateProgressBar()", 750);
	}
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
			return true;
		}
		else {
			$("#progressbar_wrapper").fadeIn();
			
			if ( firstLoading ) {
				firstLoading = false;
				
				var percentage = $.ajax({
				  url: uploadProgressUrl,
				  async: false
				 }).responseText;
				$("#progressbar").progressbar("value", parseInt(percentage));
				
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