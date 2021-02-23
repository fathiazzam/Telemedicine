$(document).ready(function(){
	if (window.localStorage.id_call == null) {
		window.localStorage.id_call = 0;
		window.localStorage.notif = 0;
		window.localStorage.video = 0;
	}
	var url = window.location.protocol+'//'+window.location.hostname+'/telemedic'
// updating the view with notifications using ajax
	function load_unseen_notification(){
		if (window.localStorage.notif == 0) {
			online_notification();
			caller_notification();
		}if (window.localStorage.notif == 1) {
			online_notification();
			receive_notification();
		}if (window.localStorage.notif == 2) {
			online_notification();
			receive_notification();
		}if (window.localStorage.notif == 3) {
			online_notification();
			cancel_notification();
		}
	}

	function online_notification(){		
		$.ajax({
			url:"n",
			method:"POST",
			dataType:"json"
		}).done(function(result){
			var print = "";
			for (var i = 0; i < result.length; i++) {
				var ref = '#';
				var able = 'disabled';
				var stat = 'Off';
				var alert = 'danger';
				var button = '';
				if (result[i].status == 1) {
					ref = result[i].user_id;
					able = '';
					stat = 'On';
					alert = 'success" style="outline-color: #00a400;';
					button = '<p></p><div class="btn-group btn-group-toggle" data-toggle="buttons"> <button id="video'+i+'" type="button" class="btn btn-outline-'+alert+' btn-sm" value="'+ref+'"'+able+'> <span aria-hidden="true"><img src="'+url+'/assets/img/glyphicons-181-facetime-video.png" width="15" height="10"></span></button>'+
				' <button type="button" id="audio'+i+'" class="btn btn-outline-'+alert+' btn-sm" value="'+ref+'"'+able+'> <span aria-hidden="true"><img src="'+url+'/assets/img/glyphicons-443-earphone.png" width="15" height="15"></span></button>'+
				' <button type="button" id="message'+i+'" class="btn btn-outline-success btn-sm" value="'+ref+'"> <span aria-hidden="true"><img src="'+url+'/assets/img/glyphicons-246-chat.png" width="15" height="15"></span></button></div>';
				}else if(result[i].status == 2){
					alert = 'warning';
					stat = 'On';
					button = '<p></p><div class="btn-group btn-group-toggle" data-toggle="buttons">'+
				'<button id="video'+i+'" type="button" class="btn btn-outline-'+alert+' btn-sm" value="'+ref+'"'+able+'> <span aria-hidden="true"><img src="'+url+'/assets/img/glyphicons-181-facetime-video.png" width="15" height="10"></span></button>'+
				' <button type="button" id="audio'+i+'" class="btn btn-outline-'+alert+' btn-sm" value="'+ref+'"'+able+'> <span aria-hidden="true"><img src="'+url+'/assets/img/glyphicons-443-earphone.png" width="15" height="15"></span></button>'+
				' <button type="button" id="message'+i+'" class="btn btn-outline-success btn-sm" value="'+ref+'"> <span aria-hidden="true"><img src="'+url+'/assets/img/glyphicons-246-chat.png" width="15" height="15"></span></button></div>';
				}
				print += '<div id="line" class="list-group-item list-group-item-action">'+result[i].fullName+button+
				'</div><div class="badge badge-'+alert+'" >'+stat+'</div>';
			}
			document.getElementById("online").innerHTML = print;
			for (var i = 0; i < result.length; i++) {
				$('#video'+i).click(function() {
	    			var id = $(this).val();
	    			var video = 1;
	    		    if (id != null) call(id,video);
	    		});
	    		$('#audio'+i).click(function() {
	    			var id = $(this).val();
	    		    var video = 0;
	    		    if (id != null) call(id,video);
	    		});
	    		$('#message'+i).click(function() {
	    			var id = $(this).val();
	    		    if (id != null) chat(id);
	    		});
			}
		});	
	}

	function caller_notification(){		
		$.ajax({
			url:"call",
			method:"POST",
			dataType:"json"
		}).done(function(result){
			if (result !== null) {
				window.localStorage.id_call = result.id_call;
				window.localStorage.notif = 2;
				document.getElementById("call").innerHTML = result.fullName.fullName+' <button id="receive" class="btn btn-default">Receive</button>';
				$("#receive").click(function() {
				    receive();
				});
				$("#myModal").modal("show");
			}	
		});		
	}

	function receive_notification(){
		$.ajax({
			url:"r",
			method:"POST",
			dataType:"json",
			data: {
				id_call: window.localStorage.id_call
			}
		}).done(function(result){
			if (result.status == 0) {
				window.localStorage.id_call = 0;
				window.localStorage.notif = 0;
				window.localStorage.video = 0;
				$("#myModal").modal("hide");
			}if (result.status == 2) {
				window.localStorage.notif = 3;
				if (result.video == 1) {
					window.localStorage.video = 1;
				}
				window.location.href = "vc?room="+window.localStorage.id_call;
			}
		});
	}

	function cancel_notification(){
		$.ajax({
			url:"r",
			method:"POST",
			dataType:"json",
			data: {
				id_call: window.localStorage.id_call
			}
		}).done(function(result){
			if (result == 0) {
				window.localStorage.id_call = 0;
				window.localStorage.notif = 0;
				window.location.href = "home";
			}
		});
	}

	function call(id,video){
		$.ajax({
			url:"c/"+id,
			method:"POST",
			dataType:"json",
			data: {
				video: video
			}
		}).done(function(result){
			if (result !== null) {
				window.localStorage.id_call = result.id_call.id_call;
				window.localStorage.notif = 1;
				document.getElementById("call").innerHTML = result.fullName.fullName;
				$("#myModal").modal("show");
			}else{
				alert("Can't call ");
			}			
		});
	}

	function receive(){
		$.ajax({
			url:"receive",
			method:"POST",
			dataType:"json",
			data: {
				id_call: window.localStorage.id_call
			}
		}).done(function(result){
			window.localStorage.notif = 3;
			if (result.video == 1) {
				window.localStorage.video = 1;
			}
			window.location.href = "vc?room="+window.localStorage.id_call;
		});
	}

	$("#cancel").click(function(){
		$.ajax({
			url:"cancel",
			method:"POST",
			dataType:"json",
			data: {
				id_call: window.localStorage.id_call
			}
		}).done(function(result){
			window.localStorage.id_call = 0;
			window.localStorage.notif = 0;
			window.localStorage.video = 0;
			$("#myModal").modal("hide");
		});
	});

	$("#cancel2").click(function(){
		$.ajax({
			url:"cancel",
			method:"POST",
			dataType:"json",
			data: {
				id_call: window.localStorage.id_call
			}
		}).done(function(result){
			window.localStorage.id_call = 0;
			window.localStorage.notif = 0;
			window.localStorage.video = 0;
			window.location.href = "home";
		});
	});

	function chat(id){
		$.ajax({
			url:"chat",
			method:"POST",
			dataType:"json",
			data: {
				id: id
			}
		}).done(function(result){
			window.open("https://web.whatsapp.com/send?phone=+62"+result.phone);			
		});
	}

	setInterval(function(){
		load_unseen_notification();
	}, 5000);

});