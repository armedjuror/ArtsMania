function search_participants() {
    // Declare variables
    let input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search_bar");
    filter = input.value.toUpperCase();
    table = document.getElementById("participants-list");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
function search_event() {
    // Declare variables
    let input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("search_bar");
    filter = input.value.toUpperCase();
    table = document.getElementById("events-list");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
function add_participation_entry_form(){
    if (!document.getElementById('event').value){
        alert('Please select an event!')
    }else{
        let count = parseInt(document.getElementById('participants_count').value) + 1
        let box = document.getElementById('participants-box')
        if (count === 1){
           box.innerHTML = ''
        }
        let changes = ''
        let options = ''
        participants.forEach((item, index)=>{
            options += '<option value="'+ item +'">'+ item +'</option>'
        })
        changes += '<div class="row card card-body m-4" id="participation_entry_'+ count +'">\n' +
            '                    <div class="col-md-12">\n' +
            '                        <div class="row">\n' +
            '                            <div class="col-md-6">\n' +
            '                                <div class="form-group">\n' +
            '                                    <h1 class="h4">ENTRY - '+ count +'</h1>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                            <div class="col-md-6 text-right">\n' +
            '                                <form onsubmit="return delete_participation_entry(\'participation_entry_delete_'+count+'\')" id="participation_entry_delete_'+count+'">\n' +
                '                                <input type="text" name="entry-id" value="" hidden>\n' +
                '                                <input type="text" name="div-id" value="participation_entry_'+ count +'" hidden>\n' +
                '                                <button type="submit" class="btn btn-danger btn-sm">DELETE ENTRY&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true"></i></button>\n' +
            '                                </form>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        <form action="../api.php" method="post" onsubmit="return add_participation_entry(\'entry_'+ count +'_form\')" id="entry_'+ count +'_form">\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-md-3">\n' +
            '                                    <div class="form-group">\n' +
            '                                        <label for="candidate-id">PARTICIPANT ID</label>\n' +
            '                                        <input type="number" name="ser" value="'+ count +'" hidden>'+
            '                                        <input type="text" name="entry-id" id="entry-id" hidden>\n' +
            '                                        <input type="text" list="participants" name="candidate-id" placeholder="CANDIDATE ID" class="form-control" required>\n' +
            '                                        <datalist id="participants">\n' +
            options +
            '                                        </datalist>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                                <div class="col-md-3">\n' +
            '                                    <div class="form-group">\n' +
            '                                        <label for="candidate-points">POINT SCORED (OUT OF 10)</label>\n' +
            '                                        <input type="number" name="candidate-points" placeholder="POINTS SCORED" min="0" max="10" step="0.01" class="form-control" required>\n' +
            '\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                                <div class="col-md-3">\n' +
            '                                    <div class="form-group">\n' +
            '                                        <label for="candidate-position">POSITION</label>\n' +
            '                                        <select name="candidate-position" class="form-control" required>\n' +
            '                                            <option value="">---CHOOSE THE POSITION---</option>\n' +
            '                                            <option value="1">FIRST</option>\n' +
            '                                            <option value="2">SECOND</option>\n' +
            '                                            <option value="3">THIRD</option>\n' +
            '                                            <option value="4">OTHERS</option>\n' +
            '                                        </select>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                                <div class="col-md-3">\n' +
            '                                    <div class="form-group">\n' +
            '                                        <label for="candidate-remarks">REMARKS</label>\n' +
            '                                        <input type="text" name="candidate-remarks" placeholder="REMARKS" class="form-control">\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-lg-12 text-right">\n' +
            '                                    <button type="submit" class="btn btn-success btn-sm">SAVE</button>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </form>\n' +
            '                    </div>\n' +
            '                </div>'
        box.innerHTML += changes
        document.getElementById('participants_count').value = count
    }
}

const entry_count_object = document.getElementById('participation-count');
if (entry_count_object){
    entry_count_object.addEventListener('change', ()=>{
        let entry_count = parseInt(entry_count_object.value)
        if (!entry_count){
            document.getElementById('empty-box').style.display = 'inline'
        }else{
            document.getElementById('empty-box').style.display = 'none'
        }

    })
}