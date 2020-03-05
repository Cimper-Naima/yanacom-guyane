.fl-node-<?php echo $id; ?> .pp-quote-wrap .pp-pullquote-wrapper {
	background: <?php echo ($settings->quote_background) ? '#'.$settings->quote_background : 'transparent'; ?>;
	<?php if( $settings->quote_border_color ) { ?>border-color: #<?php echo $settings->quote_border_color; ?>;<?php } ?>
	<?php if( $settings->quote_border_style ) { ?>border-style: <?php echo $settings->quote_border_style; ?>;<?php } ?>
	<?php if( $settings->quote_border_width['quote_border_top_width'] >= 0 ) { ?>border-top-width: <?php echo $settings->quote_border_width['quote_border_top_width']; ?>px;<?php } ?>
	<?php if( $settings->quote_border_width['quote_border_bottom_width'] >= 0 ) { ?>border-bottom-width: <?php echo $settings->quote_border_width['quote_border_bottom_width']; ?>px;<?php } ?>
	<?php if( $settings->quote_border_width['quote_border_left_width'] >= 0 ) { ?>border-left-width: <?php echo $settings->quote_border_width['quote_border_left_width']; ?>px;<?php } ?>
	<?php if( $settings->quote_border_width['quote_border_right_width'] >= 0 ) { ?>border-right-width: <?php echo $settings->quote_border_width['quote_border_right_width']; ?>px;<?php } ?>
	<?php if( $settings->quote_border_radius >= 0 ) { ?>border-radius: <?php echo $settings->quote_border_radius; ?>px;<?php } ?>
	<?php if( $settings->pullquote_alignment ) { ?>float: <?php echo $settings->pullquote_alignment; ?>;<?php } ?>
	padding-top: <?php echo ( $settings->quote_padding['quote_top_padding'] >= 0 ) ? $settings->quote_padding['quote_top_padding'].'px' : '0'; ?>;
	padding-right: <?php echo ( $settings->quote_padding['quote_right_padding'] >= 0 ) ? $settings->quote_padding['quote_right_padding'].'px' : '0'; ?>;
	padding-bottom: <?php echo ( $settings->quote_padding['quote_bottom_padding'] >= 0 ) ? $settings->quote_padding['quote_bottom_padding'].'px' : '0'; ?>;
	padding-left: <?php echo ( $settings->quote_padding['quote_left_padding'] >= 0 ) ? $settings->quote_padding['quote_left_padding'].'px' : '0'; ?>;
	<?php if( $settings->quote_text_alignment ) { ?>text-align: <?php echo $settings->quote_text_alignment; ?>;<?php } ?>
	<?php if( $settings->pullquote_width >= 0 ) { ?>max-width: <?php echo $settings->pullquote_width; ?>px;<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-title h4 {
	<?php if( $settings->title_color ) { ?>color: #<?php echo $settings->title_color; ?>;<?php } ?>
	<?php if( $settings->title_font['family'] != 'Default' ) { ?><?php FLBuilderFonts::font_css( $settings->title_font ); ?><?php } ?>
	<?php if( $settings->title_font_size['title_font_size_desktop'] >= 0 ) { ?>font-size: <?php echo $settings->title_font_size['title_font_size_desktop']; ?>px;<?php } ?>
	<?php if( $settings->title_line_height['title_line_height_desktop'] >= 0 ) { ?>line-height: <?php echo $settings->title_line_height['title_line_height_desktop']; ?>;<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-content p {
	<?php if( $settings->content_color ) { ?>color: #<?php echo $settings->content_color; ?>;<?php } ?>
	<?php if( $settings->text_font['family'] != 'Default' ) { ?><?php FLBuilderFonts::font_css( $settings->text_font ); ?><?php } ?>
	<?php if( $settings->text_font_size['text_font_size_desktop'] ) { ?>font-size: <?php echo $settings->text_font_size['text_font_size_desktop']; ?>px;<?php } ?>
	<?php if( $settings->text_line_height['text_line_height_desktop'] >= 0 ) { ?>line-height: <?php echo $settings->text_line_height['text_line_height_desktop']; ?>;<?php } ?>
}
<?php if( $settings->show_pullquote_icon == 'yes' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-icon .pp-icon {
		<?php if( $settings->icon_color ) { ?>color: #<?php echo $settings->icon_color; ?>;<?php } ?>
		<?php if( $settings->icon_font_size ) { ?>font-size: <?php echo $settings->icon_font_size; ?>px;<?php } ?>
	}
<?php } ?>

@media only screen and ( max-width: 768px ) {
	.fl-node-<?php echo $id; ?> .pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-title h4 {
		<?php if( $settings->title_font_size['title_font_size_tablet'] >= 0 ) { ?>font-size: <?php echo $settings->title_font_size['title_font_size_tablet']; ?>px;<?php } ?>
		<?php if( $settings->title_line_height['title_line_height_tablet'] >= 0 ) { ?>line-height: <?php echo $settings->title_line_height['title_line_height_tablet']; ?>;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-content p {
		<?php if( $settings->text_font_size['text_font_size_tablet'] ) { ?>font-size: <?php echo $settings->text_font_size['text_font_size_tablet']; ?>px;<?php } ?>
		<?php if( $settings->text_line_height['text_line_height_tablet'] >= 0 ) { ?>line-height: <?php echo $settings->text_line_height['text_line_height_tablet']; ?>;<?php } ?>
	}
}

@media only screen and ( max-width: 480px ) {
	.fl-node-<?php echo $id; ?> .pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-title h4 {
		<?php if( $settings->title_font_size['title_font_size_mobile'] >= 0 ) { ?>font-size: <?php echo $settings->title_font_size['title_font_size_mobile']; ?>px;<?php } ?>
		<?php if( $settings->title_line_height['title_line_height_mobile'] >= 0 ) { ?>line-height: <?php echo $settings->title_line_height['title_line_height_mobile']; ?>;<?php } ?>
	}
	.fl-node-<?php echo $id; ?> .pp-quote-wrap .pp-pullquote-wrapper .pp-pullquote-content p {
		<?php if( $settings->text_font_size['text_font_size_mobile'] ) { ?>font-size: <?php echo $settings->text_font_size['text_font_size_mobile']; ?>px;<?php } ?>
		<?php if( $settings->text_line_height['text_line_height_mobile'] >= 0 ) { ?>line-height: <?php echo $settings->text_line_height['text_line_height_mobile']; ?>;<?php } ?>
	}
}
