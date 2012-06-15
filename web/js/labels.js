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

function clearResults() {
  $('#right_side_form').empty();
  $('div.submit').remove();
}

function addCultureMediumListener() {
  $('#culture_medium_id').change(function(){
    var culture_medium_id = $(this).val();
    clearResults();

    $.get('create_label/get_label_field/strain/' + culture_medium_id, function(result){
      $('form').append('<div class="submit"><input type="submit" value="Create labels"></div>');
      $('#right_side_form').append(result);
    });
  });
}

function addContainerListener() {
  $('#container_id').change(function(){
    var container_id = $(this).val();
    $('#container').nextAll().remove();
    clearResults();

    $.get('create_label/get_label_field/culture_medium/' + container_id, function(result){
      $('#left_side_form').append(result);
      addCultureMediumListener();
    });
  });
}

function addAxenicityListener() {
  $('#is_axenic').change(function(){
    var is_axenic = $(this).val();
    $('#axenicity').nextAll().remove();
    clearResults();

		if ($('form.patent-deposit').length || $('form.maintenance-deposit').length) {
			$.get('create_label/get_label_field/culture_medium/' + is_axenic, function(result){
				$('#left_side_form').append(result);
				addCultureMediumListener();
			});
		} else {
			$.get('create_label/get_label_field/container/' + is_axenic, function(result){
				$('#left_side_form').append(result);
				addContainerListener();
			});
		}
	});

}

function addGenusListener() {
  $('#genus_id').change(function(){
    var genus_id = $(this).val();
    $('#genus').nextAll().remove();
    clearResults();

    $.get('create_label/get_label_field/axenicity/' + genus_id, function(result){
      $('#left_side_form').append(result);
      addAxenicityListener();
    });
  });
}

function addTransferIntervalListener() {
  $('#transfer_interval').change(function(){
    var transfer_interval = $(this).val();
    $('#transfer_intervals').nextAll().remove();
    clearResults();

    $.get('create_label/get_label_field/genus/' + transfer_interval, function(result){
      $('#left_side_form').append(result);
      addGenusListener();
    });
  });
}

$(document).ready(function(){
  // Update strain label form when selecting a supervisor
  $('#supervisor_id').change(function(){
    var supervisor_id = $(this).val();
    $('#supervisor').nextAll().remove();
    clearResults();

    $.get('create_label/get_label_field/transfer_intervals/' + supervisor_id, function(result){
      $('#left_side_form').append(result);
      addTransferIntervalListener();
    });
  });
});

