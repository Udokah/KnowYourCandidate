
<div class="container">
    <div class="row vertical-offset-100">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Please sign in</h3>
        </div>
        <alert class="bg-danger" >sdfssdfsdf</alert>
          <div class="panel-body">

            <form id="loginForm" accept-charset="UTF-8" role="form">
                    <fieldset>
                <div class="form-group">
                  <input class="form-control req"  data-alert="enter username" placeholder="Username" name="username" type="text">
              </div>
              <div class="form-group">
                <input class="form-control req"  data-alert="enter password" placeholder="Password" name="password" type="password" value="">
                <input type="hidden" id="action" name="action" value="" />
              </div>
             <button type="submit" class="btn btn-success btn-block b" ><i class="glyphicon glyphicon-log-in"></i> Login</button>
            </fieldset>
              </form>
          </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $('#action').val("login") ;

  $('#loginForm').on('submit', function(event) {
    event.preventDefault();
    /* Act on the event */
    var form = $(this) ;

    form.find('.req').each(function(){
      var str = $.trim( $(this).val() ) ;
      var msg = $(this).attr('data-alert');
      if ( str.length < 2 ) {
              doAlert(msg) ;
              $(this).focus() ;
              exit();
      }
    }); // End of empty fields Checking

        $.ajax({
        url: URL + "/service/login" ,
        data: $(this).serialize() ,
        dataType: "json" ,
        beforeSend: function () {          
        form.find('.btn').attr('disabled', 'disabled');
        } ,
        success: function(returnedData){
          if(returnedData.status == false){
            doAlert("invalid username or password") ;
          }else{
            window.location = URL + "/pages/dashboard" ;
          }
        },
        error: function ( jqXHR, exception ) {
          doAlert( Ajax_Error(jqXHR)  ) ;
        },
        complete: function(){
        form.find('.btn').removeAttr('disabled');
        }
        });
  

  }); // Form submit

});
</script>