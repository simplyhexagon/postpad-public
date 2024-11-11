# To-do list
## Updated 2024-05-08

### Top priority
- Account and post search
- Liking posts
- Follow functionality
- "Retweeting" posts
    - Standalone RT
    - QRT
- "Remember me" on login
    - Either 30 day or infinite
- Maximum post display height, and "Read more" button
- Account recovery method

### "Middle" priority
- More work on Quill input
- Share images and videos
- Hyperlink shortening and previews
- Timezone setting
- Muting/blocking
- Invite code processing
- Invite code sharing and account association
    - Who has the invite code
    - Who used that invite code, if it got used

### Not quite important
- Share button popup on desktop ("Link copied to clipboard")

# Microservices for real-time events
- Direct Messaging
- Notifications

# DONE
- Share button
    - Copy post URL to clipboard in *some way*
    - Currently no alert on desktop, will update in the future

- Add formatted posting feature with Quill
    - Basic implementation, will work a bit more on it later
    
- Public announcement box
    - Between the posting box and the post list on the home page

- Post "flairing": Users can now mark their posts as having a general content warning, or the post being not safe for work

- Create database "views" for somewhat persistent elements, like API access entries
    - Lighten load on database
    - *This has already been created, check `Database-views.sql`