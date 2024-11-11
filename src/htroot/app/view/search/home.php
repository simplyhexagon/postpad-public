<div class="col-xs-12 col-lg-7 PostPadDarkElement">
    <div class="card postpad-pretty-container textColorOverride">
        <div class="card-header">
            <h3>Search</h3>
            <div class="btn-group" role="group" aria-label="Select search area">
                <input type="radio" class="btn-check" name="searchSelector" id="userSearch" autocomplete="off" checked  onclick="updatePlaceHolder(1)">
                <label class="btn btn-outline-secondary" for="userSearch">@users</label>

                <input type="radio" class="btn-check" name="searchSelector" id="postSearch" autocomplete="off" onclick="updatePlaceHolder(2)">
                <label class="btn btn-outline-secondary" for="postSearch">Posts</label>
            </div>

            <br>

            <div class="container mt-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchQuery" placeholder="Enter @username..." minlength="3">
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary inlineSearchButton" type="button" onclick="initSearch()"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card-body" id="searchResult">
            <i class="postpad-text bottomMessage"><small>Use the search field above to see results...</small></i>
        </div>
    </div>
    
</div>

<script src="/public/res/script/search.js"></script>