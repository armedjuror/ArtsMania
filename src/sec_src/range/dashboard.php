<?php
include 'head.php';
?>
<section>

    <div class="card" style="height: 200px; width: 100%; background-color: #333333;">
        <div class="card-body">
            <h3 style="color: #ffffff; line-height: 200px;">Welcome to Arts Mania</h3>
        </div>
    </div>
    <div class="container mt-5 ">
        <div class="row p-2">
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3 rounded" style="max-width: 18rem;">
                    <div class="card-body">
                        <h4 class="card-title">Participants</h4>
                        <?php
                        $count = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) as count FROM arts_participants WHERE participant_range='$session_id'"))['count'];
                        ?>
                        <p class="h1"><?=$count?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h4 class="card-title">Entries</h4>
                        <?php
                        $count = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) as count FROM range_event_participation WHERE range_id='$session_id'"))['count'];
                        ?>
                        <p class="h1"><?=$count?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                $count = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) as count FROM zone_event_participation WHERE range_id='$session_id'"))['count'];
                ?>
                <div class="card text-white <?=$count?'bg-success':'bg-danger'?> mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h4 class="card-title">Final Submission</h4>
                        <p class="h1"><?=$count?"DONE":'NOT YET'?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-md-12"><h2 class="h2 text-center">TEAM MANAGER DETAILS</h2></div>
        </div>
        <form id="team-manager-form" onsubmit="return save_team_manager()">
        <div class="row">
            <?php
            $query = "SELECT team_manager as name, team_manager_mobile as mobile FROM arts_ranges WHERE range_id='$session_id'";
            $team_manager = mysqli_fetch_array(mysqli_query($connection, $query));
            ?>
                <div class="col-md-4">
                    <input type="number" name="id" value="8" hidden>
                    <label for="team-manager-name">TEAM MANAGER NAME</label>
                    <input type="text" name="team-manager-name" id="team-manager-name" value="<?=$team_manager['name']?>" placeholder="TEAM MANAGER NAME" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="team-manager-mobile">TEAM MANAGER MOBILE</label>
                    <input type="number" name="team-manager-mobile" id="team-manager-mobile"  value="<?=$team_manager['mobile']?>" placeholder="TEAM MANAGER MOBILE" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="team-manager-mobile">SAVE / UPDATE</label>
                    <button class="btn btn-success btn-block" id="team-manager-save">SAVE&nbsp;&nbsp;&nbsp;<i class="fa fa-save"></i></button>
                </div>
            </form>
        </div>
        <div class="row p-2 mt-5" style="min-height: 400px;">
            <div class="col-md-12">
                <h2 class="h2 text-center">ARTS MANIA MANUAL</h2>
                <iframe src="../docs/Arts%20Mania%20Manual.pdf" frameborder="0" style="width:100%;min-height: 1000px"></iframe>
            </div>
        </div>
    </div>

</section>
<?php
include 'foot.php';
