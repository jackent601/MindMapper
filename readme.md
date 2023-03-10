# Mood Tracker Application

Submission for completion of part-time MSc Software Development, Queens University Belfast

## ToDo

- [ ] **User Login**
  - [ ] **Basic**
  - [ ] **Hash Passwords**
- [ ] **API Key**
  - [ ] **Write up method with justification**
  - [ ] **Set API keys at login**
- Need a compromise between security (and what is possible in time frame). This was an api key as a query parameter but the api key is hidden from user and from directly ?query, additionally api key only provided at session level on authentication so communication already encrypter under HTTPS _AND_ authentication through proxy of login.
- Important to note API security is important because a) api requests used to retrieve mood data b) unreasonable to expect user to authenticate for every request c0 don't want to use passwords as direct api auth.
- Not ideal that api key could be brute forced as api checking end points are technically exposed but by trying but this would quickly be caught by server, and is a risk across all brute forcing strategies!! only defence would be to place balancer between verifyAPIKeyHeader 
- [x] **logged in session variable**
- Page only displays moods if logged in, logged in session variable so can only be set at server-level for security
- Fetching moods further security checks through api, equally a server-level session variable ibid
- [x] **Displaying moods**
- By declaring css classes and utilising display quality a jquery event could be set up on hover to expand each card to show description individually when hovered over -> information accessible but not cluttered
- Likewise overiding the label css in uk-card dulls down delete moods to provide functionality but dissuade users from deleting entries 
- [x] editing/deleting moods
- form is used to collect input but normal form submission event is overwritten with javascript utilities to allow for delete confirmation and to set appropriate api keys automatically
- API: another example of api complexity abstraction, database architecture allows for user tags, this table first needs deleted then the mood entry itself to maintain FK constraint integrity
- js confirm dialogue box to ensure user wants to delete mood
- mood entry id attached as id attribute to delete boxes for convenient UI, note no security concerns here having id output in html as api-key verification required to send requests using ids.
- [x] if deletion confirmed, handled by an on click event by constructing suitable calls to api from within index page. 9again no security concern as api-key is server-level variable)
- [x] Add Mood Entry

- Form caught with js processing
- CURRENT_TIMESTAMP used to get datetime, allowing user to specify dates would allow users to circumvent the inability to change mood ids! 

- [ ] JS structure

Currently separated into modular functions, this means utilities needs loaded separately but could be incorporated into functions using ES6



- [ ] delete account

- api verification done from session variable to ensure user has been logged in before deleting account, different set up to previous api endpoints that were designed to be session-agnostic, as account deletion seen as a greater security task it relies on session variables







Improvements

convert php processes into utilities, e.g. check number of rows





Ultimate todos:

config folder to prevent hard coding api paths

user tags

custom moods