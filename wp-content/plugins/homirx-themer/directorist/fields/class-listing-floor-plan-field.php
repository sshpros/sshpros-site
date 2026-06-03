<?php
/**
 * Directorist Social Info Field class.
 *
 */
namespace Directorist\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class LT_Floor_Plan_Field extends Base_Field {

	public $type = 'lt_floor_plan';

	public function get_value( $posted_data ) {

		if ( ! isset( $posted_data['floor_plan'] ) || ! is_array( $posted_data['floor_plan'] ) ) {
			return array();
		}

		return $posted_data['floor_plan'];
	}

	public function validate( $posted_data ) {
		$items = $this->get_value( $posted_data );

		$items = array_filter( $items, static function( $item ) {
			return ! ( empty( $item['title'] ) || empty( $item['desc'] ) );
		} );

		if ( ! count( $items ) ) {
			$this->add_error( __( 'Invalid Floor Plan info.', 'homirx-themer' ) );
			return false;
		}

		return true;
	}

	public function sanitize( $posted_data ) {
		$_items = $this->get_value( $posted_data );

		$items = array();

		foreach ( $_items as $item ) {
			if ( empty( $item['title'] ) || empty( $item['desc'] ) ) {
				continue;
			}

			$items[] = array(
				'title'  => $item['title'],
				'desc' 	=> ( $item['desc'] ),
				//'image' => sanitize_url( $item['image'] ),
			);
		}

		return $items;
	}
}

//Fields::register( new LT_Floor_Plan_Field() );
