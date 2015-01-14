
<style type="text/css">
    #statesTable{
        text-transform: ;
    }

</style>

   <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">States</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

<div class="container">
  <div class="row center-block">
      <div class="col-md-3" ></div>
    <div class="col-md-6" >
       <table id="statesTable" class="table table-list-search table-striped custab">
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php $i=1; foreach($this->states as $states){ ?>
                        <?php extract($states) ?>
                        <tr>
                            <td><?php echo $name ?></td>
                            <td><a data-name="<?php echo $name ?>" class="btn btn-danger remove btn-xs">
                                    <span class="glyphicon glyphicon-remove"></span> Del</a></td>
                        </tr>
                    <?php $i++; } ?>

                    </tbody>
                </table>   
                 <form id="addStateForm">
                <div class="input-group">
                    <input class="form-control" name="q" placeholder="new state" required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-plus-sign"></i></button>
                    </span>
                </div>
            </form>
    </div>
  </div>
</div>
<!--
<script type="text/javascript" src="public/js/datatables.min.js"></script>
<script type="text/javascript" src="public/js/datatables-bootstrap.js"></script>-->

<script type="text/javascript">
    $(document).ready(function() {

    var table = $('#statesTable') ;

    //table.DataTable();

    var oTable = table.DataTable({});

    /* Remove a state */
    $('body').on('click', 'a.remove' , function(e){
            e.preventDefault();
        var $this = $(this);
        var name = $(this).attr('data-name') ;
        $.post( URL + '/states/remove/' + name, function(obj){
            if( obj.status == true ){
              oTable.row( $this.parents('tr') )
                    .remove()
                    .draw();
            }else{
                alert(obj.result);
            }
        });
    });


    /* Add a new state */
    $("#addStateForm").on('submit', function(e){
        e.preventDefault();
        var textbox = $(this).find('input');
        var state = $.trim(textbox.val());
        $.post( URL + '/states/add/' + state , function(obj){
            if( obj.status == true ){
                textbox.val("");
                var HTML =  "<a data-name='"+ state +"' class='btn btn-danger remove btn-xs'>" ;
                    HTML += "<span class='glyphicon glyphicon-remove'></span> Del</a>" ;
                oTable.row.add([ state , HTML ]).draw();
            }else{
                alert(obj.result);
            }

        });
    });


});
    
</script>

   

