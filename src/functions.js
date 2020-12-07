function search() {
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
function add_participation_entry_form(){
    let count = parseInt(document.getElementById('participants_count').value) + 1
    let box = document.getElementById('participants-box')
    box.innerHTML += '<div class="row card card-body m-4">\n' +
        '                    <div class="col-md-12">\n' +
        '                        <div class="row">\n' +
        '                            <div class="col-md-6">\n' +
        '                                <div class="form-group">\n' +
        '                                    <h1 class="h4">ENTRY - '+ count +'</h1>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="col-md-6 text-right">\n' +
        '                                <button class="btn btn-danger btn-sm">DELETE ENTRY&nbsp;&nbsp;&nbsp;<i class="fa fa-trash"></i></button>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                        <form action="api.php" method="post" onsubmit="add_participation_entry()">\n' +
        '                            <div class="row">\n' +
        '                                <div class="col-md-3">\n' +
        '                                    <div class="form-group">\n' +
        '                                        <label for="candidate-id">PARTICIPANT ID</label>\n' +
        '                                        <input type="text" list="participants" name="candidate-id" id="candidate-id" placeholder="CANDIDATE ID" class="form-control" required>\n' +
        '                                        <datalist id="participants">\n' +
        '                                            <option value="AM-2-1">AM-2-1</option>\n' +
        '                                        </datalist>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                                <div class="col-md-3">\n' +
        '                                    <div class="form-group">\n' +
        '                                        <label for="candidate-points">POINT SCORED (OUT OF 10)</label>\n' +
        '                                        <input type="number" name="candidate-points" id="candidate-points" placeholder="POINTS SCORED" min="0" max="10" class="form-control" required>\n' +
        '\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                                <div class="col-md-3">\n' +
        '                                    <div class="form-group">\n' +
        '                                        <label for="candidate-position">POSITION</label>\n' +
        '                                        <select name="candidate-position" id="candidate-position" class="form-control" required>\n' +
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
        '                                        <input type="text" name="candidate-remarks" id="candidate-remarks" placeholder="REMARKS" class="form-control">\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="row">\n' +
        '                                <div class="col-lg-12 text-right">\n' +
        '                                    <button class="btn btn-success btn-sm">SAVE</button>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </form>\n' +
        '                    </div>\n' +
        '                </div>'
    document.getElementById('participants_count').value = count


}
