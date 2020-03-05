<?php

/**
 * Handles logic for page data Advanced Custom Field properties.
 *
 * @since 1.0
 */
final class FLPageDataACF {

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function init() {
		FLPageData::add_group( 'acf', array(
			'label' => __( 'Advanced Custom Fields', 'fl-theme-builder' ),
		) );
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return string
	 */
	static public function string_field( $settings, $property ) {
		$content = '';
		$name    = trim( $settings->name );

		if ( function_exists( 'acf_get_loop' ) && acf_get_loop( 'active' ) ) {
			$object = get_sub_field_object( $name );
		} else {
			$object = get_field_object( $name, self::get_object_id( $property ) );
		}

		if ( empty( $object ) || ! isset( $object['type'] ) ) {
			return $content;
		}

		switch ( $object['type'] ) {
			case 'text':
				$content = self::general_compare( $settings, $object );
				break;
			case 'textarea':
			case 'number':
				$content = self::general_compare( $settings, $object );
				break;
			case 'email':
				$content = self::general_compare( $settings, $object );
				break;
			case 'url':
				$content = self::general_compare( $settings, $object );
				break;
			case 'radio':
				$content = self::general_compare( $settings, $object );
				break;
			case 'password':
			case 'wysiwyg':
			case 'oembed':
			case 'page_link':
			case 'date_time_picker':
			case 'time_picker':
				$content = isset( $object['value'] ) ? $object['value'] : '';
				break;
			case 'checkbox':
				$values = array();

				if ( ! is_array( $object['value'] ) ) {
					break;
				} elseif ( 'text' !== $settings->checkbox_format ) {
					$content .= '<' . $settings->checkbox_format . '>';
				}

				foreach ( $object['value'] as $value ) {
					$values[] = is_array( $value ) ? $value['label'] : $value;
				}

				if ( 'text' === $settings->checkbox_format ) {
					$content = implode( ', ', $values );
				} else {
					$content .= '<li>' . implode( '</li><li>', $values ) . '</li>';
					$content .= '</' . $settings->checkbox_format . '>';
				}
				break;
			case 'select':
				$values    = array();
				$obj_value = (array) $object['value'];

				if ( 'text' !== $settings->select_format ) {
					$content .= '<' . $settings->select_format . '>';
				}

				foreach ( $obj_value as $value ) {
					$values[] = is_array( $value ) ? $value['label'] : $value;
				}

				if ( 'text' === $settings->select_format ) {
					$content = implode( ', ', $values );
				} else {
					$content .= '<li>' . implode( '</li><li>', $values ) . '</li>';
					$content .= '</' . $settings->select_format . '>';
				}
				break;
			case 'date_picker':
				if ( isset( $object['date_format'] ) && ! isset( $object['return_format'] ) ) {
					$format = self::js_date_format_to_php( $object['display_format'] );
					$date   = DateTime::createFromFormat( 'Ymd', $object['value'] );

					// Only pass to format() if vaid date, DateTime returns false if not valid.
					if ( $date ) {
						$content = $date->format( $format );
					} else {
						$content = '';
					}
				} else {
					if ( isset( $settings->format ) && '' !== $settings->format && isset( $object['value'] ) ) {
						$date    = str_replace( '/', '-', $object['value'] );
						$content = date( $settings->format, strtotime( $date ) );
					} else {
						$content = isset( $object['value'] ) ? $object['value'] : '';
					}
				}
				break;
			case 'google_map':
				$value  = isset( $object['value'] ) ? $object['value'] : '';
				$height = ! empty( $object['height'] ) ? $object['height'] : '400';
				if ( ! empty( $value ) && is_array( $value ) && isset( $value['address'] ) ) {
					$address = urlencode( $value['address'] );
					$content = "<iframe src='https://www.google.com/maps/embed/v1/place?key=AIzaSyD09zQ9PNDNNy9TadMuzRV_UsPUoWKntt8&q={$address}' style='border:0;width:100%;height:{$height}px'></iframe>";
				} else {
					$content = '';
				}
				break;
			case 'image':
				$content = self::get_file_url_from_object( $object, $settings->image_size );
				break;
			case 'file':
				$content = self::get_file_url_from_object( $object );
				break;
			case 'true_false':
				$content = ( $object['value'] ) ? '1' : '0';
				break;
			default:
				$content = '';
		}// End switch().
		return is_string( $content ) ? $content : '';
	}

	static public function general_compare( $settings, $object ) {

		if ( ! isset( $settings->exp ) ) {
			return isset( $object['value'] ) ? $object['value'] : '';
		}

		$meta = isset( $object['value'] ) ? untrailingslashit( $object['value'] ) : '';

		$expression = $settings->exp;

		$compare = untrailingslashit( $settings->value );

		switch ( $expression ) {
			case 'less':
				return ( intval( $meta ) < intval( $compare ) ) ? $meta : '';
				break;

			case 'lessequals':
				return ( intval( $meta ) <= intval( $compare ) ) ? $meta : '';
				break;

			case 'greater':
				return ( intval( $meta ) > intval( $compare ) ) ? $meta : '';
				break;

			case 'greaterequals':
				return ( intval( $meta ) >= intval( $compare ) ) ? $meta : '';
				break;

			case 'equals':
				return ( $meta === $compare ) ? $meta : '';
				break;

			case 'notequals':
				return ( $meta !== $compare ) ? $meta : '';
				break;

			default:
				break;
		}
		return $meta;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return string
	 */
	static public function url_field( $settings, $property ) {
		$content = '';
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || $object['type'] != $settings->type ) {
			return $content;
		}

		switch ( $object['type'] ) {
			case 'text':
			case 'url':
			case 'select':
			case 'radio':
			case 'page_link':
				$content = isset( $object['value'] ) ? $object['value'] : '';
				break;
			case 'image':
				$content = self::get_file_url_from_object( $object, $settings->image_size );
				break;
			case 'file':
				$content = self::get_file_url_from_object( $object );
				break;
		}

		return is_string( $content ) ? $content : '';
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return string|array
	 */
	static public function photo_field( $settings, $property ) {
		$content = '';
		if ( isset( $settings->image_fallback_src ) ) {
			$content = $settings->image_fallback_src;
		}
		$object = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || $object['type'] != $settings->type ) {
			return $content;
		}
		switch ( $object['type'] ) {
			case 'text':
			case 'url':
			case 'select':
			case 'radio':
				$content = isset( $object['value'] ) ? $object['value'] : $content;
				break;
			case 'image':
				$id  = self::get_image_id_from_object( $object );
				$url = self::get_file_url_from_object( $object, $settings->image_size );
				if ( $url ) {
					$content = array(
						'id'  => $id,
						'url' => $url,
					);
				}
				break;
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return array
	 */
	static public function multiple_photos_field( $settings, $property ) {
		$content = array();
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || 'gallery' != $object['type'] ) {
			return $content;
		} elseif ( is_array( $object['value'] ) ) {
			foreach ( $object['value'] as $key => $value ) {
				$content[] = $value['id'];
			}
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @param array $property
	 * @return string
	 */
	static public function color_field( $settings, $property ) {
		$content = '';
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || 'color_picker' != $object['type'] ) {
			return $content;
		} else {
			$content = str_replace( '#', '', $object['value'] );
		}

		return $content;
	}

	/**
	 * @since 1.2.1
	 * @param array $property
	 * @return string
	 */
	static public function relational_field( $settings, $property ) {
		$content = '';
		$object  = get_field_object( trim( $settings->name ), self::get_object_id( $property ) );

		if ( empty( $object ) || ! isset( $object['type'] ) || ! in_array( $object['type'], array( 'user', 'post_object' ) ) ) {
			return $content;
		} elseif ( ! empty( $object['value'] ) ) {
			$values = 1 == $object['multiple'] ? $object['value'] : array( $object['value'] );

			if ( 'user' == $object['type'] ) {
				$users = array();
				$name  = '';

				foreach ( $values as $user_data ) {

					if ( is_object( $user_data ) && isset( $user_data->data ) ) {
						$user_data = (array) $user_data->data;
					}

					switch ( $settings->display_type ) {
						case 'display':
							$name = $user_data['display_name'];
							break;

						case 'first':
							$name = $user_data['user_firstname'];
							break;

						case 'last':
							$name = $user_data['user_lastname'];
							break;

						case 'firstlast':
							$first = $user_data['user_firstname'];
							$last  = $user_data['user_lastname'];
							$name  = $first . ' ' . $last;
							break;

						case 'lastfirst':
							$first = $user_data['user_firstname'];
							$last  = $user_data['user_lastname'];
							$name  = $last . ', ' . $first;
							break;

						case 'nickname':
							$name = $user_data['nickname'];
							break;

						case 'username':
							$name = $user_data['user_nicename'];
							break;
					}

					if ( $name && 'yes' == $settings->link ) {
						$url = '';

						if ( 'archive' == $settings->link_type ) {
							$url = get_author_posts_url( $user_data['ID'] );
						} elseif ( 'website' == $settings->link_type ) {
							$url = $user_data['user_url'];
						}

						if ( ! empty( $url ) ) {
							$name = '<a href="' . $url . '">' . $name . '</a>';
						}
					}

					$users[] = $name;
				}

				if ( count( $users ) > 0 ) {
					if ( count( $users ) < 3 ) {
						$content = implode( ' and ', $users );
					} else {
						$last_user = array_pop( $users );
						$content   = implode( ', ', $users ) . ' and ' . $last_user;
					}
				}
			} elseif ( 'post_object' == $object['type'] ) {
				$content = '<ul>';
				foreach ( $values as $post ) {
					$post_id = is_object( $post ) ? $post->ID : $post;

					$href  = get_permalink( $post_id );
					$title = the_title_attribute( array(
						'echo' => false,
						'post' => $post_id,
					) );

					$text = get_the_title( $post_id );

					$content .= "<li class='post-{$post_id}'><a href='{$href}' title='{$title}'>{$text}</a></li>";
				}
				$content .= '</ul>';
			}
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @param array $property
	 * @return string
	 */
	static public function get_object_id( $property ) {
		global $post;

		$id = false;

		if ( 'archive' == $property['object'] ) {
			$location = FLThemeBuilderRulesLocation::get_current_page_location();
			if ( ! empty( $location['object'] ) ) {
				$location = explode( ':', $location['object'] );
				$id       = $location[1] . '_' . $location[2];
			}
		} elseif ( is_object( $post ) && strstr( $property['key'], 'acf_author' ) ) {
			$id = 'user_' . $post->post_author;
		} elseif ( strstr( $property['key'], 'acf_user' ) ) {
			$user = wp_get_current_user();
			if ( $user->ID > 0 ) {
				$id = 'user_' . $user->ID;
			}
		} elseif ( strstr( $property['key'], 'acf_option' ) ) {
			$id = 'option';
		}

		return $id;
	}

	/**
	 * Returns a field object ID by type instead of using
	 * the property array.
	 *
	 * @since 1.1.2
	 * @param string $type
	 * @return string
	 */
	static public function get_object_id_by_type( $type ) {
		$id = false;

		switch ( $type ) {
			case 'archive':
				$id = self::get_object_id( array(
					'object' => 'archive',
					'key'    => 'acf',
				) );
				break;

			case 'post':
				$id = self::get_object_id( array(
					'object' => 'post',
					'key'    => 'acf',
				) );
				break;

			case 'author':
				$id = self::get_object_id( array(
					'object' => 'post',
					'key'    => 'acf_author',
				) );
				break;

			case 'user':
				$id = self::get_object_id( array(
					'object' => 'site',
					'key'    => 'acf_user',
				) );
				break;

			case 'option':
				$id = self::get_object_id( array(
					'object' => 'site',
					'key'    => 'acf_option',
				) );
				break;
		}

		return $id;
	}

	/**
	 * @since 1.0
	 * @param array $object
	 * @param string $size
	 * @return string
	 */
	static public function get_file_url_from_object( $object, $size = 'thumbnail' ) {
		$url    = '';
		$format = self::get_object_return_format( $object );

		if ( $format && isset( $object['value'] ) ) {

			if ( 'array' == $format || 'object' == $format ) {

				if ( isset( $object['value']['sizes'] ) && isset( $object['value']['sizes'][ $size ] ) ) {
					$url = $object['value']['sizes'][ $size ];
				} elseif ( $object['value']['url'] ) {
					$url = $object['value']['url'];
				}
			} elseif ( 'url' == $format ) {
				$url = $object['value'];
			} elseif ( 'id' == $format ) {
				if ( 'image' == $object['type'] ) {
					$data = wp_get_attachment_image_src( $object['value'], $size );
					$url  = $data[0];
				} elseif ( 'file' == $object['type'] ) {
					$url = wp_get_attachment_url( $object['value'] );
				}
			}
		}

		return $url;
	}

	/**
	 * @since 1.0
	 * @param array $object
	 * @return int
	 */
	static public function get_image_id_from_object( $object ) {
		$id     = null;
		$format = self::get_object_return_format( $object );

		if ( $format && isset( $object['value'] ) ) {

			if ( 'array' == $format ) {
				$id = $object['value']['ID'];
			} elseif ( 'object' == $format ) {
				$id = $object['value']['id'];
			} elseif ( 'id' == $format ) {
				$id = $object['value'];
			}
		}

		return $id;
	}

	/**
	 * @since 1.0
	 * @param array $object
	 * @return int
	 */
	static public function get_object_return_format( $object ) {
		$format = false;

		if ( isset( $object['return_format'] ) ) {
			$format = $object['return_format'];
		} elseif ( isset( $object['save_format'] ) ) {
			$format = $object['save_format'];
		}

		return $format;
	}

	/**
	 * Converts a JS date format to a PHP date format.
	 * Needed because ACF 4 stores the date format in
	 * the JS format /shrug.
	 *
	 * @since 1.0
	 * @param string $format
	 * @return string
	 */
	static public function js_date_format_to_php( $format ) {

		$symbols = array(
			// Day
			'dd' => '{1}', // d
			'DD' => 'l',
			'd'  => 'j',
			'o'  => 'z',
			// Month
			'MM' => 'F',
			'mm' => '{2}', // m
			'm'  => 'n',
			// Year
			'yy' => 'Y',
		);

		foreach ( $symbols as $js => $php ) {
			$format = str_replace( $js, $php, $format );
		}

		$format = str_replace( '{1}', 'd', $format );
		$format = str_replace( '{2}', 'm', $format );

		return $format;
	}
}

FLPageDataACF::init();
