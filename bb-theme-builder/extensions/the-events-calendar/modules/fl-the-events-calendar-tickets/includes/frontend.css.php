<?php if ( ! empty( $settings->bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-tickets-rsvp .tribe-events-tickets {
	background: #<?php echo $settings->bg_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-tickets-rsvp .tribe-events-tickets *:not(input) {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->sep_color ) ) : ?>
.fl-node-<?php echo $id; ?> .tribe-tickets-rsvp .tribe-events-tickets td {
	border-color: #<?php echo $settings->sep_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->btn_bg_color ) ) : ?>
#tribe-events .fl-node-<?php echo $id; ?> .tribe-button {
	background: #<?php echo $settings->btn_bg_color; ?>;
	border: 1px solid #<?php echo FLBuilderColor::adjust_brightness( $settings->btn_bg_color, 12, 'darken' ); ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->btn_text_color ) ) : ?>
#tribe-events .fl-node-<?php echo $id; ?> .tribe-button {
	color: #<?php echo $settings->btn_text_color; ?>;
}
<?php endif; ?>
