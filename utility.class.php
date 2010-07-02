<?php
    if (!class_exists('lbp_utilities')) {

        /**
        * Lightbox Plus Utiltiy Functions used throughout plugin
        * 
        * Not sure if WordPress has equivelents but cannot locate in API docs if so
        */
        class lbp_utilities {
            /**
            * Create clean eols for source
            * 
            * @return string
            */
            function EOL( ) {
                switch ( strtoupper( substr( PHP_OS, 0, 3 ) ) ) {
                    case 'WIN':
                        return "\r\n";
                        break;
                    case 'MAC':
                        return "\r";
                        break;
                    default:
                        return "\n";
                        break;
                }
            }

            /**
            * Create dropdown name from stylesheet listing - make user friendly
            * 
            * @param mixed $styleName
            * @return string
            */
            function setProperName( $styleName ) {
                $styleName = str_replace( '.css', '', $styleName );
                $styleName = ucfirst( $styleName );
                return $styleName;
            }

            /**
            * Convert DB booleans to text for use with JavaScript (jQuery) parameters
            * 
            * @param mixed $nValue
            * @return mixed
            */
            function setBoolean( $nValue ) {
                switch ( $nValue ) {
                    case 1:
                        return 'true';
                        break;
                    default:
                        return 'false';
                        break;
                }
            }

            /**
            * Convert DB booleans to text for use with JavaScript (jQuery) parameters
            * 
            * @param mixed $rValue
            */
            function setValue( $rValue ) {
                if ($rValue == '' || $rValue == 'false') {
                    $tmpValue = 'false';
                } else {
                    $tmpValue = '"'.$rValue.'"';
                }
                return $tmpValue;
            }

            /**
            * Delete directory function used to remove old directories during upgrade from versions prior to 1.4
            * 
            * @param mixed $dirname
            */
            function delete_directory( $dirname ) {
                if ( is_dir( $dirname ) ) {
                    $dir_handle = opendir( $dirname );
                }
                if ( !$dir_handle ) {
                    return false;
                }
                while ( $file = readdir( $dir_handle ) ) {
                    if ( $file != '.' && $file != '..' ) {
                        if ( !is_dir( $dirname.'/'.$file ) ) {
                            unlink( $dirname.'/'.$file );
                        } else {
                            delete_directory( $dirname.'/'.$file );
                        }
                    }
                }
                closedir( $dir_handle );
                rmdir( $dirname );
                return true;
            }

            /**
            * Delete directory function used to remove old directories during upgrade from versions prior to 1.4
            * 
            * @param mixed $dirname
            * @param mixed $file
            */
            function delete_file( $dirname, $file ) {
                if ( $file != '.' && $file != '..' ) {
                    if ( !is_dir( $dirname.'/'.$file ) ) {
                        unlink( $dirname.'/'.$file );
                    }
                    return true;
                }
            }

            /**
            * List directory function used to iterate theme directories
            * 
            * @param mixed $dirname
            */
            function dirList( $dirname ) {
                $types = array(
                'css',
                );
                $results = array( );
                $dir_handle = opendir( $dirname );
                while ( $file = readdir( $dir_handle ) ) {
                    $type = strtolower( substr( strrchr( $file, '.' ), 1 ) );
                    if ( in_array( $type, $types ) ) {
                        array_push( $results, $file );
                    }
                }
                closedir( $dir_handle );
                sort( $results );
                return $results;
            }
        }
    }
?>
