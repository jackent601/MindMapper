function displayMoodEntries(userMoodEntries){
    /*
    Displays a list of mood entries (which will be specific to a user but function is general)
    */
    
    // Loop through entries and display
    userMoodEntries.forEach(moodEntry => {
        
        // Unpack Entry
        var mood_name = moodEntry.name;
        var mood_desc = moodEntry.descriptor;
        var context = moodEntry.context;
        var datetime = moodEntry.datetime;
        // Format Date
        var datetimeFormatted = getDateStringFromDateTime(datetime);

        // Form New Div
        var new_div = "<div><div class='hoverSwitchParent uk-card uk-card-body uk-card-hover uk-card-default uk-card-small'>"+
        // Add badge for deleting/editing
        "<div class='uk-card-badge'><button class='pseudo'>Delete</button></div>" +
        "<h3 class='uk-card-title uk-remove-margin-bottom uk-card-small'>" + datetimeFormatted + "</h3>" + 
        "<b>" + mood_name + "</b>"+
        // Add hidden context which is expnded on hover
        "<p class = 'hoverSwitchChild'><i>" + context + "</i></p>" +
        "</div></div>"

        // Add to DOM
        $("#newrows").append(new_div);
    }); 
}

const getDayDateOrdinal = (number) => {
    // Gets ordinal for a day date
    if (number > 3 && number < 21) return "th";
    switch (number % 10) {
      case 1:
        return "st";
      case 2:
        return "nd";
      case 3:
        return "rd";
      default:
        return "th";
    }
  };

function getDateStringFromDateTime(datetime){
    // Format Date from date string, returns Day X(ord) Month Year
    var dateObj = new Date(Date.parse(datetime));
    var dayName = dateObj.toLocaleDateString("en-GB", { weekday: 'long' });  
    var dayDate = dateObj.getDate();
    var dayDateOrdinal = getDayDateOrdinal(dayDate);
    var dateMonth = dateObj.toLocaleDateString("en-GB", {month: 'long'});
    var dateYear = dateObj.toLocaleDateString("en-GB", {year: 'numeric'});
    var finalDateString = dayName + " " + dayDate + dayDateOrdinal + " " + dateMonth + " " + dateYear;
    return finalDateString;
}