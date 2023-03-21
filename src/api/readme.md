## API



| **File**                  | **Full Path**                              | **File Type** | **Description**                               |
| ------------------------- | ------------------------------------------ | ------------- | --------------------------------------------- |
| readme.md                 | ./src/api/readme.md                        | API  endpoint | read me                                       |
| createAccount.php         | ./src/api/src/createAccount.php            | API  endpoint | create  user account, session variables set   |
| deleteAccount.php         | ./src/api/src/deleteAccount.php            | API  endpoint | Delete user account and all associated data   |
| deleteMoodEntryFromID.php | ./src/api/src/deleteMoodEntryFromID.php    | API  endpoint | Delete specific mood entry for user           |
| getMoodEntryFromID.php    | ./src/api/src/getMoodEntryFromID.php       | API  endpoint | Get single mood entry, by ID, for user        |
| getUserMoodEntries.php    | ./src/api/src/getUserMoodEntries.php       | API  endpoint | Retrieve all mood entries associated to user  |
| getUserMoodOptions.php    | ./src/api/src/getUserMoodOptions.php       | API  endpoint | Get list of all moods available to user       |
| login.php                 | ./src/api/src/login.php                    | API  endpoint | Login to app, session variables set           |
| submitNewMoodEntry.php    | ./src/api/src/submitNewMoodEntry.php       | API  endpoint | Create new mood entry for user                |
| updateMoodEntryFromID.php | ./src/api/src/updateMoodEntryFromIDapi.php | API  endpoint | Update specific mood entry context for user   |
| dbconn.php                | ./src/api/src/dbconn.php                   | PHP  utility  | PHP utility  for connection to MySQL database |
| verifyApiKeyHeader.php    | ./src/api/src/verifyApiKeyHeader.php       | PHP  utility  | Authenticate  api key header                  |
