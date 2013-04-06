<!-- This file is used to markup the public-facing widget. -->
<?php

// echo "<pre>".print_r($live_message,true)."</pre>";

if ($time_left) {
	$days = $time_left->format('%a');
	$hours = $time_left->format('%h');
	$minutes = $time_left->format('%i');
	$seconds = $time_left->format('%s');
}

if ( ! empty( $event ) )
    echo $before_title . $event . $after_title;
if ( ! empty( $band_name ) )
    echo '<span class="jw_event_band_name">'.$band_name.'</span>';
if ( ! empty( $time_left ) ) :?>

	<span <?= $live_message ? "data-livemessage='".esc_attr($live_message)."'" : "" ?> class='jw_widget_event_time'>
		<?php if ($days): ?>
			<span class='jw_widget_event_time_days'><?= $days ?></span> days
		<?php endif ?>
		<?php if ($hours): ?>
			<span class='jw_widget_event_time_hours'><?= $hours ?></span> hrs
		<?php else: ?>
			<span>Live in: </span>
		<?php endif ?>
		<?php if ($minutes): ?>
			<span class='jw_widget_event_time_minutes'><?= $minutes ?></span> mins
		<?php endif ?>
		<?php if ($seconds): ?>
			<span class='jw_widget_event_time_seconds'><?= $seconds ?></span> secs
		<?php endif ?>
		</span>

	<?php
	endif;
?>
<?php if ($date_passed && ! empty($live_message)): ?>
	<span <?= $live_message ? "data-livemessage='".esc_attr($live_message)."'" : "" ?> class="jw_widget_event_time"><?= $live_message ?></span>
<?php endif ?>