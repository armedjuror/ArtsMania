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
                setTimeout(()=>{
                    document.getElementById('event').innerHTML = response_content['changes']
                    $('#AjaxLoader').hide()
                }, 500)

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

function delete_participant(){
    let participant_id = document.getElementById('')
    let participant = new XMLHttpRequest()
    let url = "api.php"
    let varList = "id=1&category="+ category + "&gender=" + gender
    participant.open('POST', url, true)
    participant.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    participant.onreadystatechange = function () {
        if (participant.readyState === 4 && participant.status === 200) {
            let response_content = JSON.parse(participant.responseText);
            if (response_content['status_code']===1){
                setTimeout(()=>{
                    document.getElementById('event').innerHTML = response_content['changes']
                    $('#AjaxLoader').hide()
                }, 500)

            }else{
                alert(response_content['error_msg'])
                $('#AjaxLoader').hide()
            }
        }
    }
    participant.send(varList)
    $('#AjaxLoader').show()
}