function GetRapidXUser(cboElement){
	let result = '<option value="0" disabled selected>Select One</option>';
	$.ajax({
		url: 'get_rapidx_users',
		method: 'get',
		dataType: 'json',
		beforeSend: function(){
			result = '<option value="0" disabled>Loading</option>';
			cboElement.html(result);
		},
		success: function(response){
			let disabled = '';
			if(response['users'].length > 0){
				result = '<option value="0" disabled selected>Select One</option>';
				for(let index = 0; index < response['users'].length; index++){
                    result += '<option department="' + response['users'][index]['department'].department_name + '" recipient_name="' + response['users'][index].name + '" email="' + response['users'][index].email + '" value="' + response['users'][index].id + '">' + response['users'][index].name + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled>No record found</option>';
			}
			cboElement.html(result);
		},
		error: function(data, xhr, status){
			result = '<option value="0" disabled>Reload Again</option>';
			cboElement.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
	});
}

function GetSection(cboElement){
	let result = '<option value="0" disabled selected>Select One</option>';
	$.ajax({
		url: 'get_section',
		method: 'get',
		dataType: 'json',
		beforeSend: function(){
			result = '<option value="0" disabled>Loading</option>';
			cboElement.html(result);
		},
		success: function(response){
			let disabled = '';
			if(response['sections'].length > 0){
				result = '<option value="0" disabled selected>Select One</option>';
				for(let index = 0; index < response['sections'].length; index++){
                    result += '<option value="' + response['sections'][index].department_name + '">' + response['sections'][index].department_name + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled>No record found</option>';
			}
			cboElement.html(result);
		},
		error: function(data, xhr, status){
			result = '<option value="0" disabled>Reload Again</option>';
			cboElement.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
	});
}