<?php
include 'head.php';
?>
<section>
    <div class="card p-2" style="width: 100%; background-color: #333333;">
        <div class="card-body">
            <div class="row m-5">
                <div class="col-md-6">
                    <h3 class="text-white">FINAL LIST : </h3>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-outline-light" onclick="window.print()">PRINT&nbsp;&nbsp;&nbsp;<i class="fa fa-print"></i></button>
                </div>
            </div>
            <div class="row text-white text-center" id="error-msg">

            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div id="final_list-box" style="min-height:700px;">
            <button type="button" class="btn btn-success btn-block mb-5" data-toggle="modal" data-target="#finalModal">
                FINAL SUBMIT
            </button>
            <div class="form-group">
                <input type="text" id="search_bar" onkeyup="search_event()" class="form-control" placeholder="Search for events...">
            </div>

            <table class="table table-hover table-responsive-lg" id="events-list">
                <thead>
                <tr>
                    <th scope="col">EVENT</th>
                    <th scope="col">PARTICIPANT</th>
                    <th scope="col">MADRASSA</th>
                    <th scope="col">CLASS</th>
                    <th scope="col">PHONE NUMBER</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT ae.event_name, ae.event_category, ae.event_gender, ap.participant_name, ap.participant_madrassa, ap.participant_madrassa_number, ap.participant_class, ap.participant_mobile  FROM range_event_participation rep
                            INNER JOIN arts_participants ap ON rep.candidate_id = ap.participant_id
                            INNER JOIN arts_events ae on rep.event_id = ae.event_id
                        WHERE rep.position=1 AND rep.range_id LIKE BINARY '$session_id';";
                if ($fetched = mysqli_query($connection, $query)){
                    if ($fetched->num_rows){
                        while ( $row = mysqli_fetch_array($fetched) ){
                            echo '
                            <tr>
                                <td>'.$row['event_name'].' - '.$row['event_category'].' - '.$row['event_gender'].'</td>
                                <td>'.$row['participant_name'].'</td>
                                <td>'.$row['participant_madrassa'].' - '.$row['participant_madrassa_number'].'</td>
                                <td>'.$row['participant_class'].'</td>
                                <td>'.$row['participant_mobile'].'</td>
                            </tr>
                            ';
                        }
                    }else{
                        echo '
                        <tr><td colspan="5"><h1 class="h1 text-center">NO ENTRIES YET!</h1></td></tr>
                        ';
                    }
                }
                ?>
                </tbody>
            </table>

            <div class="modal fade" id="finalModal" tabindex="-1" role="dialog" aria-labelledby="finalModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Are you sure?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            This is the final submission. Once done cannot be edited or undone. Are you sure to do it?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
                            <button type="button" class="btn btn-success" onclick="final_submit()">YES</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include 'foot.php';
