 

<style type="text/css">
#polParties img{
    width: 50px;
    height: 50px;
}

#polParties td{
    vertical-align: 100%;
}

#polParties tbody tr td:nth-child(4){
  text-align: center;
}

#polParties tbody tr td:nth-child(2){
    text-transform: capitalize;
}

#polParties tbody tr td:nth-child(3){
    text-transform: uppercase;
}

input[type=text][disabled] ,
select[disabled] {
  background-color: transparent !important;
  border:none;
  box-shadow: none !important;
  -moz-box-shadow: none !important;
  -webkit-box-shadow:none !important;
  -webkit-appearance:none !important;
  -moz-appearance:none !important;
}
</style>

   <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Political Parties</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

<div class="container">
  <div class="row">
      
    <div class="col-md-8" >
       <table id="polParties" class="table table-list-search table-striped custab">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Acronym</th>
                            <th>Fullname</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->parties as $party){ ?>
                    <?php extract($party) ?>
                        <tr>
                            <td> <img src="<?php echo URL . '/public/uploads/' . $logo ?>" /> </td>
                            <td><?php echo $fullname ?></td>
                            <td><?php echo $acronym ?></td>
                            <td>
                            <a data-party="<?php echo $logo ?>" class="remove btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a>
                          </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>   
                
    </div>

    <div class="col-md-4" >
       <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-bookmark"></span> New Political Party</h3>
                </div>
                <div class="panel-body">

                  <form id="form" method="post" enctype="multipart/form-data" role="form">
  <fieldset>
    <div class="form-group">
      <label for="partyName">Party Fullname</label>
      <input type="text" name="fullname" data-alert="enter party fullname" class="req form-control" placeholder="Fullname of political party">
    </div>
    <div class="form-group form-inline">
      <label for="lgaAcr">Party Acronym</label><br>
      <input type="text" name="acronym" data-alert="enter party acronym" class="req form-control" placeholder="Party Acronym">
    </div>
    <div class="form-group">
    <label for="exampleInputFile">Party Logo</label>
    <input type="file" accept="image/*" class="req" name="logo" data-alert="choose a party logo" />
  </div>
    <button type="submit" class="btn btn-block btn-primary">Add Party</button>
  </fieldset>
</form>                    
                    
                </div>
            </div>
    </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var Table = $('#polParties').DataTable();

    var options = {
        beforeSubmit:  showRequest,
        success:       showResponse,
        dataType:  'json',
        type:      'post',
        clearForm: true,
        url: URL + '/party/add'
    };

    // bind form using 'ajaxForm'
    $('#form').ajaxForm(options);


    // pre-submit callback
    function showRequest(formData, jqForm, options) {
        var $this = $('#form') ;
        var ret = true ;

        $this.find('.req').each(function(){
            if( $.trim($(this).val().length) < 1 ){
                alert( $(this).attr('data-alert') );
                $(this).focus();
                ret = true ;
                exit();
            }
        });
        return ret;
    }

    // post-submit callback
    function showResponse(jsonData)  {
        if(jsonData.status == false){
            alert(jsonData.result);
        }else{
            addNewrow(jsonData);
        }
    }


    /* Add new row to table */
    function addNewrow(OBJ){
        $('#form').find('.req').val("") ;
        var HTML =  "<a data-name='"+ OBJ.logo +"' class='btn btn-danger remove btn-xs'>" ;
        HTML += "<span class='glyphicon glyphicon-remove'></span> Del</a>" ;
        var logo = '<img src="'+ URL + '/public/uploads/' + OBJ.logo +'" alt="" />' ;
        Table.row.add([logo,OBJ.fullname,OBJ.acronym,HTML]).draw();
    }


    /* Remove a party */
    $('body').on('click', 'a.remove' , function(e){
        e.preventDefault();
        var $this = $(this);
        var party = $(this).attr('data-party') ;
        $.post( URL + '/party/remove/' + party, function(obj){
            if( obj.status == true ){
                Table.row( $this.parents('tr') )
                    .remove()
                    .draw();
            }else{
                alert(obj.result);
            }
        });
    });


});



</script>

   

