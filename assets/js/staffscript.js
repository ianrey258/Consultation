var time = "<option value=01:>"

$('#date').datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true
});
$('#datebutton').datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true
});
// $('#time1').timepicker();
// $('#time2').timepicker();
$(document).ready(function(){
	viewrequest();
	viewappointment();
	viewSched();
	Edit();
	function viewrequest(){
		$.ajax({
			type:'ajax',
			url:'/Consultation/Account/viewRequest',
			async:'false',
			success:function(data){
				var output ='';
				var count=0;
				var reqdata = JSON.parse(data);
			    for(var i=0;i<reqdata.length;i++) {
			    count+=1;
				output +='<tr>'
			    			+'<td>'+count+'</td>'
			    			+'<td><a href="" data-toggle="modal" data-target="#accountinfo" class="nounderline" id="studInfo1" value="'+reqdata[i].Student_id+'">'+reqdata[i].Student_Name+'</a></td>'
			    			+'<td>'+reqdata[i].Reason+'</td>'
			                +'<td>'+reqdata[i].Date+' <br> '+reqdata[i].time_start+'-'+reqdata[i].time_end+'</td>'
			    			+'<td><button class="btn btn-primary" id="submit" value="'+reqdata[i].id+'">Accept</button> &nbsp'
			    				+'<button class="btn btn-primary" id="decline" value="'+reqdata[i].id+'">Decline</button>'
			    			+'</td>'
			    		+'</tr>';
				}
				$('#viewrequest').html(output);
			}
		});
	}
	function viewappointment(){
		var date = $('#datebutton').val(); 
		$.ajax({
			type:'ajax',
			url:'/Consultation/Account/viewAppointment',
			method:'post',
			data:{'date':date},
			success:function(data){
				var output='';
				var data = JSON.parse(data);
				for (var i = 0; i < data.length; i++) {
					output +='<tr>'
				                +'<td>'+(i+1)+'</td>'
				                +'<td><a href="" data-toggle="modal" data-target="#accountinfo" class="nounderline" id="studInfo" value="'+data[i].student_id+'">'+data[i].studentName+'</a></td>'   
				                +'<td>'+data[i].timeStart+'-'+data[i].timeEnd+'</td>'
				                +'<td><button class="btn btn-primary" id="postpone" value="'+data[i].Request_id+'">Postpone</button>' 
				                +'<td>'+data[i].Status+'</td>'
				            +'</tr>';				
				}
				$('#viewappointment').html(output);
			},
			error:function(data){
				console.log(data);	
			}
		});
	}
	function viewSched(){
		var date = $('#datebutton').val();
		$.ajax({
			type:'ajax',
			method:'post',
			url:'/Consultation/Account/viewSched',
			data:{'date':date},
			success:function(data){
				var data = JSON.parse(data);
				var count = 0;var html=''; 
				for (var i = 0; i < data.length; i++) {
					html +='<tr>'
				                +'<td>'+(i+1)+'</td>'
				                +'<td>'+data[i].Time_start+'-'+data[i].Time_end+'</td>'
				            +'</tr>';
				}
				$('#viewSched').html(html);
			},
			error:function(){
				console.log('No display');
			}
		});
	}
	function Edit(){
		$.ajax({
			type:'ajax',
			url:'/Consultation/Account/accountInfo',
			success:function(data){
				var data = JSON.parse(data);
				html = '<table>'
						+'<tr><th>Firtname</th><td><input type="text" name="firstname" value="'+data[0].Firstname+'"></td></tr>'
						+'<tr><th>Middlename</th><td><input type="text" name="middlename" value="'+data[0].Middlename+'"></td></tr>'
						+'<tr><th>Lastname</th><td><input type="text" name="lastname" value="'+data[0].Lastname+'"></td></tr>'
						+'<tr><th>Email</th><td><input type="text" name="email" value="'+data[0].Email+'"></td></tr>'
						+'</table>'
					;
				$('#Edit').find('form').html(html);
			},
			error:function(){
				console.log('No display');
			}
		});
	}
	$('#datebutton').change(function(){
		viewappointment();
		viewSched();
	});
	$('#prev').on('click',function(){
		var date = $('#datebutton').val();
		var prev = date.split("-")[0]+'-'+date.split("-")[1]+'-'+(parseInt(date.split("-")[2])-1);
		$('#datebutton').val(prev);
		viewappointment();
		viewSched();
	});
	$('#next').on('click',function(){
		var date = $('#datebutton').val();
		var prev = date.split("-")[0]+'-'+date.split("-")[1]+'-'+(parseInt(date.split("-")[2])+1);
		$('#datebutton').val(prev);
		viewappointment();
		viewSched();
	});
	$('#viewappointment').on('click','#postpone',function(){
		var id = $(this).attr('value');
		$.ajax({
			url:'/Consultation/Account/decline_or_postpone',
			method:'post',
			data:{'id':id,'status':2},
			success:function(data){
				viewappointment();
			},
			error:function(data){
				console.log(data);
			}
		});
	});
	$('#viewrequest').on('click','#decline',function(){
		var id = $(this).attr('value');
		$.ajax({
			url:'/Consultation/Account/decline_or_postpone',
			method:'post',
			data:{'id':id,'status':3},
			success:function(data){
				viewrequest();
			},
			error:function(data){
				console.log(data);
			}
		});
	});
	$('#viewrequest').on('click','#submit',function(){
		var id = $(this).attr('value');
		$.ajax({
			url:'/Consultation/Account/submitRequest',
			method:'post',
			data:{'id':id},
			success:function(data){
				viewrequest();
				console.log(data);
			},
			error:function(data){
				alert(data);
			}
		});
	});
	$('#viewrequest').on('click','#studInfo1',function(){
		$('#accountinfo').find('.modal-title').html("Student Info");
		$('#accountinfo').find('.modal-footer').find('#Edit').remove();
		var stud_id = $(this).attr('value');
		$.ajax({
			type:'ajax',
			url:'/Consultation/Account/studentInfo',
			method:'post',
			data:{'id':stud_id},
			success:function(data){
				var data = JSON.parse(data);
				html = '<table>'
						+'<tr><th>Firtname</th><td>: '+data[0].Firstname+'</td></tr>'
						+'<tr><th>Middlename</th><td>: '+data[0].Middlename+'</td></tr>'
						+'<tr><th>Lastname</th><td>: '+data[0].Lastname+'</td></tr>'
						+'<tr><th>Date of Birth</th><td>: '+data[0].DoB+'</td></tr>'
						+'<tr><th>Gender</th><td>: '+data[0].Gender+'</td></tr>'
						+'<tr><th>Email</th><td>: '+data[0].Email+'</td></tr>'
						+'<tr><th>PhoneNumber</th><td>: '+data[0].PhoneNumber+'</td></tr>'
						+'<tr><th>Collage</th><td>: '+data[0].Collagename+'</td></tr>'
						+'<tr><th>Department</th><td>: '+data[0].Department+'</td></tr>'
						+'</table>'
				;
				$('#accountInfo').html(html); 			
			},
			error:function(){
				console.log(stud_id);
			}
		});
	});
	$('#viewappointment').on('click','#studInfo',function(){
		$('#accountinfo').find('.modal-title').html("Student Info");
		$('#accountinfo').find('.modal-footer').find('#Edit').remove();
		var stud_id = $(this).attr('value');
		$.ajax({
			type:'ajax',
			url:'/Consultation/Account/studentInfo',
			method:'post',
			data:{'id':stud_id},
			success:function(data){
				var data = JSON.parse(data);
				html = '<table>'
						+'<tr><th>Firtname</th><td>: '+data[0].Firstname+'</td></tr>'
						+'<tr><th>Middlename</th><td>: '+data[0].Middlename+'</td></tr>'
						+'<tr><th>Lastname</th><td>: '+data[0].Lastname+'</td></tr>'
						+'<tr><th>Date of Birth</th><td>: '+data[0].DoB+'</td></tr>'
						+'<tr><th>Gender</th><td>: '+data[0].Gender+'</td></tr>'
						+'<tr><th>Email</th><td>: '+data[0].Email+'</td></tr>'
						+'<tr><th>PhoneNumber</th><td>: '+data[0].PhoneNumber+'</td></tr>'
						+'<tr><th>Collage</th><td>: '+data[0].Collagename+'</td></tr>'
						+'<tr><th>Department</th><td>: '+data[0].Department+'</td></tr>'
						+'</table>'
				;
				$('#accountInfo').html(html); 			
			}
		});
	});
	$('#yourInfo').on('click',function(){
		var button = '<button data-dismiss="modal" data-target="#edit" data-toggle="modal" class="btn btn-success" type="button">Edit</button>'
					+'<button class="btn btn-primary" type="button" data-dismiss="modal">Ok</button>';
		$('#accountinfo').find('.modal-title').html("Account Info");
		$('#accountinfo').find('.modal-footer').html(button);
		$.ajax({
			type:'ajax',
			url:'/Consultation/Account/accountInfo',
			success:function(data){
				var data = JSON.parse(data);
				html = '<table>'
						+'<tr><th>Firtname</th><td>: '+data[0].Firstname+'</td></tr>'
						+'<tr><th>Middlename</th><td>: '+data[0].Middlename+'</td></tr>'
						+'<tr><th>Lastname</th><td>: '+data[0].Lastname+'</td></tr>'
						+'<tr><th>Gender</th><td>: '+data[0].Gender+'</td></tr>'
						+'<tr><th>Email</th><td>: '+data[0].Email+'</td></tr>'
						+'<tr><th>Collage</th><td>: '+data[0].Collagename+'</td></tr>'
						+'<tr><th>Department</th><td>: '+data[0].Department+'</td></tr>'
						+'</table>'
				;
				$('#accountInfo').html(html); 			
			}
		});
	});
});


