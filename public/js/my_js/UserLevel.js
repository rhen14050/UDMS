function GetUserLevel(cboElement){
    let result = '<option value="0" selected disabled> -- Select User Level -- </option>';
    $.ajax({
        url: 'get_user_levels',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';
            if(response['user_levels'].length > 0){ // true
                result = '<option value="0" selected disabled> Select User Level </option>';
                for(let index = 0; index < response['user_levels'].length; index++){
                    result += '<option value="' + response['user_levels'][index].id + '">' + response['user_levels'][index].name + '</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}