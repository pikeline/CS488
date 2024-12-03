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

$listing = new pg_list(PG_LIST_QUERY, "api_log_id", "api_log_access_time", "DESC", "", "", 1, 5, true, 5, 'even_row_css', 'odd_row_css', 'highlight_css');
$listing->add_column('api_log_id', 'ID');
$listing->add_column('api_log_fk_acc_id', 'API Key');
$listing->add_column('api_log_access_time', 'Timestamp');
$listing->add_column('api_log_ipv4', 'IP', "", "", "", "", false);
$listing->add_column('api_log_query', 'Query', "", "", "", "", false);


$listing->init_list();
?>
<!-- inline css to not break rest of site -->
<table style="border: 1px solid white; padding: 0px; border-spacing: 10px;">
    <thead>
        <tr>
            <th style="border: 1px solid white;">Total Hits</th>
            <th style="border: 1px solid white;">Most Recent Hit</th>
            <th style="border: 1px solid white;">Work Hits</th>
            <th style="border: 1px solid white;">Act Hits</th>
            <th style="border: 1px solid white;">Paragraph Hits</th>
        </tr>
    </thead>
    <tbody>
        <td style="border: 1px solid white;"><?= $hits ?></td>
        <td style="border: 1px solid white;"><?=$most_recent?></td>
        <td style="border: 1px solid white;"><?= $work_hits ?></td>
        <td style="border: 1px solid white;"><?= $act_hits ?></td>
        <td style="border: 1px solid white;"><?= $paragraph_hits ?></td>
    </tbody>
</table>

<?=$listing->get_html()?>
<?php
require_once "framework/ssi_bottom.php";
?>