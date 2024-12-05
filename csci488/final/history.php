<?php
$security = true;
require_once "framework/init.php";
require_once "framework/ssi_top.php";
require_once 'framework/class_pageable_list.php';

$hits = api_log::get_total_hits();
$most_recent = api_log::most_recent_hit();
$most_recent = date("m/d/Y", $most_recent);

$work_hits = api_log::get_works();
$act_hits = api_log::get_acts();
$paragraph_hits = api_log::get_paragraphs();

$listing = new pg_list(HIST_LIST_QUERY, "logon_token", "logon_last_access_time", "DESC", "", "", 1, 5, true, 5, 'even_row_css', 'odd_row_css', 'highlight_css');
$listing->add_column('logon_token', 'Token', "", "", "", "", false);
$listing->add_column('acc_email', 'Email');
$listing->add_column('acc_id', 'ID');
$listing->add_column('logon_creation_time', 'Creation Time', "mysql_timestamp_no_seconds", "", "", "", true);
$listing->add_column('logon_last_access_time', 'Last Access Time', "mysql_timestamp_no_seconds", "", "", "", true);
$listing->add_column('logon_ipv4', 'IP', "", "", "", "", false);


$listing->init_list();
?>
<h1>History</h1>
<?=$listing->get_html()?>
<?php
require_once "framework/ssi_bottom.php";
?>