<?php

namespace Syndicate;
use \Syndicate\ExternalConnection as ExternalConnection;

/**
 * Authentication types extend this base abstract class. Authentication types
 * are used to authenticate push and pull requests for an external connection. Note that static
 * methods are used for interacting with the type whereas class instances deal with
 * an actual external connection.
 */
abstract class Authentication {

	/**
	 * Set associative arguments as instance variables
	 * 
	 * @param array $args
	 * @since 1.0
	 */
	public function __construct( $args ) {
		if ( ! empty( $args ) ) {
			foreach ( $args as $key => $value ) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * Format request args for a GET request so auth occurs
	 * 
	 * @param  array $args
	 * @param  array $context optional array of information about the request
	 * @since  1.0
	 * @return array
	 */
	public function format_get_args( $args, $context = array() ) {
		return apply_filters( 'sy_auth_format_get_args', $args, $context, $this );
	}

	/**
	 * Format request args for a POST request so auth occurs
	 * 
	 * @param  array $args
	 * @param  array $context optional array of information about the request
	 * @since  1.0
	 * @return array
	 */
	public function format_post_args( $args, $context = array() ) {
		return apply_filters( 'sy_auth_format_post_args', $args, $context, $this );
	}

	/**
	 * Output a credentials form in the external connection management screen.
	 *
	 * @since  1.0
	 */
	public abstract static function credentials_form();

	/**
	 * Store an associate array as credentials for use with an external connection.
	 * 
	 * @param  array $args
	 * @since  1.0
	 */
	public abstract static function prepare_credentials( $args );

	/**
	 * Store pre-sanizited auth credentials in DB
	 * 
	 * @param int $external_connection_id
	 * @param array $args
	 * @since 1.0
	 */
	public static function store_credentials( $external_connection_id, $args ) {
		update_post_meta( $external_connection_id, 'sy_external_connection_auth', $args );
	}
}