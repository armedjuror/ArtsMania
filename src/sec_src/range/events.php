<?php
include 'head.php';
$query = "SELECT participant_id FROM arts_participants WHERE participant_range='$session_id'";
if ($fetched = mysqli_query($connection, $query)){
    $array = array();
    while($id = mysqli_fetch_array($fetched)){
        array_push($array, $id['participant_id']);
    }
    $result = json_encode($array);
    echo '<script>let participants = '.$result.'</script>';

}
?>
    <section>
        <div class="card p-2" style="width: 100%; background-color: #333333;">
            <div class="card-body">
                <h3 class="text-white">EVENTS : </h3>
                <div class="row m-5">
                    <div class="col-md-4">
                        <select name="category" id="category" class="form-control">
                            <option value="">---SELECT YOUR CATEGORY---</option>
                            <option value="SUB JUNIOR">SUB JUNIOR</option>
                            <option value="JUNIOR">JUNIOR</option>
                            <option value="SENIOR">SENIOR</option>
                            <option value="SUPER SENIOR">SUPER SENIOR</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="gender" id="gender" class="form-control" onchange="load_events()">
                            <option value="">---SELECT THE GENDER---</option>
                            <option value="B">Boys</option>
                            <option value="G">Girls</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="event" id="event" class="form-control" onchange="load_participation_entries()">
                            <option value="">---SELECT THE EVENT---</option>
                        </select>
                    </div>
                </div>
                <div class="row text-white text-center" id="error-msg">

                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row" style="display: none;" id="add_entry_button">
                <div class="col-md-12 text-right">
                    <input type="number" name="participants_count" id="participants_count" min="0" required value="0" hidden>
                    <button class="btn btn-primary" onclick="add_participation_entry_form()">ADD A ENTRY&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div id="empty-box"><h1 class="h1 text-center">SELECT AN EVENT</h1></div>
            <div id="participants-box" style="min-height:500px;">
            </div>
        </div>
    </section>
<?php
include 'foot.php';
