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