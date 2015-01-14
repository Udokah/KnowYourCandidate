<style type="text/css">
.user-row {
    margin-bottom: 14px;
}

.user-row:last-child {
    margin-bottom: 0;
}

.dropdown-user {
    margin: 13px 0;
    padding: 5px;
    height: 100%;
}

.dropdown-user:hover {
    cursor: pointer;
}

.table-user-information > tbody > tr {
    border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}


.table-user-information > tbody > tr > td {
    border-top: 0;
}
.toppad
{margin-top:20px;
}

#profileTable tbody tr td:first-child{
  min-width: 200px;
}
    .img-circle{
        max-width: 200px;
        max-height: 200px;
    }

</style>

<div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xs-offset-0 col-sm-offset-0 col-lg-offset-2 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
                <?php $aspirant = new ArrToObj($this->aspirant) ?>
              <h3 class="panel-title"><?php echo $aspirant->fullname ?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center">
                    <img alt="User Pic" src="<?php echo URL.'/public/uploads/aspirants/'.$aspirant->picture  ?>" class="img-circle">
                </div>
                
                <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                  <dl>
                    <dt>DEPARTMENT:</dt>
                    <dd>Administrator</dd>
                    <dt>HIRE DATE</dt>
                    <dd>11/12/2013</dd>
                    <dt>DATE OF BIRTH</dt>
                       <dd>11/12/2013</dd>
                    <dt>GENDER</dt>
                    <dd>Male</dd>
                  </dl>
                </div>-->
                <div class=" col-md-9 col-lg-9 "> 
                  <table id="profileTable" class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>State Of Origin:</td>
                        <td><?php echo $aspirant->state ?></td>
                      </tr>
                      <tr>
                        <td>Date of Birth</td>
                        <td><?php echo date("d, F Y",strtotime($aspirant->birthday)) ?></td>
                      </tr>
                   
                         <tr>
                      <tr><td colspan="2" align="center"><strong>About</strong></td></tr>
                        <tr>
                        <td>Education</td>
                        <td><?php echo $aspirant->education ?></td>
                      </tr>
                      </tr>
                      <td>Profile</td>
                      <td><?php echo $aspirant->profile ?></td>
                      </tr>

                      <tr><td colspan="2" align="center"><strong>Political</strong></td></tr>
                       <tr>
                        <td>Political Party</td>
                        <td><?php echo $aspirant->party->fullname . ' - <strong>' . strtoupper($aspirant->party->acronym) . '</strong>' ?></td>

                       </tr>
                        <td>Achievments</td>
                        <td><?php echo $aspirant->achievments ?></td>
                      </tr>
                      </tr>
                      <td>Aspiration</td>
                      <td><?php echo $aspirant->type ?></td>
                      </tr>


                    </tbody>
                  </table>
                
                </div>
              </div>
            </div>
                 <!--<div class="panel-footer">
                        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-check"></i> 20 votes</a>
                        <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                        </span>
                    </div>-->
            
          </div>
        </div>
      </div>
    </div>