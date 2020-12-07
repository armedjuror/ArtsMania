<?php
require '../configs/artsmania-config.php';
include './sessions.php';

if (isset($_POST['id'])){
    $id = $_POST['id'];
}else{
    header('location: logout.php');
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
