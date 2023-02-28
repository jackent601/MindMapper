function getDateValuesFromMoodEntries(moodEntries){
    // takes an array of mood entries
    // Loop through entries
    var arousalDataPoints = [];
    var valenceDataPoints = [];
    moodEntries.forEach(moodEntry => {
        // Get Data Sets
        arousalDataPoints.push({x: new Date(moodEntry.datetime), y: parseInt(moodEntry.arousal)});
        valenceDataPoints.push({x: new Date(moodEntry.datetime), y: parseInt(moodEntry.valence)});
    }); 

    // Create return array
    var chartValues = {'arousalDataPoints': arousalDataPoints, 'valenceDataPoints': valenceDataPoints};
    return chartValues;
}