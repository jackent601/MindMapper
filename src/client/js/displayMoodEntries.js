function displayMoodEntries(userMoodEntries){
    /*
    Displays a list of mood entries (which will be specific to a user but function is general)
    */
    
    // Loop through entries and display
    userMoodEntries.forEach(moodEntry => {
        
        // Unpack Entry
        var mood_entry_id = moodEntry.id;
        var mood_name = moodEntry.name;
        var mood_desc = moodEntry.descriptor;
        var context = moodEntry.context;
        var datetime = moodEntry.datetime;
        // Format Date
        var datetimeFormatted = getDateStringFromDateTime(datetime);

        // Form New Div
        var new_div = "<div><div class='hoverSwitchParent uk-card uk-card-body uk-card-hover uk-card-default uk-card-small'>"+
        // Add badge for deleting/editing
        "<div class='uk-margin'><div class='uk-card-badge'><form class ='uk-form-small' action = './editMoodEntry.php'><button id = " + mood_entry_id + 
        " class='pseudo confirmDeleteMood' type='submit' name='editMoodEntry' value = '" + mood_entry_id + "'>Edit</button></form></div></div>" +
        // Add Mood Info
        "<h3 class='uk-card-title uk-remove-margin-bottom uk-card-small'>" + datetimeFormatted + "</h3>" + 
        "<b>" + mood_name + "</b>"+
        // Add hidden context which is expnded on hover
        "<p class = 'hoverSwitchChild'><i>" + context + "</i></p>" +
        "</div></div>"

        // Add to DOM
        $("#newrows").append(new_div);
    }); 
}