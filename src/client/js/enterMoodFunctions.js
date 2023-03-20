function handleMoodEntrySubmission(e, api_key){
    e.preventDefault();
    // Get new mood entry details
    var formDataSerial = $('#newMoodEntryForm').serializeArray();
    var formData = {};
    for (var i = 0; i < formDataSerial.length; i++){
        formData[formDataSerial[i]['name']] = formDataSerial[i]['value'];
    }
    // var newEntryMoodID = formData['mood_selection'];
    if('mood_context' in formData){
        var newEntryContext = formData['mood_context'];
    }else{
        var newEntryContext = "";
    }
    var moodName = formData['mood_name'];
    var moodValence = formData['cValence'];
    var moodArousal = formData['cArousal'];
    
    // console.log('Mood id: '+newEntryMoodID+', mood context: '+newEntryContext)

    // Send New Entry
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", "http://localhost/projectv2/mindmapper/src/api/src/submitNewMoodEntry.php", false); // false for synchronous request
    // API key 
    xmlHttp.setRequestHeader("X-API-KEY", api_key)

    // Form Data
    var data;
    data = new FormData();
    // data.append('NEW_ENTRY_MOOD_ID', newEntryMoodID);
    data.append('NEW_ENTRY_MOOD_NAME', moodName);
    data.append('NEW_ENTRY_MOOD_VALENCE', moodValence);
    data.append('NEW_ENTRY_MOOD_AROUSAL', moodArousal);
    data.append('NEW_ENTRY_MOOD_CONTEXT', newEntryContext);

    // Send Delete (and log result)
    xmlHttp.send(data);
    console.log(xmlHttp.responseText);

    // Redirect to Homepage
    window.location.href = "http://localhost/projectv2/mindmapper/src/client/";
}


function populateMoodOptionsEntryForm(moodOptions){
    // Add each mood to option for mood entry
    moodOptions.forEach(moodOption => {
        // Unpack Entry
        var mood_entry_id = moodOption.mood_id;
        var mood_name = moodOption.name;
        var mood_arousal = moodOption.arousal;
        var mood_valence = moodOption.valence;
        // Format Option
        var moodOptionString = mood_name + " (valence: " + mood_valence + ", arousal: " + mood_arousal + ")";

        // Create option
        var newOption = "<option value='" + mood_entry_id + "'>" + moodOptionString+"</option>";
        // console.log(newOption);

        // // Add to DOM
        $("#moodOptionSelectDiv").append(newOption);
    });
}