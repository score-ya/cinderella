<?php
/**
 * RockMongo configuration
 *
 * Defining default options and server configuration
 * @package rockmongo
 */
$MONGO = array();
$MONGO["features"]["log_query"] = "on";//log queries
$MONGO["features"]["theme"] = "default";//theme
$MONGO["features"]["plugins"] = "on";//plugins

$i = 0;

/**
 * Configuration of MongoDB servers
 *
 * @see more details at http://rockmongo.com/wiki/configuration?lang=en_us
 */
$MONGO["servers"][$i]["mongo_name"] = "Localhost";//mongo server name
$MONGO["servers"][$i]["mongo_options"] = [];
$MONGO["servers"][$i]["mongo_host"] = 'mongodb://mongo01.mongo.dev.cinderella';//mongo host
$MONGO["servers"][$i]["mongo_port"] = false;//mongo port
$MONGO["servers"][$i]["mongo_timeout"] = 0;//mongo connection timeout
$MONGO["servers"][$i]["mongo_auth"] = false;//enable mongo authentication?

$MONGO["servers"][$i]["control_auth"] = false;//enable control users, works only if mongo_auth=false
$MONGO["servers"][$i]["control_users"]["admin"] = "admin";//one of control users ["USERNAME"]=PASSWORD, works only if mongo_auth=false

$MONGO["servers"][$i]["ui_only_dbs"] = "";//databases to display
$MONGO["servers"][$i]["ui_hide_dbs"] = "";//databases to hide
$MONGO["servers"][$i]["ui_hide_collections"] = "";//collections to hide
$MONGO["servers"][$i]["ui_hide_system_collections"] = false;//if hide the system collections

