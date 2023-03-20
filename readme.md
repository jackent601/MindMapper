# Mind Mapper

Mind Mapper is an application to allow users to track their moods over time.



Moods are captured using a Valence-Arousal circumplex model, more details of the model can be found [here](https://en.wikipedia.org/wiki/Emotion_classification#Circumplex_model).



Explanation of code base provided below:



| **Collection**                     | **File**                                           | **Full Path**          | **File Type**                                                | **Description**  |
| ---------------------------------- | -------------------------------------------------- | ---------------------- | ------------------------------------------------------------ | ---------------- |
| src                                | readme.md                                          | ./src/readme.md        | Doc                                                          | read me          |
| api                                | readme.md                                          | ./src/api/readme.md    | API  endpoint                                                | read me          |
| createAccount.php                  | ./src/api/src/createAccount.php                    | API  endpoint          | create  user account, session variables set                  |                  |
| deleteAccount.php                  | ./src/api/src/deleteAccount.php                    | API  endpoint          | Delete user account and all associated data                  |                  |
| deleteMoodEntryFromID.php          | ./src/api/src/deleteMoodEntryFromID.php            | API  endpoint          | Delete specific mood entry for user                          |                  |
| getMoodEntryFromID.php             | ./src/api/src/getMoodEntryFromID.php               | API  endpoint          | Get single mood entry, by ID, for user                       |                  |
| getUserMoodEntries.php             | ./src/api/src/getUserMoodEntries.php               | API  endpoint          | Retrieve all mood entries associated to user                 |                  |
| getUserMoodOptions.php             | ./src/api/src/getUserMoodOptions.php               | API  endpoint          | Get list of all moods available to user                      |                  |
| login.php                          | ./src/api/src/login.php                            | API  endpoint          | Login to app, session variables set                          |                  |
| submitNewMoodEntry.php             | ./src/api/src/submitNewMoodEntry.php               | API  endpoint          | Create new mood entry for user                               |                  |
| updateMoodEntryFromID.php          | ./src/api/src/updateMoodEntryFromIDapi.php         | API  endpoint          | Update specific mood entry context for user                  |                  |
| dbconn.php                         | ./src/api/src/dbconn.php                           | PHP  utility           | PHP utility  for connection to MySQL database                |                  |
| verifyApiKeyHeader.php             | ./src/api/src/verifyApiKeyHeader.php               | PHP  utility           | Authenticate  api key header                                 |                  |
| client                             | Info.php                                           | ./src/client/info.php  | Web Page                                                     | App &  Mood info |
| createAccount.php                  | ./src/client/createAccount.php                     | Web Page               | User  registration                                           |                  |
| deleteAccount.php                  | ./src/client/deleteAccount.php                     | Web Page               | User  requesting account deletion                            |                  |
| editMoodEntry.php                  | ./src/client/editMoodEntry.php                     | Web Page               | Edit Mood  Entry                                             |                  |
| index.php                          | ./src/client/index.php                             | Web Page               | Home Page                                                    |                  |
| login.php                          | ./src/client/login.php                             | Web Page               | User  login                                                  |                  |
| logout.php                         | ./src/client/logout.php                            | Web Page               | User log  out                                                |                  |
| moodCharts.php                     | ./src/client/moodCharts.php                        | Web Page               | User Mood  Visualisations                                    |                  |
| readme.md                          | ./src/client/readme.md                             | Doc                    | read me                                                      |                  |
| mystyles.css                       | ./src/client/css/mystyles.css                      | CSS                    | CSS style  sheet, including overrides                        |                  |
| chartMoodFunctions.js              | ./src/client/js/chartMoodFunctions.js              | JavaScript  Function   | Parse  mood data into plottable data objects                 |                  |
| displayMoodEntries.js              | ./src/client/js/displayMoodEntries.js              | JavaScript  Function   | Create  HTML to display moods from list of entries           |                  |
| editAndDeleteMoodEntryFunctions.js | ./src/client/js/editAndDeleteMoodEntryFunctions.js | JavaScript  Function   | Utilities  for editing/deleting moods, including displaying form and event handlers |                  |
| enterMoodFunctions.js              | ./src/client/js/enterMoodFunctions.js              | JavaScript  Function   | Utilities  for creating new mood entry                       |                  |
| utilities.js                       | ./src/client/js/utilities.js                       | JavaScript  Function   | General  utilities for date formatting                       |                  |
| bkg.jpg                            | ./src/client/media/bkg.jpg                         | Media                  | background  image                                            |                  |
| logo.png                           | ./src/client/media/logo.png                        | Media                  | logo  image                                                  |                  |
| server                             | readme.md                                          | ./src/server/readme.md | Doc                                                          | read me          |
| mindmapper.sql                     | ./src/server/db/mindmapper.sql                     | SQL                    | SQL database file                                            |                  |