<style type="text/css">
#aspirantsTable tbody tr td{
  text-transform: capitalize;
}

#aspirantsTable tbody tr td:nth-child(5){
  text-align: center;
}
</style>

 <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Welcome <strong><?php echo $_SESSION['LoggedIn']['username']  ?></strong></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <br>

    <div class="container">
    <div class="row">

<!-- Links Here -->
<div class="col-md-9">

<br>

                     <table id="aspirantsTable" class="table table-list-search table-striped custab">
                      <legend class="text-primary">Aspirants </legend>
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Fullname</th>
                            <th>Party</th>
                            <th>Office</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($this->aspirants)){ ?>
                    <?php foreach($this->aspirants as $person){ ?>
                        <tr>
                            <td><?php echo $person['aid'] ?></td>
                            <td><?php echo $person['fullname'] ?></td>
                            <td><?php echo $person['party']['acronym'] ?></td>
                            <td><?php echo $person['type'] ?></td>
                            <td>
                              <a href="<?php echo URL.'/pages/view_aspirant/'.$person['aid'] ?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-eye-open"></span> View</a>
                             <a data-aid="<?php echo $person['aid'] ?>" class="btn remove btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a>
                          </td>
                        </tr>
                    <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>   
        </div>


        <div class="col-md-3">

          <ul class="list-group">
                <li class="list-group-item"><a href="Javascript:void();" class="list-group-item active"><span class="glyphicon glyphicon-signal"></span> Data Statistics </a></li>
                <li class="list-group-item"><span class="badge btn-danger">14</span>Political Parties</li>                      <li class="list-group-item"><span class="badge btn-success">14</span>Presidential Aspirants</li>
                <li class="list-group-item"><span class="badge btn-primary">14</span>Gubernatorial Aspirants</li>
                <li class="list-group-item"><span class="badge btn-warning">14</span>States</li>
          </ul>
       <a href="http://www.jquery2dotnet.com/" class="btn btn-success btn-lg btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
        </div>

    </div>

</div> 

<script type="text/javascript">
$(document).ready(function() {

    var table = $('#aspirantsTable') ;

    var oTable = table.DataTable({});

            /* Remove a state */
            $('body').on('click', 'a.remove' , function(e){
                e.preventDefault();
                var $this = $(this);
                var aid = $(this).attr('data-aid') ;
                $.post( URL + '/aspirant/remove/' + aid, function(obj){
                    if( obj.status == true ){
                        oTable.row( $this.parents('tr') )
                            .remove()
                            .draw();
                    }else{
                        alert(obj.result);
                    }
                });
            });
});
    
</script>


