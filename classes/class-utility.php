<?php
/**
 * @package    Lightbox Plus Colorbox
 * @subpackage class-utility.php
 * @internal   2013.01.16
 * @author     Dan Zappone / 23Systems
 * @version    2.7
 * @$Id: class-utility.php 983793 2014-09-07 19:22:57Z dzappone $
 * @$URL: http://plugins.svn.wordpress.org/lightbox-plus/trunk/classes/class-utility.php $
 */

if ( ! interface_exists( 'LBP_Utilities_Interface' ) ) {
	interface LBP_Utilities_Interface {
		/**
		 * @param $style_name
		 *
		 * @return mixed
		 */
		function set_proper_name( $style_name );

		/**
		 * @param $loadlocation
		 *
		 * @return mixed
		 */
		function set_load_location( $loadlocation );

		/**
		 * @param $ar_lbp_options
		 *
		 * @return mixed
		 */
		function set_missing_options( $ar_lbp_options );

		/**
		 * @param $num_value
		 *
		 * @return mixed
		 */
		function set_boolean( $num_value );

		/**
		 * @param $directory
		 *
		 * @return mixed
		 */
		function delete_directory( $directory );

		/**
		 * @param $directory
		 * @param $file
		 *
		 * @return mixed
		 */
		function delete_file( $directory, $file );

		/**
		 * @param $directory
		 *
		 * @return mixed
		 */
		function directory_list( $directory );

		/**
		 * @param array $array
		 * @param       $left
		 * @param       $right
		 *
		 * @return mixed
		 */
		function lbp_array_trim( $array, $num_to_trim );

		/**
		 * @param $source
		 * @param $destination
		 *
		 * @return mixed
		 */
		function copy_directory( $source, $destination );

		/**
		 * @return mixed
		 */
		function post_thumbnail_caption();

		/**
		 * @param $json
		 *
		 * @return mixed
		 */
		function json_pretty( $json );
	}
}

if ( ! class_exists( 'LBP_Utilities' ) ) {

	/**
	 * Lightbox Plus Colorbox Utiltiy Functions used throughout plugin
	 *
	 * Not sure if WordPress has equivelents but cannot locate in API docs if so
	 */
	class LBP_Utilities implements LBP_Utilities_Interface {
		/**
		 * Create dropdown name from stylesheet listing - make user friendly
		 *
		 * @param mixed $style_name
		 *
		 * @return string
		 */
		function set_proper_name( $style_name ) {
			$style_name = str_replace( '.css', '', $style_name );

			return ucfirst( $style_name );
		}

		function set_load_location( $loadlocation ) {
			if ( $loadlocation == 'wp_head' ) {
				return false;
			} else {
				return true;
			}
		}

		function switch_boolean_get( $name ) {
			if ( isset( $name ) ) {
				return $name;
			} else {
				return false;
			}
		}

		/**
		 * @param $ar_lbp_options
		 *
		 * @return mixed
		 */
		function set_missing_options( $ar_lbp_options ) {
			/**
			 * Remove following 3 lines after a few versions or 2.6 is the prevelent version
			 */
			if ( ! isset( $ar_lbp_options['output_htmlv'] ) || ( array_key_exists( 'output_htmlv', $ar_lbp_options ) == false ) ) {
				$ar_lbp_options['output_htmlv'] = '0';
				$ar_lbp_options['data_name']    = 'lightboxplus';
			}
			if ( ! isset( $ar_lbp_options['load_location'] ) || ( array_key_exists( 'load_location', $ar_lbp_options ) == false ) ) {
				$ar_lbp_options['load_location'] = 'wp_footer';
			}
			if ( ! isset( $ar_lbp_options['load_priority'] ) || ( array_key_exists( 'load_priority', $ar_lbp_options ) == false ) ) {
				$ar_lbp_options['load_priority'] = '10';
			}

			return $ar_lbp_options;
		}

		/**
		 * Convert DB booleans to text for use with JavaScript (jQuery) parameters
		 *
		 * @param $num_value
		 *
		 * @return string
		 */
		function set_boolean( $num_value ) {
			if ( 1 == $num_value ) {
				return 'true';
			} else {
				return 'false';
			}
		}

		/**
		 * Convert DB booleans to text for use with JavaScript (jQuery) parameters
		 *
		 * @param $st_value
		 *
		 * @return string
		 */
		function set_value( $st_value ) {
			if ( $st_value == '' || $st_value == 'false' ) {
				return 'false';
			} else {
				return '"' . $st_value . '"';
			}
		}

		/**
		 * Delete directory function used to remove old directories during upgrade from versions prior to 1.4
		 *
		 * @param $directory
		 *
		 * @return bool
		 */
		function delete_directory( $directory ) {
			if ( is_dir( $directory ) ) {
				$directory_handle = opendir( $directory );
			}
			if ( ! isset( $directory_handle ) ) {
				return false;
			}
			while ( $file = readdir( $directory_handle ) ) {
				if ( $file != '.' && $file != '..' ) {
					if ( ! is_dir( $directory . '/' . $file ) ) {
						unlink( $directory . '/' . $file );
					} else {
						$this->delete_directory( $directory . '/' . $file );
					}
				}
			}
			closedir( $directory_handle );
			rmdir( $directory );

			return true;
		}

		/**
		 * Delete directory function used to remove old directories during upgrade from versions prior to 1.4
		 *
		 * @param $directory
		 * @param $file
		 *
		 * @return bool
		 */
		function delete_file( $directory, $file ) {
			if ( $file != '.' && $file != '..' ) {
				if ( ! is_dir( $directory . '/' . $file ) ) {
					unlink( $directory . '/' . $file );
				}

				return true;
			}
		}

		/**
		 * List directory function used to iterate theme directories
		 *
		 * @param $directory
		 *
		 * @return array
		 */
		function directory_list( $directory ) {
			$types            = array(
				'css',
			);
			$results          = array();
			$directory_handle = opendir( $directory );
			while ( $file = readdir( $directory_handle ) ) {
				$type = strtolower( substr( strrchr( $file, '.' ), 1 ) );
				if ( in_array( $type, $types ) ) {
					array_push( $results, $file );
				}
			}
			closedir( $directory_handle );
			sort( $results );

			return $results;
		}

		/**
		 * @param array $array
		 * @param       $old_num
		 * @param       $new_num
		 *
		 * @return mixed
		 */
		function lbp_array_trim( $array, $num_to_trim ) {
			for ( $i = 1; $i <= $num_to_trim; $i ++ ) {
				array_pop( $array );
			}

			return $array;
		}

		/**
		 * Recursively copy a directory
		 *
		 * @param $source
		 * @param $destination
		 */
		function copy_directory( $source, $destination ) {
			if ( is_dir( $source ) ) {
				@mkdir( $destination );
				$directory = dir( $source );
				while ( false !== ( $read_directory = $directory->read() ) ) {
					if ( $read_directory == '.' || $read_directory == '..' ) {
						continue;
					}
					$directory_path = $source . '/' . $read_directory;
					if ( is_dir( $directory_path ) ) {
						$this->copy_directory( $directory_path, $destination . '/' . $read_directory );
						continue;
					}
					copy( $directory_path, $destination . '/' . $read_directory );
				}

				$directory->close();
			} else {
				copy( $source, $destination );
			}
		}

		/**
		 * @return mixed
		 */
		function post_thumbnail_caption() {
			extract( shortcode_atts( array(
				'id'      => '',
				'align'   => 'alignnone',
				'width'   => '',
				'caption' => ''
			), $attr ) );

			return $caption;
		}

		/**
		 * Indents a flat JSON string to make it more human-readable.
		 * Function used instead of JSON_PRETTY_PRINT to support versions of PHP older than 5.4
		 * Original function by Dave Perrett
		 *
		 * @param $json
		 *
		 * @return string
		 */
		function json_pretty( $json ) {

			$formatted_json = '';
			$position         = 0;
			$prev_character   = '';
			$end_of_quotes    = true;

			for ( $i = 0; $i <= strlen( $json ); $i ++ ) {
				$character = substr( $json, $i, 1 );

				if ( $character == '"' && $prev_character != '\\' ) {
					$end_of_quotes = ! $end_of_quotes;
				} else if ( ( $character == '}' || $character == ']' ) && $end_of_quotes ) {
					$formatted_json .= PHP_EOL;
					$position --;
					for ( $j = 0; $j < $position; $j ++ ) {
						$formatted_json .= '  ';
					}
				}

				$formatted_json .= $character;

				if ( ( $character == ',' || $character == '{' || $character == '[' ) && $end_of_quotes ) {
					$formatted_json .= PHP_EOL;
					if ( $character == '{' || $character == '[' ) {
						$position ++;
					}

					for ( $j = 0; $j < $position; $j ++ ) {
						$formatted_json .= '  ';
					}
				}

				$prev_character = $character;
			}

			return $formatted_json;
		}
	}
}