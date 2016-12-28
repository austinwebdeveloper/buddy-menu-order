/**
 * Script for foodpress settings
 * @version 0.1
 */

jQuery(document).ready(function($){ 

	$('#fpoo_distime_start').timepicker({'timeFormat': 'H:i','step':'60'});
	$('#fpoo_distime_end').timepicker({'timeFormat': 'H:i','step':'60'});

	// update end time
	$('#fpoo_distime_start').on('change', function(){
		$('#fpoo_distime_end').timepicker({
			'minTime': $('#fpoo_distime_start').val(),
			'maxTime':'11:30pm',
			'timeFormat': 'H:i','step':'60'
		});
	});

	// add new times
	$('body').on('click','#fpoo_distime_btn', function (){	

		dayofweek = $(this).closest('.dayofweek');		
		var date = dayofweek.find('select').val();
		var start = dayofweek.find('#fpoo_distime_start').val();
		var end = dayofweek.find('#fpoo_distime_end').val();

		dayofweek.find('.message').hide();// reset error message for the form

		if(!date || !start || !end){ // check if all values are submitted
			dayofweek.find('.message').html('Required Fields Missing!').fadeIn();
			return;
		}

		day = dayofweek.find('select option:selected').attr('data-day');

		var html = "<p data-data='"+date+'-'+start+'-'+end+"'>"+day+' '+start+'-'+end+"<b>X</b></p>";

		$(this).closest('.fpoo_distime_form').siblings('.fpoo_ditimes').append(html);

		update_times();
	});

	//update time values
	function update_times(){
		val ='';
		$('.fpoo_ditimes').find('p').each(function(){
			if($(this).attr('data-data')!='' && $(this).attr('data-data')!== undefined)
				val += $(this).attr('data-data')+',';
		});

		$('.fpoo_ditimes').find('input').attr({'value':val});
	}

	// remove time
	$('body').on('click','.fpoo_ditimes b',function(){
		obj = $(this).parent();
		obj.fadeOut(function(){
			obj.remove();
			update_times();
		});

		
	});
});