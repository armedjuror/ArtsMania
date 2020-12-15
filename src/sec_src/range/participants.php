<?php
include 'head.php';
?>
    <section>
        <div class="card p-4 text-white" style="width: 100%; background-color: #333333;">
            <div class="card-body">
                <div class="row m-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h1 class="h4">ADD A PARTICIPANT</h1>
                        </div>
                        <form action="../api.php" method="post" name="create-participants-form" id="create-participants-form" onsubmit="return add_participants()">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="number" value="2" name="id" hidden>
                                        <label for="participant-adm_no">ADMISSION NUMBER</label>
                                        <input type="text" name="participant-adm_no" id="participant-adm_no" placeholder="ADMISSION NUMBER" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="participant-name">NAME</label>
                                        <input type="text" name="participant-name" id="participant-name" placeholder="NAME" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="participant-mobile">MOBILE</label>
                                        <input type="number" name="participant-mobile" id="participant-mobile" placeholder="MOBILE" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="participant-dob">DATE OF BIRTH</label>
                                        <input type="date" name="participant-dob" id="participant-dob" placeholder="DATE OF BIRTH" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="participant-class">CLASS</label>
                                        <input type="number" name="participant-class" id="participant-class" placeholder="CLASS" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="participant-madrassa">MADRASSA NAME</label>
                                        <input type="text" name="participant-madrassa" id="participant-madrassa" placeholder="MADRASSA NAME" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="participant-madrassa_num">MADRASSA NUMBER</label>
                                        <input type="number" name="participant-madrassa_num" id="participant-madrassa_num" placeholder="SKIMVB REGISTER NUMBER" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="participant-gravatar">PARTICIPANT PHOTO</label>
                                        <input type="file" name="participant-gravatar" id="participant-gravatar" class="form-control" accept="image/jpeg, image/png">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-outline-success">ADD PARTICIPANT&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row text-white text-center" id="error-msg">

                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div id="participants-box">
                <div class="row">
                    <div class="col-md-12" id="message-box">
                    </div>
                </div>
                <div class="row mt-5 m-4">
                    <div class="col-md-12">
                        <h1 class="h4">PARTICIPANTS LIST</h1>
                        <div class="form-group">
                            <input type="text" id="search_bar" onkeyup="search_participants()" class="form-control" placeholder="Search for names..">
                        </div>
                        <div>
                            <?=get_participants_table($connection, $session_id)?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php
include 'foot.php';
