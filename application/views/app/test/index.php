<!DOCTYPE html>
<html>
    <head>
<head>

        <meta charset="UTF-8">
        <title>Hospital Management System</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link href="<?php echo base_url()?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    </head>
</div>
    <body class="skin-blue">
    <!-- jquery core -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<!-- for bootstrap --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
	<!-- for Autocomplete --> 
    <script src="<?php echo base_url();?>public/js/bloodhound.min.js"></script>
    <script src="<?php echo base_url();?>public/js/typeahead.jquery.min.js"></script>
    <!-- jqueryui -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script language="javascript">
    $(document).ready(function() {
        // Single Select
        $("#tboxitemname").autocomplete({
            minLength:1,
            source: function( request, response ) {
        // Fetch data
            $.ajax({
                url: "<?php echo base_url();?>app/billing/itemsearch/" + request.term,
                type: 'get',
                dataType: "json",
                success: function( data ) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            // Set selection
            $('#tboxitemname').val(ui.item.label); // display the selected text
            //alert(ui.item.value); // save selected id to input
            return false;
        },
        focus: function(event, ui){
            $( "#tboxitemname" ).val( ui.item.label );
            //$( "#selectuser_id" ).val( ui.item.value );
            return false;
        },
        });

        $( "#tboxcategory" ).autocomplete({
                minLength:1,
                source: function( request, response ) {
            // Fetch data
            $.ajax({
                url: "http://localhost/one/x%20item%20tagging.php",
                type: 'post',
                dataType: "json",
                data: {
                categories: request.term
                },
                success: function( data ) {
                response( data );
                }
            });
            },
            select: function (event, ui) {
                // Set selection
                $('#tboxcategory').val(ui.item.label); // display the selected text
                //alert(ui.item.value); // save selected id to input
                return false;
            },
            focus: function(event, ui){
                $( "#tboxcategory" ).val( ui.item.label );
                //$( "#selectuser_id" ).val( ui.item.value );
                return false;
            },
            });




    });
</script>

<div class="form-group col-md-9">
										<label>Itemname</label>
										<input type="text" name="tboxitemname" id="tboxitemname" class="form-control">
									</div>
                                    <div class="form-group col-md-3">
										<label>Category</label>
										<input type="text" name="tboxcategory" id="tboxcategory" class="form-control">
									</div>
    </body>
</html>