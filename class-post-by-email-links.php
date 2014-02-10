<?php
/**
 * Post By Email Links class.
 *
 * @package   Post_By_Email_Links
 * @author    Barry Ceelen <b@rryceelen.com>
 * @license   GPL-2.0+
 * @link      https://github.com/barryceelen/wp-post-by-email-links
 * @copyright 2013 Barry Ceelen
 *
 */

/**
 * Plugin class.
 *
 * @package Post_By_Email_Links
 * @author  Barry Ceelen <b@rryceelen.com>
 */
class Post_By_Email_Links {

	/**
	 * Instance of this class.
	 *
	 * @since    0.0.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 *
	 * @since     0.0.1
	 */
	private function __construct() {
		// Maybe set the post format to 'link'
		add_action( 'publish_phone', array( $this, 'maybe_set_post_format' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 0.0.1
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Set the post format to 'link' if the post content is a URL.
	 *
	 * Only processes the post if the post format has not been set before.
	 *
	 * @since  0.0.1
	 *
	 * @param int $post_id ID of the post
	 * @return int ID of the post
	 * @todo Check for allowed protocols
	 * @todo Sometimes mail programs create a hyperlink when inserting a URL, add check for hyperlink
	 */
	function maybe_set_post_format( $post_id ) {
		if ( false == get_post_format( $post_id ) ) {
			$content = trim( get_post_field( 'post_content', $post_id, 'raw' ) );
			if ( ! strpos( $content, ' ') && $this->is_url( $content ) ) {

				$content = esc_url( $content );

				set_post_format( $post_id, 'link' );

				// Create array for wp_update_post where the URL will be replaced by a link
				$post_arr = array(
					'ID' => $post_id,
					'post_content' => '<a href="' . $content . '">' . $content . '</a>',
				);

				// Allow plugins to do stuff to the content we are about to save
				$post_arr = apply_filters( 'post_by_email_links_before_update_post', $post_arr, $content );

				// Update post
				wp_update_post( $post_arr );

				// Save original url as post_meta, in case we want it later
				add_post_meta( $post_id, 'original_url', $content );
			}
		}

		return $post_id;
	}

	/**
	 * Check if a string is a valid URL according to php's filter_var().
	 *
	 * As the FILTER_VALIDATE_URL filter doesn't seem to like internationalized domain names,
	 * a second pass is added which encodes the string before validation.
	 *
	 * @since  0.0.1
	 *
	 * @param  string
	 * @return boolean|string Returns false if not a valid URL, else returns the URL
	 */
	function is_url( $str ) {
		if ( filter_var( $str, FILTER_VALIDATE_URL ) ) {
			return $str;
		}
		require_once( plugin_dir_path( __FILE__ ) . 'inc/idna_convert.class.php' );
		$idna = new idna_convert( array( 'idn_version' => '2008' ) );
		if ( filter_var( $idna->encode( $str, 'utf8' ), FILTER_VALIDATE_URL ) ) {
			return $str;
		}
		return false;
	}
}
