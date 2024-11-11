# The *PostPad* project - Public Repo
The publically available source code for PostPad.

This project started as a possible alternative to Twitter, however since I was coding it alone, in my own time, it was practically impossible to make progress,
especially because I have a full-time job outside of the field.

If you'd like to help me add features, add a pull request and I'll see what I can do to merge.

### Licensing

This version of the project is currently distributed under a custom license.
This license, in short is as follows:
- Free access to the source code
- Redistribution and derivative works are ok, but only for free, non-commercial use
- Original project, author/authors have to be mentioned
- Original author only makes the code available to the public, not the IP
- Original author holds the right to monetise the project and be exempt from the non-commercial restriction.


*The project uses external libraries.*

[Quill](https://github.com/slab/quill), by [slab](https://github.com/slab) is distributed under the *BSD 3-Clause "New" or "Revised" License* which allows the following:
- Commercial use
- Modification
- Distribution
- Private use

See more in `LICENSE-Quilljs`

[Bootstrap](https://github.com/twbs/bootstrap) uses the *"MIT License"* which allows the following:
- Commercial use
- Modification
- Distribution
- Private use


[FontAwesome](https://github.com/FortAwesome/Font-Awesome) uses a [custom license](https://fontawesome.com/license/free), called *"Font Awesome Free License"*, which:
- Allows commercial use
- Requires attribution


[otphp](https://github.com/Spomky-Labs/otphp) uses the *"MIT License"* which allows the following:
- Commercial use
- Modification
- Distribution
- Private use

*Please note that `otphp` is currently unused, but included in the code*
*Path to plugin is* `/src/htroot/app/system/plugins/otphp`

### External libraries
*External libraries in the source tree can be found at:*
- FontAwesome (`/src/htroot/public/dist/fontawesome`)
- Quill (`/src/htroot/public/dist/quill`)
- Bootstrap (`/src/htroot/public/dist/bootstrap`)


### Contribution

Standard `git` procedures, creating issues, pull requests, branches if required.
Final code will be merged into `main`

### API

The project contains an API that is NOT final, but a good starting point.

For testing it is currently available at `/appinterface/hsvizu` (random, doesn't mean anything).

Data can be sent to and received from it via `POST` method, and use `form-data`.

(I was testing with PostMan, idk about cURL or others)

### Misc.

I (author of the repo) cannot guarantee that the work will be published any time soon.

I put up this repo for the reason that someone might find it useful and spin up a project from this

For features planned, check `TODO.md`, for the historic changelog, check `CHANGELOG.md`

### Contact
For inquiries or permissions beyond the scope of the license specified in `LICENSE.md`, please contact *Balázs György Markgruber* at:
- Discord: (at) simplyhexagon
- E-mail: balazsgyorgy (at) markgruber (dot) hu .

*In the E-mail subject, or your Discord message please include* "PostPad GitHub" *so your message can be found easier.* 