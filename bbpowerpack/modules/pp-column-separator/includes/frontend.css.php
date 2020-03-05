.fl-node-<?php echo $id; ?> .pp-column-separator .pp-zigzag:before,
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-zigzag:after {
	height: <?php echo $settings->separator_height; ?>px;
}

<?php if( $settings->separator_position == 'top' ) { ?>
.fl-node-<?php echo $id; ?> .pp-column-separator-wrap {
	bottom: auto;
	top: 0;
}
.fl-node-<?php echo $id; ?> .pp-column-separator-wrap.pp-side-separator {
	bottom: 0;
	top: 0;
}
.fl-node-<?php echo $id; ?> .pp-column-separator svg {
	bottom: auto;
	top: 0;
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-large-triangle-left,
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-tilt-left-separator {
	-webkit-transform: scaleY(-1);
	-moz-transform: scaleY(-1);
	-o-transform: scaleY(-1);
	-ms-transform: scaleY(-1);
	transform: scaleY(-1);
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-tilt-right-separator,
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-large-triangle-right {
	-webkit-transform: scale(-1);
	-moz-transform: scale(-1);
	-o-transform: scale(-1);
	-ms-transform: scale(-1);
	transform: scale(-1);
}

.fl-node-<?php echo $id; ?> .pp-column-separator .pp-zigzag:before {
	background-image: -webkit-gradient(linear, 0 0, 300% 100%, color-stop(0.25, rgba(0, 0, 0, 0)), color-stop(0.25, #<?php echo $settings->separator_color; ?>));
	background-image: linear-gradient(315deg, #<?php echo $settings->separator_color; ?> 25%, rgba(0, 0, 0, 0) 25%), linear-gradient(45deg, #<?php echo $settings->separator_color; ?> 25%, rgba(0, 0, 0, 0) 25%);
	background-position: 50%;
	top: -90px;
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-zigzag:after {
	height: 0;
}
<?php } ?>

<?php if( $settings->separator_position == 'bottom' ) { ?>
.fl-node-<?php echo $id; ?> .pp-column-separator-wrap {
	bottom: 0;
	top: auto;
}
.fl-node-<?php echo $id; ?> .pp-column-separator-wrap.pp-side-separator {
	bottom: 0;
	top: 0;
}
.fl-node-<?php echo $id; ?> .pp-column-separator svg {
	bottom: 0;
	top: auto;
	-webkit-transform: scaleY(-1);
	-moz-transform: scaleY(-1);
	-o-transform: scaleY(-1);
	-ms-transform: scaleY(-1);
	transform: scaleY(-1);
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-large-triangle-left {
	-webkit-transform: scaleY(1);
	-moz-transform: scaleY(1);
	-o-transform: scaleY(1);
	-ms-transform: scaleY(1);
	transform: scaleY(1);
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-tilt-right-separator {
	-webkit-transform: scaleX(-1);
	-moz-transform: scaleX(-1);
	-o-transform: scaleX(-1);
	-ms-transform: scaleX(-1);
	transform: scaleX(-1);
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-large-triangle-right {
	-webkit-transform: scaleX(-1);
	-moz-transform: scaleX(-1);
	-o-transform: scaleX(-1);
	-ms-transform: scaleX(-1);
	transform: scaleX(-1);
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-tilt-left-separator {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-o-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-zigzag:before {
	height: 0;
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-zigzag:after {
	background-image: -webkit-gradient(linear, 0 0, 300% 100%, color-stop(0.25, #<?php echo $settings->separator_color; ?>), color-stop(0.25, #<?php echo $settings->separator_color; ?>));
	background-image: linear-gradient(135deg, #<?php echo $settings->separator_color; ?> 25%, rgba(0, 0, 0, 0) 25%), linear-gradient(225deg, #<?php echo $settings->separator_color; ?> 25%, rgba(0, 0, 0, 0) 25%);
	background-position: 50%;
	top: 100%;
}
<?php } ?>

<?php if( $settings->separator_type == 'triangle_shadow' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-column-separator .pp-large-triangle-shadow .pp-shadow-color {
		<?php if( $settings->separator_shadow_color ) { ?>fill: #<?php echo $settings->separator_shadow_color; ?>;<?php } ?>
	}
<?php } ?>

.fl-node-<?php echo $id; ?> .pp-column-separator svg {
	<?php if( $settings->separator_color ) { ?>fill: #<?php echo $settings->separator_color; ?>;<?php } ?>
	<?php if( $settings->separator_height ) { ?>height: <?php echo $settings->separator_height; ?>px;<?php } ?>
}
.fl-node-<?php echo $id; ?> .pp-column-separator .pp-zigzag:before {
	top: -<?php echo $settings->separator_height; ?>px;
}

<?php if( $settings->separator_type == 'triangle_left_side' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-column-separator svg.pp-side-triangle {
		<?php if( $settings->separator_height ) { ?>left: -<?php echo $settings->separator_height; ?>px;<?php } ?>;
		<?php if( $settings->separator_height ) { ?>width: <?php echo $settings->separator_height; ?>px;<?php } ?>;
		-webkit-transform: scaleX(-1);
		-moz-transform: scaleX(-1);
		-o-transform: scaleX(-1);
		-ms-transform: scaleX(-1);
		transform: scaleX(-1);
	}
<?php } ?>
<?php if( $settings->separator_type == 'triangle_right_side' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-column-separator svg.pp-side-triangle {
		<?php if( $settings->separator_height ) { ?>right: -<?php echo $settings->separator_height; ?>px;<?php } ?>;
		<?php if( $settings->separator_height ) { ?>width: <?php echo $settings->separator_height; ?>px;<?php } ?>;
		-webkit-transform: scaleX(1);
		-moz-transform: scaleX(1);
		-o-transform: scaleX(1);
		-ms-transform: scaleX(1);
		transform: scaleX(1);
	}
<?php } ?>

<?php if( $settings->separator_type == 'big_triangle_left' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-column-separator-wrap.pp-big-side-separator {
		left: 0;
		right: auto;
	}
	.fl-node-<?php echo $id; ?> .pp-column-separator svg.pp-big-triangle-side {
		<?php if( $settings->separator_height ) { ?>height: <?php echo $settings->separator_height; ?>px;<?php } ?>;
		left: 0;
		top: 50%;
		-webkit-transform: translate(-50%, -50%) rotate(270deg);
		-moz-transform: translate(-50%, -50%) rotate(270deg);
		-o-transform: translate(-50%, -50%) rotate(270deg);
		-ms-transform: translate(-50%, -50%) rotate(270deg);
		transform: translate(-50%, -50%) rotate(270deg);
	}
<?php } ?>
<?php if( $settings->separator_type == 'big_triangle_right' ) { ?>
	.fl-node-<?php echo $id; ?> .pp-column-separator-wrap.pp-big-side-separator {
		left: auto;
		right: 0;
	}
	.fl-node-<?php echo $id; ?> .pp-column-separator svg.pp-big-triangle-side {
		<?php if( $settings->separator_height ) { ?>height: <?php echo $settings->separator_height; ?>px;<?php } ?>;
		right: 0;
		top: 50%;
		-webkit-transform: translate(50%, -50%) rotate(90deg);
		-moz-transform: translate(50%, -50%) rotate(90deg);
		-o-transform: translate(50%, -50%) rotate(90deg);
		-ms-transform: translate(50%, -50%) rotate(90deg);
		transform: translate(50%, -50%) rotate(90deg);
	}
<?php } ?>
