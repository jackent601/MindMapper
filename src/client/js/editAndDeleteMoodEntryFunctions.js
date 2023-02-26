function confirmDelete(e, api_key, mood_entry_id){//}, api_key, mood_entry_id){
    if(!confirm('Are you sure you wish to delete this entry?')) {
        e.preventDefault();
    }else{
        // prevent default for manual request and redirect
        e.preventDefault();
        // Send Delete Query
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("POST", "http://localhost/Project/src/api/src/deleteMoodEntryFromIDapi.php", false); // false for synchronous request
        // API key
        xmlHttp.setRequestHeader("X-API-KEY", api_key)

        // Form Data
        var data;
        data = new FormData();
        data.append('MOOD_ENTRY_ID', mood_entry_id);

        // Send Delete (and log result)
        xmlHttp.send(data);
        console.log(xmlHttp.responseText);

        // Redirect to Homepage
        window.location.href = "http://localhost/Project/src/client/";
    }
}

function confirmEdit(e, api_key, mood_entry_id){//}, api_key, mood_entry_id){
    if(!confirm('Update this entry?')) {
        e.preventDefault();
    }else{
        // prevent default for manual request and redirect
        e.preventDefault();

        // Get new mood context
        var formDataSerial = $('#moodEditForm').serializeArray();
        var formData = {};
        for (var i = 0; i < formDataSerial.length; i++){
            formData[formDataSerial[i]['name']] = formDataSerial[i]['value'];
        }
        var newMoodContext = formData['moodContext'];
        console.log("New mood context: "+newMoodContext);
    
        // const mood_context_form = formFields.moodContext;
        // Send Update Query
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("POST", "http://localhost/Project/src/api/src/updateMoodEntryFromIDapi.php", false); // false for synchronous request
        // API key
        xmlHttp.setRequestHeader("X-API-KEY", api_key)

        // Form Data
        var data;
        data = new FormData();
        data.append('MOOD_ENTRY_ID', mood_entry_id);
        data.append('MOOD_CONTEXT_UPDATE', newMoodContext);

        // Send Delete (and log result)
        xmlHttp.send(data);
        console.log(xmlHttp.responseText);

        // Redirect to Homepage
        window.location.href = "http://localhost/Project/src/client/";
    }
}

function displayEditMoodEntryForm(moodEntry, api_key){
    // Unpack Mood Entry
    var mood_entry_id = moodEntry.id;
    var mood_name = moodEntry.name;
    var mood_desc = moodEntry.descriptor;
    var context = moodEntry.context;
    var datetime = moodEntry.datetime;
    // Format Date
    var datetimeFormatted = getDateStringFromDateTime(datetime);

    var deleteConfirmString = "confirmDelete(event,\x22" + api_key + "\x22," + mood_entry_id + ")";
    var editConfirmString = "confirmEdit(event,\x22" + api_key + "\x22," + mood_entry_id + ")";

    // create Form
    var newForm = "<form id='moodEditForm' method='POST'>"+
    // Mood Date (cant be changed)
    "<fieldset class='uk-fieldset'><legend class='uk-legend'>"+datetimeFormatted+"</legend>"+
    // Mood ID (hidden but used to pass to api)
    // "<input type='hidden' id='MOOD_ENTRY_ID' name='MOOD_ENTRY_ID' value='"+mood_entry_id+"'>"+
    // Mood Value (cant be changed)
    "<div class='uk-margin'><h3> Mood </h3><input class='uk-input uk-form-width-medium' type='text' aria-label='disabled' value='"+ mood_name +"' disabled></div>"+
    // Context (editable)
    "<div class='uk-margin'><h3> Context </h3></div>"+
    "<div class='uk-margin'><input name = 'moodContext' class='uk-input' type='text' value='"+context+"'aria-label='Input'></div>"+
    // Update Buttons (including handle events for delete, edit)
    "<div class='uk-margin uk-grid-small uk-child-width-auto uk-grid'><p class='uk-margin'>"+
        "<button id='updateMoodEntry' class='uk-button uk-button-default' "+
        // Add handler for edit
        "onclick="+editConfirmString+">Update</button>"+
        "<button id='deleteMoodEntry' class='uk-button uk-button-danger' "+
        // Add handler for delete
        "onclick="+deleteConfirmString+">Delete</button>"+
    "</p></div></fieldset></form>";
    
    // Add to DOM
    $("#editMoodEntryForm").append(newForm);

    // Handle 
}