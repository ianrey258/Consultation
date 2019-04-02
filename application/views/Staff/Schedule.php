<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">
			<h3>My Schedule</h3>
		</div>
		<div class="col-sm-6 text-right">
			<button class="btn btn-primary" data-toggle="modal" data-target="#createSched"><i class="fas fa-plus-circle"></i> <span>Create Schedule</span></button>
		</div>
	</div>
	<div class="h1">
        <div class="btn-group">
            <button class="btn bg-dark text-white" id="prev"><i class="fas fa-angle-double-left"></i></button>
            <input type="submit" class="btn bg-dark text-white" value="<?php echo(date("Y-m-d"))?>" id="datebutton"></input>
            <button class="btn bg-dark text-white" id="next"><i class="fas fa-angle-double-right"></i></button>
        </div>
    </div>
    <table class="table table-striped table-dark text-center">
        <thead>
            <tr>
                <th>No.</th>
                <th>Vacant Time</th>    
            </tr>
        </thead>
        <tbody id="viewSched">
        </tbody>
    </table>
</div>