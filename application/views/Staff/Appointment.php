<div class="container-fluid">
    <h3>Appointment</h3>
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
                <th>Name</th>
                <th>Time</th>
                <th>Action</th>
                <th>Status</th>     
            </tr>
        </thead>
        <tbody id="viewappointment">
        </tbody>
    </table>
</div>