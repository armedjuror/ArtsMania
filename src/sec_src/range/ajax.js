function load_events(){
    let category = document.getElementById('category').value
    let gender = document.getElementById('gender').value
    let event = new XMLHttpRequest()
    let url = "api.php"
    let varList = "id=1&category="+ category + "&gender=" + gender
    event.open('POST', url, true)
    event.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    event.onreadystatechange = function () {
        if (event.readyState === 4 && event.status === 200) {
            let response_content = JSON.parse(event.responseText);
            if (response_content['status_code']===1){
                document.getElementById('event').innerHTML = response_content['changes']
                $('#AjaxLoader').hide()
            }else{
                alert(response_content['error_msg'])
                $('#AjaxLoader').hide()
            }
        }
    }
    event.send(varList)
    $('#AjaxLoader').show()
}

function add_participants(){
    $('#AjaxLoader').show()
    let form = document.getElementById('create-participants-form')
    let formData = new FormData(form);
    $.ajax({
        type:'POST',
        url: 'api.php',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(response)
        {
            let jsonData = JSON.parse(response)
            if (jsonData.status_code === 1 ) {
                alert("Successfully added new participant with id : "+ jsonData.id_created)
                document.getElementById('participants-list').innerHTML = jsonData.changes
                $("#create-participants-form").trigger('reset')
                $('#AjaxLoader').hide()
            } else {
                alert(jsonData.error_msg +" ERROR CODE : " + jsonData.error_code)
                $('#AjaxLoader').hide()
            }
        }
    });
    return false
}

function delete_participant(participant_id){
    let participation = new XMLHttpRequest()
    let url = "api.php"
    let varList = "id=3&p="+ participant_id
    participation.open('POST', url, true)
    participation.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    participation.onreadystatechange = function () {
        if (participation.readyState === 4 && participation.status === 200) {
            let response_content = JSON.parse(participation.responseText);
            if (response_content['status_code']===1){
                alert('Successfully deleted the participant.')
                $('#'+participant_id).closest('tr').remove()
                if (parseInt($('#participants-list tr').length) === 1){
                    let table = document.getElementById('participants-list')
                    let row = table.insertRow(1);
                    row.innerHTML = '<td colspan="8" class="text-center font-weight-bold">No Participants Registered Yet!</td>'
                }
                $('#AjaxLoader').hide()
            }else{
                alert(response_content['error_msg'])
                $('#AjaxLoader').hide()
            }
        }
    }
    participation.send(varList)
    $('#AjaxLoader').show()
    return false;
}

function add_participation_entry(form_id){
    let participation = new XMLHttpRequest()
    let url = "api.php"
    let varList = "id=4&"
    let form_data = $('#'+form_id).serialize()
    varList += form_data
    let event = document.getElementById('event').value
    varList += '&event=' + event
    participation.open('POST', url, true)
    participation.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    participation.onreadystatechange = function () {
        if (participation.readyState === 4 && participation.status === 200) {
            let response_content = JSON.parse(participation.responseText);
            if (response_content['status_code']===1){
                $entry_id = document.getElementsByName('entry-id')
                $entry_id[0].value = response_content['entry-id']
                $entry_id[1].value = response_content['entry-id']
                alert("Successfully added/Updated the entry")
                $('#AjaxLoader').hide()
            }else{
                alert(response_content['error_msg'])
                if (response_content['reset'])
                    document.getElementById(form_id).reset()
                $('#AjaxLoader').hide()
            }
        }
    }
    participation.send(varList)
    $('#AjaxLoader').show()
    return false
}

function load_participation_entries(){
    $('#empty-box').hide()
    $('#add_entry_button').show()
    let event = document.getElementById('event').value
    let participation = new XMLHttpRequest()
    let url = "api.php"
    let varList = "id=5&e=" + event
    participation.open('POST', url, true)
    participation.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    participation.onreadystatechange = function () {
        if (participation.readyState === 4 && participation.status === 200) {
            let response_content = JSON.parse(participation.responseText);
            if (response_content['status_code']===1){
                document.getElementById('participants-box').innerHTML = response_content['changes']
                document.getElementById('participants_count').value = parseInt(response_content['count'])
                $('#AjaxLoader').hide()
            }else{
                alert(response_content['error_msg'])
                $('#AjaxLoader').hide()
            }
        }
    }
    participation.send(varList)
    $('#AjaxLoader').show()
}

function delete_participation_entry(form_id){
    let participation = new XMLHttpRequest()
    let url = "api.php"
    let varList = "id=6&"
    let form_data = $('#'+form_id).serialize()
    varList += form_data
    participation.open('POST', url, true)
    participation.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    participation.onreadystatechange = function () {
        if (participation.readyState === 4 && participation.status === 200) {
            let response_content = JSON.parse(participation.responseText);
            if (response_content['status_code']===1){
                document.getElementById(response_content['remover-id']).remove()
                document.getElementById('participants_count').value = parseInt(document.getElementById('participants_count').value)-1
                if (!parseInt(document.getElementById('participants_count').value)){
                    document.getElementById('participants-box').innerHTML = '<h1 class="text-center">No Entries Yet!</h1>'
                }
                alert("Successfully deleted the entry")
                $('#AjaxLoader').hide()
            }else{
                alert(response_content['error_msg'])
                if (response_content['reset'])
                    document.getElementById(form_id).reset()
                $('#AjaxLoader').hide()
            }
        }
    }
    participation.send(varList)
    $('#AjaxLoader').show()
    return false
}

function final_submit(){
    let final_list = new XMLHttpRequest()
    let url = "api.php"
    let varList = "id=7"
    final_list.open('POST', url, true)
    final_list.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    final_list.onreadystatechange = function () {
        if (final_list.readyState === 4 && final_list.status === 200) {
            console.log(final_list.responseText)
            let response_content = JSON.parse(final_list.responseText);
            if (response_content['status_code']===1){
                $('#finalModal').modal('hide')
                alert('Successfully submitted the final list.')
                $('#AjaxLoader').hide()
            }else{
                alert(response_content['error_msg'])
                $('#AjaxLoader').hide()
            }
        }
    }
    final_list.send(varList)
    $('#AjaxLoader').show()
    return false
}

function save_team_manager(){
    let team_manager = new XMLHttpRequest()
    let url = "api.php"
    let varList = $('#team-manager-form').serialize()
    team_manager.open('POST', url, true)
    team_manager.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    team_manager.onreadystatechange = function () {
        if (team_manager.readyState === 4 && team_manager.status === 200) {
            console.log(team_manager.responseText)
            let response_content = JSON.parse(team_manager.responseText);
            if (response_content['status_code']===1){
                alert('Successfully saved the team manager details.')
                $('#AjaxLoader').hide()
            }else{
                alert(response_content['error_msg'])
                $('#AjaxLoader').hide()
            }
        }
    }
    team_manager.send(varList)
    $('#AjaxLoader').show()
    return false
}