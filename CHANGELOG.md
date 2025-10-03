# CHANGELOG

### 2024-12-19
- Reorganised GitLab filetree to match the GitHub file tree (easier porting)
- Default PFP now in repo, because it was missing due to misconfigured .gitignore
- Minor API rework
- Copyright documents in ToS now open on a new tab (`_blank`)
- Posts are now stored in a single table, instead of separate header and content
- Content warning checkboxes now reset after pressing "Post!"
- When a user changes their profile picture, the old one gets deleted from the server

### 2024-11-11
Project now officially available on [GitHub](https://github.com/balika0105/postpad-public)

### 2024-02-15
- Removed `cw_gore` from `posts` table because I realised we don't allow that lol
- Changed `cw_nudity` to `cw_nsfw` in database
- Implemented post bluring if the post is marked as "Not Safe For Work", or if it has a general content warning
- Added invite code generator (requires `libsodium`)
- Started working on "Invite Only" features

### 2024-02-14
*Valentine's day... blegh*
- Added python script to minify CSS (could be useful for future use)
- Added character counter to Quill formatted posing
- Started working on Content Warning checkboxes
- Quill posts will be managed as "long posts" from now on

### 2024-02-12
- Announcement loader issues fixed (semantic issue in logic)
- Removed `d-none` class label from announcement box, managed with style.display none/block
- Removed `console.log`s used for debugging

### 2024-02-05
- Added content warning columns to post table
- Fixed a previously unknown issue with Quill editor, where users were able to send "empty" posts
- Added follow functionality to TODO list
- Changing password will now invalidate every session

### 2024-01-04
- Basic implementation of [Quill.js](https://github.com/quilljs/quill)

### 2023-11-26
- Share button now works

### 2023-11-03
- Experimenting with database views

### 2023-10-27
- Bumped version number
- Added confirm dialog to logging out an individual session
- Moved backend logic of settings to a separate model file
- Fixed profile pic preview being to small on mobile devices
- Added `INVITE_ONLY` global for later use
    - This will determine of the app is running in *"Invite Only"* mode, blocking sign up
- When updating the details of the profile, the new profile picture will be updated automatically
- Fixed layout issue with mobile navbar at the bottom
  
- Currently WIP features:
    - Private profiles
    - Profile counters
        - No. of posts
        - Following count
        - Follower count

### 2023-10-26
- Users are now able to log out individual sessions
    - TODO: Put it behind an auth thing to prevent malicious actors to log out the legit owner of the account
- Started fixing the generic use modal to use with the `showcustommodal()` JS function all across the app
- Introduced `TODO.md`
- Version number didn't get bumped, as the 0.11.0 "patch" is still incomplete

### 2023-10-22
- Updated settings page so profile updates no longer require the password entered
- Removed profile pictures from repo
- Modified gitignore in /public/res/img/pfps to exclude profile pics, except default

### 2023-10-18
- Somewhat major overhaul of the settings page
    - Rearranged available settings into tabs
    - Added "Active Sessions" Page
    - Changed the colour of the text of the tabs (both active and passive)
- Added `accesschecker` to models that perform actions requiring the user to be logged in with a valid session
- Added `accesschecker->check()` to every controller that requires checking for a valid session
    - Fixed a bug in relation with kicking out the user if the session is invalid
- Changed `php.ini` to allow app to use more RAM
- Removed more `console.log()` and `console.warn()` from the scripts
- Changes related to "comment under post" functionality
    - Comment box under a post is now invisible for guests
    - Moved "comment under post" logic to a separate file
        - `/public/rest/script/commentUnderPost.js`
        - This script doesn't get loaded when the post is viewed by a guest
- When trying to view a post that doesn't exist, a properly formatted warning appears, and nothing falls apart
- Bumped version number
- Changed "catchphrase" of the site on the landing page, when not displaying the "In development" warning


### 2023-09-27
- Added `API.md` as documentation for the API
- Working in `explorepage` in the API
- 2023-10-18: DONE: Cookie value checker
    - Check if the value of the session cookie is valid, not only that it exists

### 2023-09-26
- Added a test API interface

### 2023-09-19
- Fixed an issue with the comment textbox not clearing (forgot to clear it)
- Introduced `SITE_ROOT` variable to define to location of the app in the system
    - Required for fixing problems with the PFP upload stuff
- Fixed the issue where users couldn't upload a new PFP
- Moved JS files to `/public/res/script/`
    - Moved "post page" logic out to a separate file
- Looking for a user that does not exist results in an appropriate error message
- Introduced a rudimentary `Thread View` when opening a post that is actually a reply

### 2023-09-15
- Fixed an error with the comment loading function (I messed up the parentheses n stuff, it works now)
- Removed a few `console.log()` and `console.warn()` lines from JS code
- Removed echoing the query string in the comment manager

### 2023-09-14
- Added an open-source HOTP/TOTP library to source (not used yet): [otphp by Spomky Labs](https://github.com/Spomky-Labs/otphp)
- Added a cookie notice to the landing page so the EU won't be mad
- Updated Privacy Policy to include information about cookies

### 2023-09-05
- Introduced basic commenting functionality (WIP)

### 2023-08-24
- To further improve the "free speech, free press" aspect of our platform, we have introduced the *"Whistleblower's Protection Clause"*

### 2023-08-21
- Started working on comments

### 2023-08-20
- Started working on post display and comment functionality
- Post display on separate page works
- Introduced multi-line in posts

### 2023-07-30
- User settings functionality working, but not thoroughly tested
- Fixed mobile (or small screen) navigation bar to navigate correctly based on context
- Fixed issue with `/user/*` pages, where the site would get overwritten with "the user hasn't posted anything yet" message if the reader scrolled down far enough

### 2023-07-28
- Removed desktop navbar for cleaner design
- Introduced navigation sidebar
- Added mobile navbar for navigation
- Started working on `/user/*` functionality

### 2023-05-04
- Added `DEV` global variable
    - True if the current instance is a development instance
- Added development warning
- Added mail login

### 2023-05-01
- Moved JavaScript from inside homepage to a separate file
- Started working on user settings menu and settings logic
    - 2023-07-30: It is now completed
- Users are unable to post
    - JavaScripts with `<script>` tag
    - Only whitespace posts
- Whitespaces should be trimmed when logging in and signing up

### 2023-04-30
- ***POSTING ACTUALLY WORKS OMG***
- Minor fixes to how posts are presented
- Changed DB collation so emojis, CJK and cyrillic characters are properly stored and supported
- Started working on the settings menu
- Users cannot submit empty posts

### 2023-04-29
- Messing around with styling, fixing stuff
- Introduced "What's on your mind" messages, that are shown randomly each time-
- Apparently, infinite scroll is broken on Firefox, so I'll have to fix that (2023-07-08: it works now)

### 2023-04-28
- Functioning, but very basic infinite scroll (proof-of-concept)
- Fixed a bug introduced in a previous commit that wouldn't let the user log in
    - Login function checked if session id cookie existed and, since the user wasn't logged in, it obviously didn't
- Other minor fixes (see changes)

### 2023-04-26
- Minor code fixes
- Added `timestamp` column to `posts` table
- Home page placeholder posts, infinite scroll basics
- Style changes

### 2023-04-14
- Minor fixes

### 2023-04-13
- Added a few columns to the DB tables
    - Users table got a few additional columns
- Beginnings of the logged in home page
- Added documents
- Login/logout works
- Implemented cookie-based automatic login
- Home page compositor proof-of-concept
- Added #-s to documents for easier reference in links
- Users signing up will have the same display name as their username

### 2023-04-11
- Signup system works
    - Basics included, next step: spam/bot prevention

### 2023-04-10
- Introduced changelog
- Changed .gitignore to exclude database folder (./data)
- Built database (Database.sql)
- Updated docker-compose.yml so now it actually works
- Added connection file to app core
- Added a line to app core, so it actually works properly
- Added custom modal
- Moved "explore" and "sign up" page to "outside/"
