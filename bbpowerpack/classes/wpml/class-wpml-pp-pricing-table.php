<?php
class WPML_PP_Pricing_Table extends WPML_Beaver_Builder_Module_With_Items {

	public function &get_items( $settings ) {
		return $settings->pricing_columns;
	}

	public function get_fields() {
		return array( 'hl_featured_title', 'title', 'price', 'duration', 'features', 'button_text', 'button_url', 'matrix_items' );
	}

	protected function get_title( $field ) {
		switch( $field ) {
			case 'hl_featured_title':
                return esc_html__( 'Pricing Table - Featured Title', 'bb-powerpack' );

            case 'title':
                return esc_html__( 'Pricing Table - Package Title', 'bb-powerpack' );

            case 'price':
                return esc_html__( 'Pricing Table - Price', 'bb-powerpack' );

			case 'duration':
				return esc_html__( 'Pricing Table - Duration', 'bb-powerpack' );

			case 'features':
				return esc_html__( 'Pricing Table - Feature', 'bb-powerpack' );

			case 'button_text':
				return esc_html__( 'Pricing Table - Button Text', 'bb-powerpack' );

			case 'button_url':
				return esc_html__( 'Pricing Table - Button URL', 'bb-powerpack' );

			case 'matrix_items':
				return esc_html__( 'Pricing Table - Matrix Item', 'bb-powerpack' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch( $field ) {
            case 'hl_featured_title':
    		case 'title':
			case 'price':
        	case 'duration':
        	case 'button_text':
                return 'LINE';

            case 'features':
            case 'matrix_items':
                return 'VISUAL';

			case 'button_url':
				return 'LINK';

			default:
				return '';
		}
	}

}
