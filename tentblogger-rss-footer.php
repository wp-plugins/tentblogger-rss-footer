<?php
/*
Plugin Name: TentBlogger Add RSS Footer
Plugin URI: http://tentblogger.com/add-rss-feed
Description: Have you ever wanted to add something to the end of each blog in your RSS feed? This plugin makes it easy!
Version: 2.3
Author: TentBlogger
Author URI: http://tentblogger.com
Author Email: info@tentblogger.com
License:

    Copyright 2011 - 2012 TentBlogger (info@tentblogger.com)

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

/*------------------------------------------------*
 * Core Functions
 *------------------------------------------------*/ 

class TentBlogger_RSS_Footer {

	/*--------------------------------------------*
	 * Constructors and Filters
	 *---------------------------------------------*/

	/**
	 * Initializes the localization context, the administration menu, and the filters for the RSS feed.
	 */
	function __construct() {
	
		if(function_exists('load_plugin_textdomain')) {
			load_plugin_textdomain('tentblogger-rss-footer', false, dirname(plugin_basename(__FILE__)) . '/lang');
		} // end if
	
		if(function_exists('add_action')) {
			add_action('admin_menu', array($this, 'admin'));
		} // end if
		
		if(function_exists('add_filter')) {
			add_filter('the_content', array($this, 'display_rss_footer'));
			add_filter('the_excerpt_rss', array($this, 'display_rss_footer'));
		} // end if
			
	} // end constructor
	
	/*--------------------------------------------*
	 * Functions
	 *---------------------------------------------*/	
	
	/**
	 * Loads the administration stylesheet and adds the administration menu page.
	 */
	function admin() {
		if(function_exists('add_menu_page')) {
      if(!$this->my_menu_exists('tentblogger-handle')) {
        add_menu_page('TentBlogger', 'TentBlogger', 'administrator', 'tentblogger-handle', array($this, 'display'));
      }
      add_submenu_page('tentblogger-handle', 'TentBlogger', 'RSS Footer', 'administrator', 'tentblogger-rss-footer-handle', array($this, 'display'));
		} // end if
	} // end admin
	
	/**
	 * Saves the option based on the contents of the administration form.
	 */
	function configuration() {
		
		$options = get_option('tentblogger-rss-footer');
		
		// if the option isn't set, initialize it...
		if(!isset($options['tentblogger-rss-footer-content'])) {
			$options['tentblogger-rss-footer-content'] = null;
		}
		
		// if we're posting, update the message...
		$is_updated = false;
		if(isset($_POST['submit'])) {
			
			// This must be called in the context of display()
			check_admin_referer('tentblogger-rss-footer', 'tentblogger-rss-footer-admin');
			
			if(isset($_POST['tentblogger-rss-footer-content'])) {
				$rss_footer_message = $_POST['tentblogger-rss-footer-content'];
			} // end if
			$options['tentblogger-rss-footer-content'] = $rss_footer_message;
			
			update_option('tentblogger-rss-footer', $options);
			$is_updated = true;
			
		} // end if/else

		return $is_updated;
		
	} // end configuration
	
	/**
	 * If the current user is an administrator, determine if the configuration has been updated
	 * and display the administration view.
	 */
	function display() {
		if(is_admin()) {
			$is_updated = $this->configuration();
			include_once('views/admin.php');
		} // end if
	} // end display
	
	/**
	 * Displays the content in the footer of the RSS feed.
	 */
	function display_rss_footer($content) {
		
		if(is_feed()) {
		
			global $post;
			$options = get_option('tentblogger-rss-footer');
			$rss_footer_content = trim(stripslashes($options['tentblogger-rss-footer-content']));
			
			$content .= '<div class="tentblogger-rss-footer">';
        $content .= '<hr />';
				$content .= '<p>' . __('You just finished reading', 'tentblogger-rss-footer') . ' <a href="' . $post->guid . '">' . $post->post_title . '</a>! ' . __(' Consider leaving a comment!', 'tentblogger-rss-footer') . '</p>';
				$content .= '<p>' . $rss_footer_content . '</p>';
			$content .= '</div>';
			
		} // end if
		
		return $content;
		
	} // end display_rss_footer
	
	/*--------------------------------------------*
	 * Private Functions
	 *---------------------------------------------*/	
	
	/**
	 * Helper function for registering and loading scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file($name, $file_path, $is_script = false) {
		$url = WP_PLUGIN_URL . $file_path;
		$file = WP_PLUGIN_DIR . $file_path;
		if(file_exists($file)) {
			if($is_script) {
				wp_register_script($name, $url);
				wp_enqueue_script($name);
			} else {
				wp_register_style($name, $url);
				wp_enqueue_style($name);
			} // end if
		} // end if
	} // end _load_file
		
  /**
   * http://wordpress.stackexchange.com/questions/6311/how-to-check-if-an-admin-submenu-already-exists
   */
  private function my_menu_exists( $handle, $sub = false){
    if( !is_admin() || (defined('DOING_AJAX') && DOING_AJAX) )
      return false;
    global $menu, $submenu;
    $check_menu = $sub ? $submenu : $menu;
    if( empty( $check_menu ) )
      return false;
    foreach( $check_menu as $k => $item ){
      if( $sub ){
        foreach( $item as $sm ){
          if($handle == $sm[2])
            return true;
        }
      } else {
        if( $handle == $item[2] )
          return true;
      }
    }
    return false;
  } // end my_menu_exists
  
} // end TentBlogger_RSS_Footer
new TentBlogger_RSS_Footer();
?>