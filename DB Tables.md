# Current and planned database tables

- Announcements - Visible on the main feed in a small yellow box before the posts
    - id
    - Announcement title (shorter summary)
    - Content of the announcement
    - Timestamp of announcement
    - Invalidation date of the announcement

- Users
    - holds user data
        - id
        - username
        - display name
        - password (encrypted)
        - email address
        - birthday (for age restricted content access)
        - Authenticator code-gen seed (if not NULL, 2FA is enabled)
        - Is user staff member?
        - Is User verifed?
        - Is user limited
        - Is user developer?
        - Is user a supporter
        - Profile picture path (jpeg only, 1M max)
        - Day of signing up
        - Bio
        - Website (custom URL, youtube channel, linktree etc)
        - Is the profile private
        - User timezone

- Follows (keeps track of who follows who, *TODO*) 
    - id of entry
    - User ID of followed
    - User ID of follower

- Post
    - Post ID
    - Post type (short, long, reblog)
    - Posting user
    - Post content
    - Shares
    - Reblogs
    - Views
    - Timestamp
    - General Content Warning Flag
    - NSFW Content Warning Flag
    - "Reply to" ident if post is a reply to another post

- User logins, sessions
    - userid
    - device type (Browser, App)
    - User Agent
    - Session ID (Hashed from username + user agent + ip address)
    - Last login UNIX timestamp
        - If more than 24 hours, invalidate session

- Bans
    - ban id
    - ID of banned user
    - E-mail of banned user (optional)
    - Is the ban permanent?
    - Ban expiry

- Invite codes
    - invite code id
    - Invite Code
    - used flag
    - Who used the code

- Logs
    - id
    - entry type (0 info, 1 warning, 2 error)
    - Logged function
    - Message

- API access
    - api user id
    - App identifier (such as `eu.postpad.android`)
    - App "friendly name" (*"PostPad for Android"*)
    - API access key
    - Owner of API access key



- Post likes *(TODO)*
    - id
    - liked post id
    - id of user who liked the post

- Post media *(TODO)*
    - Post content ID
    - Post media path

