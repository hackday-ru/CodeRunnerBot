$(document).ready(function(){
	$('#input-form').submit(onFormSubmit);
	$('#input-select').change(function(){
		$('#input-field').text($('#'+$(this).find(':selected').text()).text());
		$('#result-block').hide();
		$('#two-description').hide();
	});
});

function onFormSubmit(){
	$.ajax({
		url: $('#SEND_REQUEST_COMPONENT_DIRECTORY').val() + 'send-request.php',
		data: $('#input-form').serialize(),
		dataType: 'json',
		timeout:30000,
		beforeSend:function(){
			$('#first-description').text('Данные отправляются').show();
			$('#result-block').hide();
			$('#two-description').hide();
		},
		success: function(data){
			if(data.status == 'good'){
				$('#first-description').text('Готово!');
				$('#two-description').show();
				$('#result-block').val(data.response.result).show();
				if(typeof data.response.error_compile == 'string'){
					$('#result-block').val(data.response.result + data.response.error_compile);
				}
				$('#two-description').show();
			}else{
				$('#input-field-description').text('Произошла незвестная ошибка.');
			}
		},
		error: function(){
			$('#first-description').text('Ошибка соединения.');
		}
	});
	
	return false;
}