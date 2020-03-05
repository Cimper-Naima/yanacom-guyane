<?php if ( isset( $settings->event_enable ) && 'yes' == $settings->event_enable ) : ?>
<div class="pp-post-event-calendar-meta">
	<?php if ( isset( $settings->event_date ) && 'yes' == $settings->event_date ) : ?>
		<div class="pp-post-event-calendar-date">
			<?php echo FLPageData::get_value( 'post', 'the_events_calendar_date_and_time' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( isset( $settings->event_venue ) && 'yes' == $settings->event_venue ) : $venue = FLPageData::get_value( 'post', 'the_events_calendar_address' ); ?>
		<?php if ( $venue ) : ?>
			<div class="pp-post-event-calendar-venue">
				<?php echo FLPageData::get_value( 'post', 'the_events_calendar_address' ); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( isset( $settings->event_cost ) && 'yes' === $settings->event_cost && tribe_get_cost() ) : ?>
		<div class="pp-post-event-calendar-cost tribe-events-event-cost">
			<span class="ticket-cost">
				<?php echo tribe_get_cost( null, true ); ?>
			</span>

			<?php do_action( 'tribe_events_inside_cost' ); ?>
		</div>
	<?php endif; ?>
</div>
<?php endif; ?>