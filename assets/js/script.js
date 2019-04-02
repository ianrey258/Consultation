function facultybtn() {
	document.getElementById('register-right').style.right="0px";
	document.getElementById('selection').style.top="25px";
	document.getElementById('head').innerHTML='Staff Registration';
	document.getElementById('erroralert').style.display='none';
}
function studentbtn() {
	document.getElementById('register-left').style.left="0px";
	document.getElementById('selection').style.top="25px";
	document.getElementById('head').innerHTML='Student Registration';
	document.getElementById('erroralert').style.display='none';}

function facultybtnback() {
	document.getElementById('register-right').style.right="-1500px";
	document.getElementById('selection').style.top="200px";
	document.getElementById('head').innerHTML='User Type';
}
function studentbtnback() {
	document.getElementById('register-left').style.left="-1500px";
	document.getElementById('selection').style.top="200px";
	document.getElementById('head').innerHTML='User Type';
}
function submit() {
	document.getElementById('conpass').removeAttribute('name');
}
$(document).ready(function(){
	var html ='<option value="0">----Select College First----</option>';
	var html1 ='<option value="0">----Select Staff----</option>';
	showcollege();
	showappointment();
	function showcollege(){
		$.ajax({
			type:'ajax',
			url:"/Consultation/Signup/loadCollege",
			async:false,
			success:function(data){
				 $('#college').html(data);
				 $('#college1').html(data);
				 $('#department').html(html);
				 $('#department1').html(html);
				  $('#StaffNames').html(html1);
				 //console.log(data);
			},
			error:function(){
				alert("no load college ");
			}
		});
	}
	function showtime(){
		var date = $('#reqdate').val();
		var id = $('#StaffNames').val();
		$.ajax({
			url:'/Consultation/Account/getTime',
			method:'post',
			data:{'date':date,'id':id},
			success:function(datas){
				var time = JSON.parse(datas);
				var output = '';
				if(time.length!=0){
					for (var i = 0; i < time.length; i++) {
						output +='<option value='+time[i].id+'>'+time[i].time_start+'-'+time[i].time_end+'</option>';
					}
					$('#reqtime').html(output);
				}
				else{
					output1 ='<option>This Schedule is Unavailable</option>';
					$('#reqtime').html(output1);	
				}
			},
			error:function(data){
				console.log(data);
			}
		});
	}
	function showappointment(){
		var date = $('#datebutton').val();
		$.ajax({
			url:'/Consultation/Account/studentAppointment',
			async:'false',
			method:'post',
			data:{'date':date},
			success:function(datas){
				var output ='';
				var data = JSON.parse(datas);
				for (var i = 0; i < data.length; i++) {
					output +='<tr>'
				                +'<td>'+(i+1)+'</td>'
				                +'<td><a href="#" class="nounderline">'+data[i].lastname+','+data[i].firstname+'</a></td>'    
				                +'<td>'+data[i].time_start+'-'+data[i].time_end+'</td>'  
				                +'<td>'+data[i].Status+'</td>'
				            +'</tr>'
				}
				$('#studAppointment').html(output);
			},
			error:function(data){
				console.log(data);
			}
		});
	}
	$('#college').change(function(){
		var colid = $('#college').val();
		if(colid!=0){
			$.ajax({
				url:'/Consultation/Signup/loadDepartment',
				method:'post',
				data:{'id':colid},
				success:function(data){
					$('#department').html(data);
					//console.log(data);
				},
				error:function(){
					alert("no load dept ");
				}
			});
		}
		else{
			$('#department').html(html);
		}
	});
	$('#college1').change(function(){
		var colid = $('#college1').val();
		if(colid!=0){
			$.ajax({
				url:'/Consultation/Signup/loadDepartment',
				method:'post',
				data:{'id':colid},
				success:function(data){
					$('#department1').html(data);
					//console.log(data);
				},
				error:function(){
					alert("no load dept ");
				}
			});
		}
		else{
			$('#department1').html(html);
		}
	});
	$('#department').change(function(){
		var depid = $('#department').val();
		if(depid!=0){
			$.ajax({
				url:'/Consultation/Account/loadNames',
				method:'post',
				data:{'id':depid},
				success:function(data){
					$('#StaffNames').html(data);
					//console.log(data);
				},
				error:function(){
					alert("no load staff ");
				}
			});
		}
		else{
			$('#department').html(html1);
		}
	});
	$('#StaffNames').change(function(){
		if($('#StaffNames').val()!=0){
			showtime();
			$('#reqbutton').removeAttr('disabled');
		}
		else{
			$('#reqbutton').attr('disabled',true);	
		}
	});
	$('#reqdate').change(function(){
		showtime();
	});
	$('#date').datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true
	});
	$('#reqdate').datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true
	});
	$('#datebutton').datepicker({
		dateFormat:"yy-mm-dd",
		changeMonth:true,
		changeYear:true
	});
	$('#datebutton').change(function(){
		showappointment();
	});
});