function show(user, time, message) {
	return '<div class="panel panel-default message"><div class="panel-heading message_user">'+user+'</div><div class="panel-heading message_time">'+time+'</div><div class="panel-body message_message">'+message+'</div></div>';
}

$(document).ready(function(){
	$('#conversation').val(code);

	$('input').on('keypress', function(e){
		if (e.which == 13) {
			if ($(this).is('#login')) {
				if ($('#login').val() != '') {
					$.post('login.php', {username: $('#login').val()}, function(data){
						if (data == 'true') {
							username = $('#login').val();
							$('#login').val('');
							$('.messages').show();
							$('#login').attr('placeholder', '');
							$('#login').attr('id', 'message_input');
							last_id = 0;
						}
					});
				}
			} else if ($(this).is('#message_input')) {
				if ($('#message_input').val() != '') {
					$.post('send.php', {user: username, message: $('#message_input').val(), conversation: conversation});
					$('#message_input').val('');
				}
			} else if ($(this).is('#conversation')) {
				window.location.href = 'msg-'+$(this).val();
			}
		}
	});

	$('#new').click(function(){
		$.post('api/conversation', function(data){
			var code = JSON.parse(data)[0];
			window.location.href = 'msg-'+code;
		});
	});

	$('#logout').click(function(){
		$.post('login.php', {logout: true});
		username = 'guest';
		$('.messages').hide();
		$('#message_input').attr('id', 'login');
		$('#login').attr('placeholder', 'Username');
	});
});

var last_id = 0;
setInterval(function(){
	$.get('update.php?id='+conversation+'&last_id='+last_id, function(data){ 
		var messages = JSON.parse(data)[0];
		last_id = JSON.parse(data)['last_id'];
		for (var i=0;i<messages.length;i++) {
			$('.messages').append(show(messages[i]['user'], messages[i]['time'], messages[i]['message']));
		}
		if (messages != '') {
			$('.messages').scrollTop($('.messages')[0].scrollHeight);
		}
	});
}, 100);