<html>  
        <head>  
            <title>STARTUP CHECK SYSTEM</title>  
            <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="framework/css/scrolling-nav.css" rel="stylesheet">
            <script src="framework/js/a076d05399.js"></script>
            <link rel="stylesheet" href="framework/css/jquery-ui.css">
            <script src="framework/js/jquery-1.12.4.js"></script>
            <script src="framework/js/jquery-ui.js"></script>
            <style>
                .table-bordered td, .table-bordered th {
                    border: 1px solid #ffffff;
                }
            </style>
        </head>  
        <body>  
            <section id="main">
                <div class="container">
                        <div class="row text-center">
                            <div class="col-lg-12 mx-auto">
                                <h1><b>STARTUP CHECK SYSTEM</b></h1>
                                <p class="lead">Create new dropdown with your condition.</p><br><br>
                            </div>
                        </div>
                        <div class="form-group">  
                            <form name="add_name" id="add_name">  
                                <div class="table-responsive text-center">  
                                    <table class="table table-hover table-striped table-bordered thead-light" id="dynamic_field">  
                                            <tr>
                                                <th>
                                                    <input id="DROPDOWN_NAME"  name="DROPDOWN_NAME"  type="text" class="form-control name_list" placeholder="DROPDOWN_NAME" oninput="this.value = this.value.toUpperCase()">
                                                </th>
                                            </tr>
                                            <tr>  
                                                <td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>  
                                                <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                                            </tr>  
                                    </table>  
                                    <input type="button" name="submit" id="submit" class="btn btn-dark" value="CREATE" />  
                                </div>  
                            </form>  
                        </div>  
                </div>
            </section>
        </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"dropdown_send.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
   