<?php
/**
 * @class PPCoupon
 */
class PPCoupon extends FLBuilderModule {
	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Coupon', 'bb-powerpack' ),
				'description'     => __( 'A module for display coupon layout.', 'bb-powerpack' ),
				'group'           => pp_get_modules_group(),
				'category'        => pp_get_modules_cat( 'content' ),
				'dir'             => BB_POWERPACK_DIR . 'modules/pp-coupon/',
				'url'             => BB_POWERPACK_URL . 'modules/pp-coupon/',
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
				'partial_refresh' => true,
			)
		);
	}
	/**
	 * Returns button link rel based on settings
	 * @since 2.6.9
	 */
	public function get_rel() {
		$rel = array();
		if ( '_blank' === $this->settings->link_url_target ) {
			$rel[] = 'noopener';
		}
		if ( isset( $this->settings->link_url_nofollow ) && 'yes' === $this->settings->link_url_nofollow ) {
			$rel[] = 'nofollow';
		}
		$rel = implode( ' ', $rel );
		if ( $rel ) {
			$rel = ' rel="' . $rel . '" ';
		}
		return $rel;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'PPCoupon',
	array(
		'general'    => array(
			'title'    => __( 'General', 'bb-powerpack' ),
			'sections' => array(
				'disc_coupon' => array(
					'title'  => '',
					'fields' => array(
						'image_select'  => array(
							'type'        => 'photo',
							'label'       => __( 'Image', 'bb-powerpack' ),
							'show_remove' => true,
							'connections' => array( 'photo' ),
						),
						'show_discount' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Discount', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields'   => array( 'discount' ),
									'sections' => array( 'style_discount', 'style_discount_hover', 'discount_typography' ),
								),
							),
						),
						'discount'      => array(
							'type'        => 'text',
							'label'       => __( 'Discount', 'bb-powerpack' ),
							'default'     => '10% OFF',
							'connections' => array( 'string' ),
						),
						'coupon_style'  => array(
							'type'    => 'select',
							'label'   => __( 'Coupon Style', 'bb-powerpack' ),
							'default' => 'copy',
							'options' => array(
								'copy'    => __( 'Click to Copy Code', 'bb-powerpack' ),
								'reveal'  => __( 'Click to Reveal Code and Copy', 'bb-powerpack' ),
								'no_code' => __( 'No Code Needed', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'copy'    => array(
									'fields' => array( 'coupon_code', 'copy_text_color', 'coupon_sep_color', 'copy_text_color_hover', 'coupon_sep_color_hover', 'separator_padding' ),
								),
								'reveal'  => array(
									'fields' => array( 'coupon_reveal', 'coupon_code', 'coupon_reveal_color', 'coupon_reveal_bg', 'reveal_typography', 'copy_text_color', 'coupon_sep_color', 'separator_padding', 'coupon_reveal_color_hover', 'coupon_reveal_bg_hover', 'copy_text_color_hover', 'coupon_sep_color_hover' ),
								),
								'no_code' => array(
									'fields' => array( 'no_code_need' ),
								),
							),
						),
						'coupon_reveal' => array(
							'type'        => 'text',
							'label'       => __( 'Reveal Text', 'bb-powerpack' ),
							'default'     => 'Click to Reveal Coupon Code',
							'connections' => array( 'string' ),
						),
						'coupon_code'   => array(
							'type'        => 'text',
							'label'       => __( 'Coupon Code', 'bb-powerpack' ),
							'default'     => 'ABCDEF',
							'connections' => array( 'string' ),
						),
						'no_code_need'  => array(
							'type'        => 'text',
							'label'       => __( 'No Code Text', 'bb-powerpack' ),
							'default'     => 'No Code Needed',
							'connections' => array( 'string' ),
						),
						'show_icon'     => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Show Icon', 'bb-powerpack' ),
							'default' => 'yes',
							'options' => array(
								'yes' => __( 'Yes', 'bb-powerpack' ),
								'no'  => __( 'No', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'yes' => array(
									'fields'   => array( 'icon_select', 'icon_position' ),
									'sections' => array( 'style_icon' ),
								),
							),
						),
						'icon_select'   => array(
							'type'        => 'icon',
							'label'       => __( 'Icon', 'bb-powerpack' ),
							'default'     => 'dashicons dashicons-before dashicons-tag',
							'show_remove' => true,
						),
						'icon_position' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Icon Position', 'bb-powerpack' ),
							'default' => 'left',
							'options' => array(
								'left'  => __( 'Left', 'bb-powerpack' ),
								'right' => __( 'Right', 'bb-powerpack' ),
							),
						),
					),
				),
				'content'     => array(
					'title'     => __( 'Content', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'title'       => array(
							'type'        => 'text',
							'label'       => __( 'Title', 'bb-powerpack' ),
							'default'     => __( 'Coupon/Offer Details:', 'bb-powerpack' ),
							'connections' => array( 'string' ),
						),
						'description' => array(
							'type'          => 'editor',
							'label'         => __( 'Description', 'bb-powerpack' ),
							'default'       => __( '<ul><li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li><li>Aliquam tincidunt mauris eu risus.</li><li>Vestibulum auctor dapibus neque.</li></ul>', 'bb-powerpack' ),
							'media_buttons' => false,
							'rows'          => 8,
							'connections'   => array( 'string', 'html' ),
						),
					),
				),
				'link'        => array(
					'title'     => __( 'Link', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'link_type' => array(
							'type'    => 'select',
							'label'   => __( 'Link Type', 'bb-powerpack' ),
							'default' => 'button',
							'options' => array(
								'none'   => __( 'Default', 'bb-powerpack' ),
								'button' => __( 'Button', 'bb-powerpack' ),
								'text'   => __( 'Text', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'button' => array(
									'sections' => array( 'style_link', 'style_separator', 'link_typography' ),
									'fields'   => array( 'link_text', 'link_icon', 'button_width', 'button_bg_color', 'button_border', 'button_bg_hover_color', 'button_border_hover', 'link_button_padding' ),
								),
								'text'   => array(
									'sections' => array( 'style_link', 'style_separator', 'link_typography' ),
									'fields'   => array( 'link_text', 'link_icon' ),
								),
							),
						),
						'link_url'  => array(
							'type'          => 'link',
							'label'         => __( 'Link URL', 'bb-powerpack' ),
							'show_target'   => true,
							'show_nofollow' => true,
							'connections'   => array( 'url' ),
							'preview'       => array(
								'type' => 'none',
							),
						),
						'link_text' => array(
							'type'        => 'text',
							'label'       => __( 'Link Text', 'bb-powerpack' ),
							'default'     => __( 'View This Deal', 'bb-powerpack' ),
							'connections' => array( 'string' ),
						),
						'link_icon' => array(
							'type'        => 'icon',
							'label'       => __( 'Icon', 'bb-powerpack' ),
							'show_remove' => true,
							'default'     => 'fa fa-arrow-right',
						),
						'link_icon_pos' => array(
							'type'			=> 'pp-switch',
							'label'			=> __( 'Icon Position', 'bb-powerpack' ),
							'default'		=> 'right',
							'options'		=> array(
								'left'			=> __( 'Left', 'bb-powerpack' ),
								'right'			=> __( 'Right', 'bb-powerpack' ),
							),
						),
					),
				),
			),
		),
		'style'      => array(
			'title'    => __( 'Style', 'bb-powerpack' ),
			'sections' => array(
				'style_box'               => array(
					'title'  => __( 'Box', 'bb-powerpack' ),
					'fields' => array(
						'box_border'  => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'      => 'css',
								'selector'  => '.pp-coupon',
								'important' => true,
							),
						),
						'box_padding' => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => '0',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'content_bg'         => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-content-wrapper',
								'property' => 'background-color',
							),
						),
					),
				),
				'style_discount'          => array(
					'title'     => __( 'Discount ', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'discount_color'    => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-discount',
								'property' => 'color',
							),
						),
						'discount_bg'       => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'default'     => 'ff4949',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-discount',
								'property' => 'background-color',
							),
						),
						'discount_position' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Position', 'bb-powerpack' ),
							'default' => 'left',
							'options' => array(
								'left'  => __( 'Left', 'bb-powerpack' ),
								'right' => __( 'Right', 'bb-powerpack' ),
							),
						),
						'discount_border'   => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'      => 'css',
								'selector'  => '.pp-coupon-discount',
								'important' => true,
							),
						),
						'discount_padding'  => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-discount',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'discount_margin'   => array(
							'type'       => 'dimension',
							'label'      => __( 'Margin', 'bb-powerpack' ),
							'default'    => '0',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-discount',
								'property' => 'margin',
								'unit'     => 'px',
							),
						),
					),
				),
				'style_discount_hover'    => array(
					'title'     => __( 'Discount on Hover', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'discount_color_hover'  => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
						'discount_bg_hover'     => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'default'     => 'ff4949',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
						'discount_border_hover' => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type' => 'none',
							),
						),
					),
				),
				'style_coupon_code'       => array(
					'title'     => __( 'Coupon Code', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'coupon_code_position' => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Position', 'bb-powerpack' ),
							'default' => 'left',
							'options' => array(
								'left'  => __( 'Left', 'bb-powerpack' ),
								'right' => __( 'Right', 'bb-powerpack' ),
							),
						),
						'coupon_code_color'    => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-code-text, .pp-coupon-code-no-code',
								'property' => 'color',
							),
						),
						'coupon_code_bg'       => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'default'     => '003254',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-code',
								'property' => 'background-color',
							),
						),
						'coupon_reveal_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Reveal Text Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
						),
						'coupon_reveal_bg'     => array(
							'type'        => 'color',
							'label'       => __( 'Reveal Text Background Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'default'     => 'ff4949',
							'connections' => array( 'color' ),
						),
						'copy_text_color'      => array(
							'type'        => 'color',
							'label'       => __( 'Copy Text Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-copy-text',
								'property' => 'color',
							),
						),
						'coupon_code_border'   => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'      => 'css',
								'selector'  => '.pp-coupon-code',
								'important' => true,
							),
						),
						'coupon_code_padding'  => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'coupon_code_margin'   => array(
							'type'       => 'dimension',
							'label'      => __( 'Margin', 'bb-powerpack' ),
							'default'    => '0',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-code',
								'property' => 'margin',
								'unit'     => 'px',
							),
						),
						'coupon_sep_color'     => array(
							'type'        => 'color',
							'label'       => __( 'Separator Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
						),
						'separator_padding'    => array(
							'type'       => 'unit',
							'label'      => __( 'Separator Right/Left Padding', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
					),
				),
				'style_coupon_code_hover' => array(
					'title'     => __( 'Coupon Code on Hover', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'coupon_code_color_hover'   => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
						'coupon_code_bg_hover'      => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'default'     => '003254',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
						'coupon_reveal_color_hover' => array(
							'type'        => 'color',
							'label'       => __( 'Reveal Text Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
						'coupon_reveal_bg_hover'    => array(
							'type'        => 'color',
							'label'       => __( 'Reveal Text Background Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'default'     => 'ff4949',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
						'copy_text_color_hover'     => array(
							'type'        => 'color',
							'label'       => __( 'Copy Text Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
						'coupon_sep_color_hover'    => array(
							'type'        => 'color',
							'label'       => __( 'Separator Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
						'coupon_code_border_hover'  => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type' => 'none',
							),
						),
					),
				),
				'style_icon'              => array(
					'title'     => __( 'Coupon Icon ', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'icon_size'        => array(
							'type'       => 'unit',
							'label'      => __( 'Size', 'bb-powerpack' ),
							'default'    => '15',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'icon_spacing'     => array(
							'type'       => 'unit',
							'label'      => __( 'Spacing', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'icon_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-code-icon',
								'property' => 'color',
							),
						),
						'icon_color_hover' => array(
							'type'        => 'color',
							'label'       => __( 'Hover Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type' => 'none',
							),
						),
					),
				),
				'style_content'           => array(
					'title'     => __( 'Content ', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'title_color'        => array(
							'type'        => 'color',
							'label'       => __( 'Title Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => '',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-title',
								'property' => 'color',
							),
						),
						'title_margin'       => array(
							'type'       => 'unit',
							'label'      => __( 'Title Margin Bottom', 'bb-powerpack' ),
							'default'    => '20',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-title',
								'property' => 'margin-bottom',
							),
						),
						'description_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Description Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => '',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-description',
								'property' => 'color',
							),
						),
						'description_margin' => array(
							'type'       => 'unit',
							'label'      => __( 'Description Margin Bottom', 'bb-powerpack' ),
							'default'    => '20',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-description',
								'property' => 'margin-bottom',
							),
						),
						'content_padding'    => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-content-wrapper',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
					),
				),
				'style_link'              => array(
					'title'     => __( 'Link ', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'button_width'          => array(
							'type'    => 'select',
							'label'   => __( 'Button Width', 'bb-powerpack' ),
							'default' => 'auto',
							'options' => array(
								'auto'   => __( 'Auto', 'bb-powerpack' ),
								'custom' => __( 'Custom', 'bb-powerpack' ),
								'full'   => __( 'Full Width', 'bb-powerpack' ),
							),
							'toggle'  => array(
								'custom' => array(
									'fields' => array( 'button_custom_width', 'link_align' ),
								),
								'auto'   => array(
									'fields' => array( 'link_align' ),
								),
							),
						),
						'button_custom_width'   => array(
							'type'       => 'unit',
							'label'      => __( 'Custom Width', 'bb-powerpack' ),
							'default'    => '200',
							'units'      => array( 'px', '%' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-button',
								'property' => 'width',
							),
						),
						'link_align'            => array(
							'type'    => 'pp-switch',
							'label'   => __( 'Alignment', 'bb-powerpack' ),
							'default' => 'left',
							'options' => array(
								'flex-start' => __( 'Left', 'bb-powerpack' ),
								'center'     => __( 'Center', 'bb-powerpack' ),
								'flex-end'   => __( 'Right', 'bb-powerpack' ),
							),
						),
						'link_color'            => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'default'     => 'fff',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-button, .pp-coupon-link-text',
								'property' => 'color',
							),
						),
						'button_bg_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Background Color', 'bb-powerpack' ),
							'default'     => '003254',
							'show_reset'  => true,
							'show_alpha'	=> true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-button',
								'property' => 'background-color',
							),
						),
						'button_border'         => array(
							'type'       => 'border',
							'label'      => __( 'Border', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'      => 'css',
								'selector'  => '.pp-coupon-link-button',
								'important' => true,
							),
						),
						'link_hover_color'      => array(
							'type'        => 'color',
							'label'       => __( 'Hover Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-button:hover',
								'property' => 'color',
							),
						),
						'button_bg_hover_color' => array(
							'type'        => 'color',
							'label'       => __( 'Background Hover Color', 'bb-powerpack' ),
							'default'     => 'e1124d',
							'show_reset'  => true,
							'show_alpha'	=> true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-button:hover',
								'property' => 'background-color',
							),
						),
						'button_border_hover'   => array(
							'type'        => 'color',
							'label'       => __( 'Border Hover Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-button:hover',
								'property' => 'color',
							),
						),
						'link_icon_size'        => array(
							'type'       => 'unit',
							'label'      => __( 'Icon Size', 'bb-powerpack' ),
							'default'    => '15',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-icon',
								'property' => 'font-size',
							),
						),
						'link_icon_spacing'     => array(
							'type'       => 'unit',
							'label'      => __( 'Icon Spacing', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-icon',
								'property' => 'padding-left',
							),
						),
						'link_icon_color'       => array(
							'type'        => 'color',
							'label'       => __( 'Icon Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-icon',
								'property' => 'color',
							),
						),
						'link_icon_hover_color' => array(
							'type'        => 'color',
							'label'       => __( 'Icon Hover Color', 'bb-powerpack' ),
							'show_reset'  => true,
							'default'     => 'fff',
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-text:hover .pp-coupon-link-icon',
								'property' => 'color',
							),
						),
						'link_button_padding'   => array(
							'type'       => 'dimension',
							'label'      => __( 'Padding', 'bb-powerpack' ),
							'default'    => '10',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-button',
								'property' => 'padding',
								'unit'     => 'px',
							),
						),
						'link_margin'           => array(
							'type'       => 'dimension',
							'label'      => __( 'Margin', 'bb-powerpack' ),
							'default'    => '0',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-button',
								'property' => 'margin',
								'unit'     => 'px',
							),
						),
					),
				),
				'style_separator'         => array(
					'title'     => __( 'Separator ', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'separator_width'  => array(
							'type'       => 'unit',
							'label'      => __( 'Width', 'bb-powerpack' ),
							'default'    => '1',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
						),
						'separator_color'  => array(
							'type'        => 'color',
							'label'       => __( 'Color', 'bb-powerpack' ),
							'default'     => 'e8e8e8',
							'show_reset'  => true,
							'connections' => array( 'color' ),
							'preview'     => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-separator',
								'property' => 'border-top-color',
							),
						),
						'separator_margin' => array(
							'type'       => 'unit',
							'label'      => __( 'Margin Bottom', 'bb-powerpack' ),
							'default'    => '20',
							'units'      => array( 'px' ),
							'slider'     => true,
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-separator',
								'property' => 'margin-bottom',
							),
						),
					),
				),
			),
		),
		'typography' => array(
			'title'    => __( 'Typography', 'bb-powerpack' ),
			'sections' => array(
				'discount_typography' => array(
					'title'  => __( 'Discount', 'bb-powerpack' ),
					'fields' => array(
						'discount_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-discount',
							),
						),
					),
				),
				'coupon_typography'   => array(
					'title'     => __( 'Coupon Code', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'coupon_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Coupon Code', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-code',
							),
						),
						'reveal_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Reveal Text', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-code',
							),
						),
						'copy_typography'   => array(
							'type'       => 'typography',
							'label'      => __( 'Copy Text', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-copy-text',
							),
						),
					),
				),
				'content_typography'  => array(
					'title'     => __( 'Content', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'title_typography'       => array(
							'type'       => 'typography',
							'label'      => __( 'Title', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-title',
							),
						),
						'description_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Description', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-description',
							),
						),
					),
				),
				'link_typography'     => array(
					'title'     => __( 'Link', 'bb-powerpack' ),
					'collapsed' => true,
					'fields'    => array(
						'link_typography' => array(
							'type'       => 'typography',
							'label'      => __( 'Typography', 'bb-powerpack' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.pp-coupon-link-text, .pp-coupon-link-button',
							),
						),
					),
				),
			),
		),
	)
);
