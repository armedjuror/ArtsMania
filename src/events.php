<?php
include 'head.php';
?>
    <section>
        <div class="card p-2" style="width: 100%; background-color: #333333;">
            <div class="card-body">
                <h3 class="text-white">EVENTS : </h3>
                <div class="row m-5">
                    <div class="col-md-4">
                        <select name="category" id="category" class="form-control">
                            <option value="">---SELECT YOUR CATEGORY---</option>
                            <option value="KD">KIDDIES</option>
                            <option value="SJ">SUB JUNIOR</option>
                            <option value="JN">JUNIOR</option>
                            <option value="SN">SENIOR</option>
                            <option value="SS">SUPER SENIOR</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="gender" id="gender" class="form-control">
                            <option value="">---SELECT THE GENDER---</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="event" id="event" class="form-control">
                            <option value="">---SELECT THE EVENT---</option>
                        </select>
                    </div>
                </div>
                <div class="row text-white text-center" id="error-msg">

                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </section>
<?php
include 'foot.php';
