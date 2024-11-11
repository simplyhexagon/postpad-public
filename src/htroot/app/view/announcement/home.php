<?php

$announcementID = $params["announceid"];

$this->model("announcement");
$model = new announcementModel();

$values = $model->getDetails($announcementID);

$formattedTime = date("Y-m-d H:i:s", $values["timestamp"]);

?>

<div class="col-xs-12 col-lg-7">
    <div class="card postpad-container textColorOverride">
        <div class="card-header">
            <h1>Announcement</h1>
        </div>
        <div class="card-body">
            <h2><?php echo $values["title"]; ?></h2><hr>
            <?php echo $values["content"]; ?>
        </div>
        <div class="card-footer">
            <?php echo $formattedTime; ?> GMT
        </div>
    </div>
</div>