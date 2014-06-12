<?php
/**
 * Post By Email Links.
 *
 * @package   Post_By_Email_Links
 * @author    Barry Ceelen <b@rryceelen.com>
 * @license   GPL-2.0+
 * @link      https://github.com/barryceelen/wp-post-by-email-links
 * @copyright 2013 Barry Ceelen
 *
 * @wordpress-plugin
 * Plugin Name: Post By Email Links
 * Plugin URI:  http://wordpress.org/plugins/post-by-email-links/
 * Description: Create new posts with the 'link' post format by sending an email with a URL as the body.
 * Version:     0.0.3
 * Author:      Barry Ceelen
 * Author URI:  https://github.com/barryceelen
 * Text Domain: post-by-email-links
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

/*  Copyright 2013  Barry Ceelen (email : b@rryceelen.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

require_once( plugin_dir_path( __FILE__ ) . 'class-post-by-email-links.php' );
add_action( 'plugins_loaded', array( 'Post_By_Email_Links', 'get_instance' ) );
