<?php
$fixed_timer_labels = array(
	'year'		=> array(
		'plural'	=> ( isset( $settings->year_label_plural ) && '' != $settings->year_label_plural ) ? $settings->year_label_plural : 'Years',
		'singular'	=> ( isset( $settings->year_label_singular ) && '' != $settings->year_label_singular ) ? $settings->year_label_singular : 'Year'
	),
	'month'		=> array(
		'plural'	=> ( isset( $settings->month_label_plural ) && '' != $settings->month_label_plural ) ? $settings->month_label_plural : 'Months',
		'singular'	=> ( isset( $settings->month_label_singular ) && '' != $settings->month_label_singular ) ? $settings->month_label_singular : 'Month',
	),
	'day'		=> array(
		'plural'	=> ( isset( $settings->day_label_plural ) && '' != $settings->day_label_plural ) ? $settings->day_label_plural : 'Days',
		'singular'	=> ( isset( $settings->day_label_singular ) && '' != $settings->day_label_singular ) ? $settings->day_label_singular : 'Day',
	),
	'hour'		=> array(
		'plural'	=> ( isset( $settings->hour_label_plural ) && '' != $settings->hour_label_plural ) ? $settings->hour_label_plural : 'Hours',
		'singular'	=> ( isset( $settings->hour_label_singular ) && '' != $settings->hour_label_singular ) ? $settings->hour_label_singular : 'Hour',
	),
	'minute'	=> array(
		'plural'	=> ( isset( $settings->minute_label_plural ) && '' != $settings->minute_label_plural ) ? $settings->minute_label_plural : 'Minutes',
		'singular'	=> ( isset( $settings->minute_label_singular ) && '' != $settings->minute_label_singular ) ? $settings->minute_label_singular : 'Minute',
	),
	'second'	=> array(
		'plural'	=> ( isset( $settings->second_label_plural ) && '' != $settings->second_label_plural ) ? $settings->second_label_plural : 'Seconds',
		'singular'	=> ( isset( $settings->second_label_singular ) && '' != $settings->second_label_singular ) ? $settings->second_label_singular : 'Second',
	)
);
?>

<?php if ( 'default' == $settings->block_style && 'normal_below' == $settings->default_position ) { ?>
	var default_layout =  '';
	<?php if ( 'evergreen' != $settings->timer_type ) { ?>
	default_layout +=  '{y<}'+ '<?php echo $module->render_normal_countdown( '{ynn}', '{yl}' ); ?>' + '{y>}';
	<?php } ?>
		default_layout += '{o<}'+ '<?php echo $module->render_normal_countdown( '{onn}', '{ol}' ); ?>' +
		'{o>}'+
		'{d<}'+ '<?php echo $module->render_normal_countdown( '{dnn}', '{dl}' ); ?>' +
		'{d>}'+
		'{h<}'+ '<?php echo $module->render_normal_countdown( '{hnn}', '{hl}' ); ?>' +
		'{h>}'+
		'{m<}'+ '<?php echo $module->render_normal_countdown( '{mnn}', '{ml}' ); ?>' +
		'{m>}'+
		'{s<}'+ '<?php echo $module->render_normal_countdown( '{snn}', '{sl}' ); ?>' +
		'{s>}';
<?php } elseif ( 'default' == $settings->block_style && 'normal_above' == $settings->default_position ) { ?>

	var default_layout = '';
	<?php if ( 'evergreen' != $settings->timer_type ) { ?>
	default_layout += '{y<}' + '<?php echo $module->render_normal_above_countdown( '{ynn}', '{yl}', '{y>}' ); ?>';
	<?php } ?>
		default_layout += '{o<}' + '<?php echo $module->render_normal_above_countdown( '{onn}', '{ol}', '{o>}' ); ?>' +
		'{d<}' + '<?php echo $module->render_normal_above_countdown( '{dnn}', '{dl}', '{d>}' ); ?>' +
		'{h<}' + '<?php echo $module->render_normal_above_countdown( '{hnn}', '{hl}', '{h>}' ); ?>' +
		'{m<}' + '<?php echo $module->render_normal_above_countdown( '{mnn}', '{ml}', '{m>}' ); ?>' +
		'{s<}' + '<?php echo $module->render_normal_above_countdown( '{snn}', '{sl}', '{s>}' ); ?>';

<?php } elseif ( 'outside' == $settings->label_position && 'out_below' == $settings->label_outside_position ) { ?>
	var default_layout = '';
	<?php if ( 'evergreen' != $settings->timer_type ) { ?>
	default_layout += '{y<}'+ '<?php echo $module->render_normal_countdown( '{ynn}', '{yl}' ); ?>' +
		'{y>}';
	<?php } ?>

	default_layout += '{o<}'+ '<?php echo $module->render_normal_countdown( '{onn}', '{ol}' ); ?>' +
		'{o>}'+
		'{d<}'+ '<?php echo $module->render_normal_countdown( '{dnn}', '{dl}' ); ?>' +
		'{d>}'+
		'{h<}'+ '<?php echo $module->render_normal_countdown( '{hnn}', '{hl}' ); ?>' +
		'{h>}'+
		'{m<}'+ '<?php echo $module->render_normal_countdown( '{mnn}', '{ml}' ); ?>' +
		'{m>}'+
		'{s<}'+ '<?php echo $module->render_normal_countdown( '{snn}', '{sl}' ); ?>' +
		'{s>}';

<?php } elseif ( 'inside' == $settings->label_position && 'in_below' == $settings->label_inside_position ) { ?>

	var default_layout = '';
	<?php if ( 'evergreen' != $settings->timer_type ) { ?>
	default_layout += '{y<}' + '<?php echo $module->render_inside_below_countdown( '{ynn}', '{yl}', '{y>}' ); ?>';
	<?php } ?>

	default_layout += '{o<}' + '<?php echo $module->render_inside_below_countdown( '{onn}', '{ol}', '{o>}' ); ?>' +
		'{d<}' + '<?php echo $module->render_inside_below_countdown( '{dnn}', '{dl}', '{d>}' ); ?>' +
		'{h<}' + '<?php echo $module->render_inside_below_countdown( '{hnn}', '{hl}', '{h>}' ); ?>' +
		'{m<}' + '<?php echo $module->render_inside_below_countdown( '{mnn}', '{ml}', '{m>}' ); ?>' +
		'{s<}' + '<?php echo $module->render_inside_below_countdown( '{snn}', '{sl}', '{s>}' ); ?>';

<?php } elseif ( 'inside' == $settings->label_position && 'in_above' == $settings->label_inside_position ) { ?>

	var default_layout = '';
	<?php if ( 'evergreen' != $settings->timer_type ) { ?>
	default_layout += '{y<}' + '<?php echo $module->render_inside_above_countdown( '{ynn}', '{yl}', '{y>}' ); ?>';
	<?php } ?>
	default_layout += '{o<}' + '<?php echo $module->render_inside_above_countdown( '{onn}', '{ol}', '{o>}' ); ?>' +
		'{d<}' + '<?php echo $module->render_inside_above_countdown( '{dnn}', '{dl}', '{d>}' ); ?>' +
		'{h<}' + '<?php echo $module->render_inside_above_countdown( '{hnn}', '{hl}', '{h>}' ); ?>' +
		'{m<}' + '<?php echo $module->render_inside_above_countdown( '{mnn}', '{ml}', '{m>}' ); ?>' +
		'{s<}' + '<?php echo $module->render_inside_above_countdown( '{snn}', '{sl}', '{s>}' ); ?>';

<?php } elseif ( 'outside' == $settings->label_position && ( 'out_above' == $settings->label_outside_position || 'out_right' == $settings->label_outside_position || 'out_left' == $settings->label_outside_position ) ) { ?>

	var default_layout = '';
	<?php if ( 'evergreen' != $settings->timer_type ) { ?>
	default_layout += '{y<}' + '<?php echo $module->render_outside_countdown( '{ynn}', '{yl}', '{y>}' ); ?>';
	<?php } ?>
	
	default_layout += '{o<}' + '<?php echo $module->render_outside_countdown( '{onn}', '{ol}', '{o>}' ); ?>' +
		'{d<}' + '<?php echo $module->render_outside_countdown( '{dnn}', '{dl}', '{d>}' ); ?>' +
		'{h<}' + '<?php echo $module->render_outside_countdown( '{hnn}', '{hl}', '{h>}' ); ?>' +
		'{m<}' + '<?php echo $module->render_outside_countdown( '{mnn}', '{ml}', '{m>}' ); ?>' +
		'{s<}' + '<?php echo $module->render_outside_countdown( '{snn}', '{sl}', '{s>}' ); ?>';
<?php } ?>

(function ($) {

	new PPCountdown({
		id: '<?php echo $id; ?>',
		fixed_timer_action: '<?php echo $settings->fixed_timer_action; ?>',
		evergreen_timer_action: '<?php echo $settings->evergreen_timer_action; ?>',
		timertype: '<?php echo $settings->timer_type; ?>',
		<?php if ( 'evergreen' == $settings->timer_type ) { ?>
		timer_date: new Date(),
		<?php } else { ?>
		timer_date: new Date( "<?php if ( isset( $settings->fixed_date_year ) ) { echo $settings->fixed_date_year; } ?>", "<?php if ( isset( $settings->fixed_date_month ) ) { echo $settings->fixed_date_month - 1; } ?>", "<?php if ( isset( $settings->fixed_date_days ) ) { echo $settings->fixed_date_days; } ?>", "<?php if ( isset( $settings->fixed_date_hours ) ) { echo $settings->fixed_date_hours; } ?>", "<?php if ( isset( $settings->fixed_date_minutes ) ) { echo $settings->fixed_date_minutes; } ?>" ),
		<?php } ?>
		timer_format: '<?php if ( isset( $settings->show_year ) ) { echo $settings->show_year; } ?><?php if ( isset( $settings->show_month ) ) { echo $settings->show_month; } ?><?php if ( isset( $settings->show_day ) ) { echo $settings->show_day; } ?><?php if ( isset( $settings->show_hour ) ) { echo $settings->show_hour; } ?><?php if ( isset( $settings->show_minute ) ) { echo $settings->show_minute; } ?><?php if ( isset( $settings->show_second ) ) { echo $settings->show_second; } ?>',
		timer_layout: default_layout,
		redirect_link_target: '<?php echo ( '' != $settings->redirect_link_target ) ? $settings->redirect_link_target : ''; ?>',
		redirect_link: '<?php echo ( '' != $settings->redirect_link ) ? $settings->redirect_link : ''; ?>',
		expire_message: '<?php echo ( '' != $settings->expire_message ) ? preg_replace( '/\s+/', ' ', $settings->expire_message ) : ''; ?>',
		timer_labels: '<?php echo $fixed_timer_labels['year']['plural']; ?>,<?php echo $fixed_timer_labels['month']['plural']; ?>,,<?php echo $fixed_timer_labels['day']['plural']; ?>,<?php echo $fixed_timer_labels['hour']['plural']; ?>,<?php echo $fixed_timer_labels['minute']['plural']; ?>,<?php echo $fixed_timer_labels['second']['plural']; ?>',
		timer_labels_singular: 	'<?php echo $fixed_timer_labels['year']['singular']; ?>,<?php echo $fixed_timer_labels['month']['singular']; ?>,,<?php echo $fixed_timer_labels['day']['singular']; ?>,<?php echo $fixed_timer_labels['hour']['singular']; ?>,<?php echo $fixed_timer_labels['minute']['singular']; ?>,<?php echo $fixed_timer_labels['second']['singular']; ?>',
		evergreen_date_days: '<?php echo isset( $settings->evergreen_date_days ) ? $settings->evergreen_date_days : ''; ?>',
		evergreen_date_hours: '<?php echo isset( $settings->evergreen_date_hours ) ? $settings->evergreen_date_hours : ''; ?>',
		evergreen_date_minutes: '<?php echo isset( $settings->evergreen_date_minutes ) ? $settings->evergreen_date_minutes : ''; ?>',
		evergreen_date_seconds: '<?php echo isset( $settings->evergreen_date_seconds ) ? $settings->evergreen_date_seconds : ''; ?>',
		time_zone: '<?php echo $module->get_gmt_difference(); ?>',
		<?php if ( isset( $settings->fixed_timer_action ) && 'msg' == $settings->fixed_timer_action ) { ?>
		timer_exp_text: '<div class="pp-countdown-expire-message">'+ $.cookie( "countdown-<?php echo $id ;?>expiremsg" ) +'</div>'
		<?php } ?>
	});

})(jQuery);
