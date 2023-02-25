function displayMoodEntries(userMoodEntries){
    /*
    Displays a list of mood entries (which will be specific to a user but function is general)
    */
    
    // Loop through entries and display
    userMoodEntries.forEach(moodEntry => {
        
        // Unpack Entry
        var mood_id = moodEntry.mood_id;
        var context = moodEntry.context;
        var datetime = moodEntry.datetime;
        // Format Date
        var datetimeFormatted = getDateStringFromDateTime(datetime);

        // Form New Div
        var new_div = "<div><span><article class='card myminheight'>"+
        "<header><h4>"+ mood_id + "</h4></header>"+
        "<p> Datetime:"+ datetime + "</p>"+
        "<p> Datetime Formatted:"+ datetimeFormatted + "</p>"+
        "<footer class='myfooter'></footer></article></span></div>";

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