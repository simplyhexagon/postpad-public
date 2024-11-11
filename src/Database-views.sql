-- Run this only after creating content for the `api_access` table, and update it daily
CREATE VIEW `apikeys` AS
SELECT id, appid, appname, accesskey, owner FROM `api_access`
WHERE id > 0;

-- Run this, then run the previous command again to update view
-- DROP VIEW `apikeys`;