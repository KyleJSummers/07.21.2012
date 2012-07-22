<?php

// oh.php
// Displays available office hours

include 'inc/header.php';

// include db credentials
include 'inc/db.php';

// check for active office hours that user is able to access
$link = mysql_connect($db['host'] . ':' . $db['port'], $db['user'], $db['pass']);

$pref = $db['pref'];

$san_user = mysql_real_escape_string($user, $link);

$query = "SELECT {$pref}office_hours.id, {$pref}office_hours.name FROM {$pref}permissions, {$pref}office_hours WHERE {$pref}permissions.user='$san_user' AND {$pref}permissions.level = 1 AND {$pref}permissions.course = {$pref}office_hours.course";

mysql_select_db($db['name'], $link);

$result = mysql_query($query, $link) or die(mysql_error());

if( mysql_num_rows($result) === 0 )
{
	echo 'No office hours are currently available for any of your courses.';
}
else {
	echo 'The following office hours are currently available for you:<br /><br />';
	while ( $row = mysql_fetch_assoc($result) )
	{
		echo '<div class="well">
						<h3>' . $row['name'] . '</h3>
						Current queue: <span class="queue-count" id="queue-' . $row['id'] . '-count">0</span><br /><br />
						<a id="join-queue-' . $row['id'] . '" class="btn btn-primary join-queue"><i class="icon-plus icon-white"></i> Join Queue</a>
						<a id="leave-queue-' . $row['id'] . '" class="btn btn-danger leave-queue hidden"><i class="icon-minus icon-white"></i> Leave Queue</a>
					</div>';
	}
	
	$js_scripts = <<<EOD
<script>
var queue_count = Array();
queue_count[1] = 0;

$(function() {
	// if I had more time, I'd definitely use AngularJS for all of this
	$(".join-queue").click( function () {
		var oh_id = $(this).attr('id').split('-')[2];
		queue_count[oh_id]++;
		$("#queue-" + oh_id + "-count").text( queue_count[oh_id] );
		
		$(this).addClass('hidden');
		$(this).next('.leave-queue').removeClass('hidden');
	});
	
	$(".leave-queue").click( function () {
		var oh_id = $(this).attr('id').split('-')[2];
		queue_count[oh_id]--;
		$("#queue-" + oh_id + "-count").text( queue_count[oh_id] );
	
		$(this).addClass('hidden');
		$(this).prev('.join-queue').removeClass('hidden');
	});
});
</script>
EOD;
	
}

mysql_close($link);

include 'inc/footer.php';

?>