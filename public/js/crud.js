jQuery(document).ready(function($){
    ////----- Open the modal to CREATE a User -----////
    jQuery('#btn-add').click(function () {
        jQuery('#btn-save').val("add");
        jQuery('#modalFormData').trigger("reset");
        jQuery('#userEditorModal').modal('show');
    });
 
    ////----- Open the modal to UPDATE a User -----////
    jQuery('body').on('click', '.open-modal', function () {
        var user_id = $(this).val();
        $.get('users/' + user_id, function (data) {
            jQuery('#user_id').val(data.id);
            jQuery('#name').val(data.name);
            jQuery('#email').val(data.email);
            jQuery('#phone').val(data.phone);
            jQuery('#city').val(data.city);
            jQuery('#btn-save').val("update");
            jQuery('#userEditorModal').modal('show');
        })
    });
 
    // Clicking the save button on the open modal for both CREATE and UPDATE
    jQuery("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            name: jQuery('#name').val(),
            email: jQuery('#email').val(),
            phone: jQuery('#phone').val(),
            city: jQuery('#city').val(),
        };
        var state = jQuery('#btn-save').val();
        var type = "POST";
        var user_id = jQuery('#user_id').val();
        var ajaxurl = 'users';
        if (state == "update") {
            type = "PUT";
            ajaxurl = 'users/' + user_id;
        }
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
            	
            	if(data.errors)
              	{
              		jQuery('.alert-danger').html('');

              		jQuery.each(data.errors, function(key, value){
              			jQuery('.alert-danger').show();
              			jQuery('.alert-danger').append('<li>'+value+'</li>');
              		});
              	}
              	else
              	{
              		jQuery('.alert-danger').hide();
              		
              		var user = '<tr id="user' + data.id + '"><td>' + data.id + '</td><td>' + data.name+ '</td><td>' + data.email + '</td><td>' + data.phone + '</td><td>' + data.city + '</td>';
                    user += '<td><button class="btn btn-info open-modal" value="' + data.id + '">Edit</button>&nbsp;';
                    user += '<button class="btn btn-danger delete-link" value="' + data.id + '">Delete</button></td></tr>';
                    if (state == "add") {
                        jQuery('#users-list').append(user);
                    } else {
                        $("#user" + data.id).replaceWith(user);
                    }
                    jQuery('#modalFormData').trigger("reset");
                    jQuery('#userEditorModal').modal('hide');
              	}
                
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
 
    ////----- DELETE a User and remove from the page -----////
    jQuery('.delete-link').click(function () {
    	var user_id = $(this).val();
    	console.log(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "DELETE",
            url: 'users/' + user_id,
            beforeSend:function(){
                return confirm("Are you sure?");
             },
            success: function (data) {
                console.log(data);
                $("#user" + user_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    $(".btn-close").click(function (){
    	jQuery('.alert-danger').hide();
    });
});