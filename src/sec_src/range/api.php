<?php
require '../../../configs/artsmania-config.php';
include './sessions.php';

if (isset($_POST['id'])){
    $id = $_POST['id'];
}else{
    header('location: logout.php');
}

//API TEST
if ($id == 0){
    echo json_encode(array('status_code'=>1, 'result'=>'Tested OK'));
}

//Load Events
if ($id == 1){
    $category = $_POST['category'];
    $gender = $_POST['gender'];
    $query = "SELECT event_id, event_name FROM arts_events WHERE event_category='$category' AND event_gender='$gender'";
    if ($fetched = mysqli_query($connection, $query)){
        $changes = '<option value="">---SELECT THE EVENT---</option>';
        while($event = mysqli_fetch_array($fetched)){
            $changes .= '<option value="'.$event['event_id'].'">'.$event['event_name'].'</option>';
        }
        echo json_encode(array('status_code'=>1, 'changes'=>$changes));
    }else{
        echo json_encode(array('status_code'=>0, 'error_msg'=>"Something went Wrong!", 'error_desc'=>$connection->error));
    }
}

//Add Participant
if ($id == 2){
    $mad_no = $_POST['participant-madrassa_num'];
    $id = create_id($connection, $mad_no);
    $name = $_POST['participant-name'];
    $mobile = $_POST['participant-mobile'];
    $dob = $_POST['participant-dob'];
    $class = $_POST['participant-class'];
    $madrassa = $_POST['participant-madrassa'];
    $adm_no = $_POST['participant-adm_no'];
    $checked_file = check_file($_FILES['participant-gravatar'], array('png', 'jpg', 'jpeg'), 500, "Image should be less than 500Kb");
    if ($checked_file['status_code']){
        $image = $checked_file['file'];
        $query = "INSERT INTO arts_participants
                (participant_id, participant_range, participant_name, participant_dob, participant_mobile, participant_madrassa, participant_madrassa_number, participant_class, participant_admission_number, participant_gravatar) VALUES
                ('$id', '$session_id', '$name',  '$dob', '$mobile', '$madrassa', '$mad_no', '$class', '$adm_no', '$image')";
        if ($inserted = mysqli_query($connection, $query)){
            echo json_encode(array('status_code'=>1, 'id_created'=>$id, 'changes'=>get_participants_table($connection, $session_id)));
        }else{
            echo json_encode(array('status_code'=>0, 'error_msg'=>$connection->error));
        }
    }

}

//Delete Participant
if ($id == 3){
    $participant_id = $_POST['p'];
    $query = "DELETE FROM arts_participants WHERE participant_id='$participant_id'";
    if ($deleted = mysqli_query($connection, $query)){
        echo json_encode(array('status_code'=>1));
    }else{
        echo json_encode(array('status_code'=>0, 'error_msg'=>'Oh no, Something went wrong!', 'error_desc'=>$connection->error));
    }
}

//Add Entries
if ($id == 4){
    $candidate_id = $_POST['candidate-id'];
    $candidate_points = $_POST['candidate-points'];
    $candidate_position = $_POST['candidate-position'];
    $candidate_remarks = $_POST['candidate-remarks'];
    $event = $_POST['event'];
    if ($_POST['entry-id']){
        $entry_id = $_POST['entry-id'];
    }else{
        $entry_id = uniqid('en_');
        $check = "SELECT entry_id FROM range_event_participation WHERE event_id='$event' AND candidate_id='$candidate_id'";
        if ($checked = mysqli_query($connection, $check)){
            if ($checked->num_rows){
                echo json_encode(array('status_code'=>0, 'error_msg'=>"A candidate can't be entered more than once for an event.", 'reset'=>1));
                exit();
            }
        }else{
            echo json_encode(array('status_code'=>0, 'error_msg'=>"Oh no, Something went wrong!", 'error_desc'=>$connection->error, 'reset'=>0));
            exit();
        }
    }
    $query = "INSERT INTO range_event_participation VALUES
    ('$entry_id', '$event', '$session_id', '$candidate_id', '$candidate_points', '$candidate_position', '$candidate_remarks')
    ON DUPLICATE KEY UPDATE 
                            candidate_id = VALUES(candidate_id),
                            points_scored=VALUES(points_scored),
                            position=VALUES(position),
                            remarks=VALUES(remarks)
                            
    ";
    if (mysqli_query($connection, $query)){
        echo json_encode(array('status_code'=>1, 'entry-id'=>$entry_id));
    }else{
        echo json_encode(array('status_code'=>0, 'error_msg'=>"Oh no, Something went wrong!", 'error_desc'=>$connection->error, 'reset'=>0));
    }
}

//Load Entries
if ($id == 5){
    $event = $_POST['e'];
    $changes = '';
    $participants_list = mysqli_query($connection, "SELECT participant_id as id FROM arts_participants WHERE participant_range='$session_id'");
    $options = '';
    while ($participant = mysqli_fetch_array($participants_list)){
        $options .= '<option value="'.$participant['id'].'">'.$participant['id'].'</option>';
    }
    $query = "SELECT * FROM range_event_participation WHERE event_id='$event' AND range_id='$session_id'";
    $i = 0;
    if ($fetched = mysqli_query($connection, $query)){
        if ($fetched->num_rows){
            while ($entry = mysqli_fetch_array($fetched)){
                $i++;
                $changes .= '<div class="row card card-body m-4" id="participation_entry_'.$i.'">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h1 class="h4">ENTRY - '.$i.'</h1>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <form onsubmit="return delete_participation_entry(\'participation_entry_delete_'.$i.'\')" id="participation_entry_delete_'.$i.'">
                                    <input type="text" name="entry-id" value="'.$entry['entry_id'].'"  hidden>
                                    <input type="text" name="div-id" value="participation_entry_'.$i.'" hidden>
                                    <button type="submit" class="btn btn-danger btn-sm">DELETE ENTRY&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                        <form action="../api.php" method="post" onsubmit="return add_participation_entry(\'entry_'. $i.'_form\')" id="entry_'.$i.'_form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="candidate-id">PARTICIPANT ID</label>
                                    <input type="text" name="entry-id" value="'.$entry['entry_id'].'" hidden>
                                    <input type="number" name="ser" value="'.$i.'" hidden>
                                    <input type="text" list="participants" name="candidate-id" value="'.$entry['candidate_id'].'" placeholder="CANDIDATE ID" class="form-control" required="">
                                    <datalist id="participants">
                                    '.$options.'
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="candidate-points">POINT SCORED (OUT OF 10)</label>
                                    <input type="number" name="candidate-points" placeholder="POINTS SCORED" step="0.01" value="'.$entry['points_scored'].'" min="0" max="10" class="form-control" required="">

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="candidate-position">POSITION</label>
                                    <select name="candidate-position" class="form-control" required="">
                                        <option value=""';
                $position = $entry['position'];
                if (!$position)$changes .= 'selected';
                $changes .= '>---CHOOSE THE POSITION---</option>
                                            <option value="1"';
                if ($position==1)$changes .= 'selected';
                $changes .= '>FIRST</option>
                                            <option value="2"';
                if ($position==2)$changes .= 'selected';
                $changes .= '>SECOND</option>
                                            <option value="3"';
                if ($position==3)$changes .= 'selected';
                $changes .= '>THIRD</option>
                                            <option value="4"';
                if ($position==4)$changes .= 'selected';
                $changes .= '>OTHERS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="candidate-remarks">REMARKS</label>
                                        <input type="text" name="candidate-remarks" value="'.$entry['remarks'].'" placeholder="REMARKS" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success btn-sm">SAVE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>';
            }
        }else{
            $changes .= '<h1 class="text-center">No Entries Yet!</h1>';
        }
        echo json_encode(array('status_code'=>1, 'changes'=>$changes, 'count'=>$i));
    }else{
        echo json_encode(array('status_code'=>0, 'error_msg'=>"Oh no, Something went wrong!", 'error_desc'=>$connection->error));
    }
}

//Delete Entries
if ($id == 6){
    if (!$_POST['entry-id']){
        echo json_encode(array('status_code'=>1, 'remover-id'=>$_POST['div-id']));
    }else{
        $entry_id = $_POST['entry-id'];
        $query = "DELETE FROM range_event_participation WHERE entry_id='$entry_id'";
        if ($deleted = mysqli_query($connection, $query)){
            echo json_encode(array('status_code'=>1, 'remover-id'=>$_POST['div-id']));
        }else{
            echo json_encode(array('status_code'=>0, 'error_msg'=>"Oops, Something went wrong!", 'error_desc'=>$connection->error));
        }
    }
}

//Final Submit - Ranges
if ($id == 7){
    $insert_query = "INSERT IGNORE INTO
  zone_event_participation (entry_id, event_id, range_id, candidate_id)
SELECT
  entry_id,
  event_id,
  range_id,
  candidate_id
FROM
  range_event_participation rep
WHERE
  rep.position = 1 AND rep.range_id='$session_id';";
    if ($inserted = mysqli_query($connection, $insert_query)){
        echo json_encode(array('status_code'=>1));
    }else{
        echo json_encode(array('status_code'=>0, 'error_msg'=>'Oops, something went wrong!', 'error_desc'=>$connection->error));
    }
}

//Save Team Manager Details
if ($id == 8){
    $team_manager_name = $_POST['team-manager-name'];
    $team_manager_mobile = $_POST['team-manager-mobile'];
    $query = "UPDATE arts_ranges SET team_manager='$team_manager_name', team_manager_mobile='$team_manager_mobile' WHERE range_id='$session_id'";
    if (mysqli_query($connection, $query)){
        echo json_encode(array('status_code'=>1));
    }else{
        echo json_encode(array('status_code'=>0, 'error_msg'=>'Oh no, something went wrong!', 'error_desc'=>$connection->error));
    }
}