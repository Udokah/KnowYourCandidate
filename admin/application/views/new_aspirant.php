
<style type="text/css">
    select{
        text-transform: uppercase;
    }
/* Credit to bootsnipp.com for the css for the color graph */
.colorgraph {
  height: 5px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}

    .img-circle{
        width: 200px;
        max-height: 200px;
    }
</style>

<div class="container">

<div class="row">

	<!-- Profile picture-->
	 <div class="col-md-4 col-lg-3 " align="center"> 
	 	<br><br>
	 	<h2></h2>
	 	<img alt="User Pic" data-isset="false" src="<?php echo URL ?>/public/img/photo.png" class="img-circle">
	 	<br><br>
	 	<div class="form-group">
            <form class="uploadForm">
	 		<input type="file" name="picture" accept="image/*" id="picture">
            </form>
        </div>
	 </div>
                

    <div class="col-md-6">
		<form role="form" class="mainForm">
			<h2>Create Aspirant Profile</h2>
			<hr class="colorgraph">
			<legend>Biodata</legend>
			<div class="form-group">
                <input type="hidden" class="req" data-alert="choose an aspirant profile picture" name="picture" id="profilePicture" />
	             <input type="text" name="fullname" id="fullname" class="form-control req input-lg" placeholder="Full Name" tabindex="1">
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
		<input type="text" name="birthday"  id="datepicker" class="form-control req input-lg" placeholder="Birthday" tabindex="2">
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
                        <label for="state"></label><select id="state" name="state" tabindex="3"  class="form-control req input-lg">
                             <?php foreach($this->states as $state){ ?>
                                 <option value="<?php echo $state['sid'] ?>"><?php echo $state['name'] ?></option>
                             <?php } ?>
     						 </select>
		
					</div>
				</div>

			</div>
			
			<div class="form-group">
				 <span class="help-block text-primary">A brief profile of the political aspirant</span>
	             <textarea class="form-control req" name="profile" placeholder="" rows="3"></textarea>
	            
			</div>

			<legend>Education</legend>
			<div class="form-group">
                <textarea class="form-control req" name="education" placeholder="" rows="3"></textarea>
			</div>

			<legend>Political Party</legend>

            <div class="form-group">
                <div class="form-group">
                    <label for="party"></label>
                    <select id="party" name="party" tabindex="8"  class="form-control req input-lg">
                        <?php foreach($this->parties as $party){ ?>
                        <option value="<?php echo $party['pid'] ?>"><?php echo $party['acronym'] . ' - ' . $party['fullname'] ?></option>
                        <?php } ?>
                    </select>

                </div>
            </div>

            <legend>Type</legend>
            <div class="form-group">
                <div class="form-group">
                    <select id="party" name="type" tabindex="8"  class="form-control req input-lg">
                        <option>presidential</option>
                        <option>gubernatorial</option>
                    </select>

                </div>
            </div>

			<div class="form-group">
				 <span class="help-block text-primary">Brief political achievments</span>
	             <textarea class="form-control req" name="achievments" rows="3"></textarea>
			</div>

			<hr class="colorgraph">
			<div class="row">
			   <input type="submit" value="Create Profile" class="btn btn-primary btn-block btn-lg" tabindex="7">
			</div>
		</form>
	</div>
</div>
</div>


<script>
    $(document).ready(function(){
        var options = {
            success:       showResponse,  // post-submit callback
            url:       URL + '/aspirant/picture' ,
            type:      'post',
            dataType:  'json',
            clearForm: true
        };

        $('#picture').on('change', function(e){
            e.preventDefault();
            $(".uploadForm").ajaxSubmit(options);
        });

        /* main form submition */
        $(".mainForm").on('submit', function(e){
            e.preventDefault();
            var $this = $(this) ;

            $.post( URL + '/aspirant/create' , $this.serialize() , function(data){
                if(data.status == true){
                    $(".req").val("");
                    $(".img-circle").attr( 'src', URL + '/public/img/photo.png' );
                }else{
                    alert(data.result);
                }
            });


        });

    });

    // post-submit callback
    function showResponse(responseObj, statusText, xhr, $form)  {
        if(responseObj.status == true){
            var image = URL + "/public/uploads/aspirants/" + responseObj.result ;
            $(".img-circle").attr('src' , image);
            $("#profilePicture").val(responseObj.result)
        }else{
            alert(responseObj.result);
        }
    }

    $(function() {
        $("#datepicker").datepicker({dateFormat : 'yy-mm-dd'});
    });
</script>