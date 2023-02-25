# Mood Tracker Application

Submission for completion of part-time MSc Software Development, Queens University Belfast

## ToDo

- [ ] User Login
  - [ ] Basic
  - [ ] Hash Passwords
- [ ] API Key
  - [ ] Write up method with justification
  - [ ] Set API keys at login

Need a compromise between security (and what is possible in time frame). This was an api key as a query parameter but the api key is hidden from user and from directly ?query, additionally api key only provided at session level on authentication so communication already encrypter under HTTPS _AND_ authentication through proxy of login.

Important to note API security is important because a) api requests used to retrieve mood data b) unreasonable to expect user to authenticate for every request c0 don't want to use passwords as direct api auth.

Not ideal that api key could be brute forced as api checking end points are technically exposed but by trying but this would quickly be caught by server, and is a risk across all brute forcing strategies!! only defence would be to place balancer between verifyAPIKeyHeader 

- [ ] logged in session variable

Page only displays moods if logged in, logged in session variable so can only be set at server-level for security

Fetching moods further security checks through api, equally a server-level session variable ibid

- [ ] Fill All Requirements in here