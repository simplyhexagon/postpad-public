# PostPad API access

PostPad API can be accessed at `/appinterface/hsvizu`

The API takes input via the `POST` method as `form-data`

Required parameters:
- appid: Identifier of application/package name (such as `eu.postpad.android`)
- appname: Display name of app/package (`PostPad for Android`)
- accesskey: API access key (150 chars, randomly generated)
- ifaction: *"Interface action"*, the action the app/package wants to call
    - Example: `apitest`

## API functions

When using the API, the application must send all of the above mentioned parameters!

If there aren't enough parameters set, the API can reply with `denied` as response!

### Response on unauthorised access:
`{"called":"(name of function)","response":"denied"}`

### `apitest`
*Tests the API*

- Input params:
    - `ifaction`: `apitest`

Expected response: `{"called":"apitest","response":"ok"}`

### `explorepage`
*Loads post without the user logged in*

Input params:
    - `ifaction`:`explorepage`
    - `offset`: `(numeric value)`
        - This value should be incremented by 20 each time, as the API replies with 20 posts on a single request

*Expected response:*

```json
{
    "called": "explorepage",
    "response": "ok",
    "posts": {
        "(id of post)": {
            "authorid":"(id of post's author)",
            "authoruname":"(username of author)",
            "authordname":"(displayed name of author)",
            "authorpfp":"(path to author's profile picture)",
            "postbody":"(formatted content of post)",
            "timestamp":"(UNIX timestamp of post's creation in GMT)",
            "commentcount":"(number of comments on post)",
            "rtcount":"(number of reposts)",
            "likecount":"(number of likes)",
            "cw_general": "(General Content Warning, 1 if true, 0 if false)",
            "cw_nsfw": "(NSFW Content Warning, 1 if true, 0 if false)",
            "reply_to": "(ID of another post, if this post is a reply to it)"
        }
        "(id of previous post)"{
            // Content of another post
        }
    }
}
```

*Possible error responses:*

- No posts available (possible when fetching a user who hasn't posted anything): `{"called":"explorepage", "response":"error", "error":"noposts"}`
- No more posts available (when the system runs out of posts): `{"called":"explorepage", "response":"error", "error":"nomoreposts"}`
- Internal error: `{"called":"explorepage", "response":"error", "error":"internalerror"}`