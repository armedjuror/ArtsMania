<?php
$connection = mysqli_connect('localhost', 'phpmyadmin', 'fathima11', 'artsmania');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

mysqli_set_charset($connection, 'utf8');

function create_id($connection, $madrassa_num)
{
    $query = "SELECT COUNT(*) as roll FROM arts_participants WHERE participant_madrassa_number='$madrassa_num'";
    $roll = mysqli_fetch_array(mysqli_query($connection, $query))['roll'];
    if (!$roll){
        $roll = 1;
    }else{
        $roll += 1;
    }
    return 'AM-' . $madrassa_num . '-'. $roll;
}

function check_file($file, $allowed_extensions, $max_size, $size_error){
    $result = array('error_code'=>'');
    if ($file['error'] != 4) {
        $array = explode(".", strtolower($file["name"]));
        $extension = end($array);
        if (!in_array($extension, $allowed_extensions)) {
            $result['error_msg'] = 'Unsupported file format!';
        }
        if ($file['size'] > $max_size) {
            $result['error_msg'] = $size_error;
        }
        if (!$result['error_code']) {
            $file_og = addslashes(file_get_contents($file['tmp_name']));
            return array('status_code'=>1, 'file'=>$file_og);
        }else{
            $result['status_code'] = 0;
            return $result;
        }
    }else {
        return array('status_code'=>1, 'file'=>'');
    }
}

function get_participants_table($connection, $range_id){
    $table = '
    <table class="table table-hover table-responsive-lg" id="participants-list">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">ADM NO.</th>
                                <th scope="col">NAME</th>
                                <th scope="col">MADRASSA</th>
                                <th scope="col">CLASS</th>
                                <th scope="col">DOB</th>
                                <th scope="col">MOBILE</th>
                                <th scope="col">OPERATIONS</th>
                            </tr>
                            </thead>
                            <tbody>
    ';
    $query = "SELECT
        participant_id, 
        participant_admission_number,
        participant_name, 
        participant_madrassa, 
        participant_madrassa_number, 
        participant_class,
        participant_dob,
        participant_mobile
        FROM arts_participants WHERE participant_range='$range_id'";
    if ($fetched = mysqli_query($connection, $query)){
        if ($fetched->num_rows){
            while($row = mysqli_fetch_array($fetched)){
                $table .= '
                                    <tr>
                                        <td>'. $row['participant_id'] .'</td>
                                        <td>'. $row['participant_admission_number'] .'</td>
                                        <td>'. $row['participant_name'] .'</td>
                                        <td>'. $row['participant_madrassa'] .'-'.$row['participant_madrassa_number'].'</td>
                                        <td>'. $row['participant_class'] .'</td>
                                        <td>'. $row['participant_dob'] .'</td>
                                        <td>'. $row['participant_mobile'] .'</td>
                                        <td class="text-danger">
                                            <form id="'.$row['participant_id'].'" onsubmit="return delete_participant(\''.$row['participant_id'].'\')">
                                               <button class="btn text-danger" type="submit"><i class="fa fa-trash"></i>&nbsp;&nbsp;DELETE</button>
                                            </form>
                                        </td>
                                    </tr>
                                    ';
            }
        }else{
            $table .= '<tr><td colspan="8" class="text-center font-weight-bold">No Participants Registered Yet!</td></tr>';
        }
    }else{
        $table .= '<tr><td colspan="8" class="text-center font-weight-bold">'. $connection->error .'</td></tr>';
    }
    $table .= '
    </tbody>
 </table>
    ';
    return $table;
}

function get_participation_entries($connection, $session_id, $event_id){
    $query = "SELECT * FROM range_event_participation WHERE range_id='$session_id' AND event_id='$event_id'";
    if ($fetched = mysqli_query($connection, $query)){
        return array('status_code'=>1, 'result'=>$fetched);
    }else{
        return array('status_code'=>0, 'error_msg'=>"Something went wrong!", 'error_desc'=>$connection->error);
    }
}