<?php
$quote_class = 'pp-quote-wrap';
?>
<div class="<?php echo $quote_class; ?>">
	<div class="pp-pullquote-wrapper clearfix">
		<?php if( $settings->show_pullquote_icon == 'yes' ) { ?>
			<div class="pp-pullquote-icon">
				<span class="pp-icon <?php echo $settings->pullquote_icon; ?>"></span>
			</div>
		<?php } ?>
		<div class="pp-pullquote-inner">
			<div class="pp-pullquote-content">
				<p><?php echo $settings->pullquote_content; ?></p>
			</div>
			<div class="pp-pullquote-title">
				<h4><?php echo $settings->pullquote_title; ?></h4>
			</div>
		</div>
	</div>
</div>
