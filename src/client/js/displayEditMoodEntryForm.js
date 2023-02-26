function confirmDelete(e){
    if(!confirm('Are you sure you wish to delete this entry?')) {
        e.preventDefault();
    }
}

function displayEditMoodEntryForm(moodEntry){
    // Unpack Mood Entry
    var mood_entry_id = moodEntry.id;
    var mood_name = moodEntry.name;
    var mood_desc = moodEntry.descriptor;
    var context = moodEntry.context;
    var datetime = moodEntry.datetime;
    // Format Date
    var datetimeFormatted = getDateStringFromDateTime(datetime);

    // create Form
    var newForm = "<form>"+
    // Mood Date (cant be changed)
    "<fieldset class='uk-fieldset'><legend class='uk-legend'>"+datetimeFormatted+"</legend>"+
    // Mood Value (cant be changed)
    "<div class='uk-margin'><h3> Mood </h3><input class='uk-input uk-form-width-medium' type='text' aria-label='disabled' value='"+ mood_name +"' disabled></div>"+
    // Context (editable)
    "<div class='uk-margin'><h3> Context </h3></div>"+
    "<div class='uk-margin'><input name = 'moodContext' class='uk-input' type='text' value='"+context+"'aria-label='Input'></div>"+
    // Update Buttons
    "<div class='uk-margin uk-grid-small uk-child-width-auto uk-grid'><p class='uk-margin'>"+
        "<button id = 'updateMoodEntry' class='uk-button uk-button-default'>Update</button>"+
        "<button id = 'deleteMoodEntry' class='uk-button uk-button-danger' onclick='confirmDelete(event)''>Delete</button>"+
    "</p></div></fieldset></form>";
    // Add to DOM
    $("#editMoodEntryForm").append(newForm);
}