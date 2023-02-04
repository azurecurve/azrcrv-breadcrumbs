<?php
/**
 * ------------------------------------------------------------------------------
 * Plugin Name: Breadcrumbs
 * Description: Create breadcrumbs trail for posts, pages and other post types.
 * Version: 1.3.5
 * Author: azurecurve
 * Author URI: https://development.azurecurve.co.uk/classicpress-plugins/
 * Plugin URI: https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/
 * Text Domain: breadcrumbs
 * Domain Path: /languages
 * ------------------------------------------------------------------------------
 * This is free software released under the terms of the General Public License,
 * version 2, or later. It is distributed WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Full
 * text of the license is available at https://www.gnu.org/licenses/gpl-2.0.html.
 * ------------------------------------------------------------------------------
 */

// Prevent direct access.
if (!defined('ABSPATH')){
	die();
}

// include plugin menu
require_once(dirname( __FILE__).'/pluginmenu/menu.php');
add_action('admin_init', 'azrcrv_create_plugin_menu_b');

// include update client
require_once(dirname(__FILE__).'/libraries/updateclient/UpdateClient.class.php');

/**
 * Setup actions, shortcodes and filters.
 *
 * @since 1.0.0
 *
 */
// add actions
add_action('admin_post_azrcrv_b_save_options', 'azrcrv_b_process_options');
add_action('wp_enqueue_scripts', 'azrcrv_b_add_inline_css');
add_action('admin_menu', 'azrcrv_b_create_admin_menu');
add_action('plugins_loaded', 'azrcrv_b_load_languages');

// add shortcodes
add_shortcode('getbreadcrumbs', 'azrcrv_b_shortcode_get_breadcrumbs');
add_shortcode('GetBreadcrumbs', 'azrcrv_b_shortcode_get_breadcrumbs');
add_shortcode('GETBREADCRUMBS', 'azrcrv_b_shortcode_get_breadcrumbs');

// add filters
add_filter('the_content', 'azrcrv_b_display_breadcrumbs_before_content');
add_filter('the_content', 'azrcrv_b_display_breadcrumbs_after_content');
add_filter('plugin_action_links', 'azrcrv_b_add_plugin_action_link', 10, 2);
add_filter('codepotent_update_manager_image_path', 'azrcrv_b_custom_image_path');
add_filter('codepotent_update_manager_image_url', 'azrcrv_b_custom_image_url');

/**
 * Load language files.
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_load_languages() {
    $plugin_rel_path = basename(dirname(__FILE__)).'/languages';
    load_plugin_textdomain('breadcrumbs', false, $plugin_rel_path);
}

/**
 * Shortcode to return breadcrumbs
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_shortcode_get_breadcrumbs($atts, $content = null){
	if (empty($atts)){
		$type = 'text';
	}else{
		$attribs = implode('',$atts);
		$type = str_replace("'", '', str_replace('"', '', substr ($attribs, 1)));
	}
	return azrcrv_b_generate_breadcrumbs(get_the_ID(), $type);
}

/**
 * output breadcrumbs before content
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_display_breadcrumbs_before_content($content){
	$options = azrcrv_b_get_option('azrcrv-b');
	
	if ($options['page-before'] != 'none'){
		return azrcrv_b_generate_page_breadcrumbs(get_the_ID(), $options['page-before']).$content;
	}else{
		return $content;
	}
}

/**
 * output breadcrumbs after content
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_display_breadcrumbs_after_content($content){
	$options = azrcrv_b_get_option('azrcrv-b');
	
	if ($options['page-after'] != 'none'){
		return $content.azrcrv_b_generate_page_breadcrumbs(get_the_ID(), $options['page-after']);
	}else{
		return $content;
	}
}

/**
 * generate page breadcrumbs
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_generate_page_breadcrumbs($id, $type){
	$options = azrcrv_b_get_option('azrcrv-b');
	
	$breadcrumbs = '';
	if (is_page($id) AND in_the_loop($id)){
					
		$breadcrumbs = azrcrv_b_generate_breadcrumbs($id, $type);
	
	}
	return $breadcrumbs;
}

/**
 * generate breadcrumbs
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_generate_breadcrumbs($id, $type){
	
	$id = azrcrv_b_get_the_ID($id);
	
	$options = azrcrv_b_get_option('azrcrv-b');
	
	$breadcrumbs = '';
	
	if ($options['show-on-homepage'] == 1 AND is_front_page($id) or !is_front_page($id)){
		if (esc_html(stripslashes($type)) == 'arrow'){
			$type = 'arrow';
			$breadcrumbseparator = '';
		}else{
			$type = 'text';
			$breadcrumbseparator = ' '.$options['breadcrumb-separator'].' ';
		}
		
		$post = get_post($id);
		if (isset($post)){
			$title = $post->post_title;
		}
		$pageurl = trailingslashit(get_site_url());
		
		if ($options['add-homepage'] == 1 AND is_front_page()){
			$title = get_bloginfo('name');
		}else{
			$breadcrumbs .= '<a href="'.$pageurl.'" class="azrcrv-b-'.$type.'breadcrumbs">'.get_bloginfo('name').'</a>'.$breadcrumbseparator;
		}
		
		if (is_category()){
			$title = get_cat_name($id);
			$parents = get_category_parents($id, false, ',');
			$parents = explode(',', $parents);
			
			foreach ($parents as $parent){
				if (strlen($parent) > 0 AND $parent <> $title){
					$category_id = get_cat_ID( $parent );
					$category_link = get_category_link( $category_id );
					$breadcrumbs .= '<a href="'.$category_link.'" class="azrcrv-b-'.$type.'breadcrumbs">'.$parent.'</a>'.$breadcrumbseparator;
				}
			}
		}elseif (is_archive() AND !in_the_loop()){
			$title = get_the_archive_title('', false);
		}elseif (is_archive() AND in_the_loop()){
			$archive_title = get_the_archive_title('', false);
			$archive_link = get_post_type_archive_link( $post->post-type );
			$breadcrumbs .= '<a href="'.$archive_link.'" class="azrcrv-b-'.$type.'breadcrumbs">'.$archive_title.'</a>'.$breadcrumbseparator;
		}else{
			$link = '';
			
			$parents = array();
			$parents = azrcrv_b_get_parents($id, $parents);
			
			foreach (array_reverse($parents) as $key => $value){
				$link .= $value["name"].'/';
				$breadcrumbs .= '<a href="'.get_the_permalink($value["parentid"]).'" class="azrcrv-b-'.$type.'breadcrumbs">'.$value['title'].'</a>'.$breadcrumbseparator;
			}
		}
		if ($type == 'arrow'){
			$breadcrumbs .= '<span class="azrcrv-b-arrowbreadcrumbs">'.$title.'</span>';
		}else{
			$breadcrumbs .= $title;
		}
		$breadcrumbs = "<div class='azrcrv-b-arrowbreadcrumbscontainer'><div class='azrcrv-b-".$type."breadcrumbs'>".$breadcrumbs."</div></div>";
	}
	
	return $breadcrumbs;
}

/**
 * load inline styling
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_add_inline_css(){
	
	wp_enqueue_style('azrcrv_b', plugins_url('assets/css/style.css', __FILE__));
	
	$options = azrcrv_b_get_option('azrcrv-b');
		
	wp_add_inline_style('azrcrv_b', stripslashes($options['style-text']).stripslashes($options['style-arrow']));
}

/**
 * get all parents
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_get_parents($id, $array){
	$parentid = wp_get_post_parent_id($id);
	if ($parentid != ''){
		$post = get_post($parentid);
		$array[count($array)] = array("parentid"=>$parentid,"title"=>$post->post_title,"name"=>$post->post_name);
		$array = azrcrv_b_get_parents($parentid, $array);
	}
	return $array;
}

/**
 * Custom plugin image path.
 *
 * @since 1.3.0
 *
 */
function azrcrv_b_custom_image_path($path){
    if (strpos($path, 'azrcrv-breadcrumbs') !== false){
        $path = plugin_dir_path(__FILE__).'assets/pluginimages';
    }
    return $path;
}

/**
 * Custom plugin image url.
 *
 * @since 1.3.0
 *
 */
function azrcrv_b_custom_image_url($url){
    if (strpos($url, 'azrcrv-breadcrumbs') !== false){
        $url = plugin_dir_url(__FILE__).'assets/pluginimages';
    }
    return $url;
}

/**
 * Get options including defaults.
 *
 * @since 1.3.0
 *
 */
function azrcrv_b_get_option($option_name){
 
	$defaults = array(
				'add-homepage' => 1,
				'show-on-homepage' => 0,
				'page-before' => 'arrow',
				'page-after' => 'arrow',
				'breadcrumb-separator' => '&raquo;',
				'style-text' => "div.azrcrv-b-textbreadcrumbs {
	font-size: 12px;
	color: grey;
	font-weight: 550;
	padding: 9px 0 9px 0;
}
a.azrcrv-b-textbreadcrumbs {
	color: grey !important;
	font-weight: 550;
	text-decoration: none;
}
a.azrcrv-b-textbreadcrumbs:hover {
	color: #007FFF !important;
	text-decoration: underline;
}",
				'style-arrow' => "div.azrcrv-b-arrowbreadcrumbscontainer{
	display: block;
	width: 100%;
}
div.azrcrv-b-arrowbreadcrumbs {
	display: inline-block;
	border: 1px solid #007FFF;
	overflow: hidden;
	border-radius: 5px;
}
div.azrcrv-b-arrowbreadcrumbs a, span.azrcrv-b-arrowbreadcrumbs {
	text-decoration: none;
	outline: none;
	display: block;
	float: left;
	font-size: 12px;
	line-height: 20px;
	/*need more margin on the left of links to accommodate the numbers*/
	padding: 0 10px 0 20px;
	position: relative;
}
div.azrcrv-b-arrowbreadcrumbs a{
	color: #007FFF;
	font-weight: 550;
}
span.azrcrv-b-arrowbreadcrumbs {
	color: #007FFF;
}
/*since the first link does not have a triangle before it we can reduce the left padding to make it look consistent with other links*/
div.azrcrv-b-arrowbreadcrumbs a:first-child {
	border-radius: 5px 0 0 5px; /*to match with the parent's radius*/
	padding-left: 10px;
	color: #007FFF;
}
div.azrcrv-b-arrowbreadcrumbs a:last-child {
	border-radius: 0 5px 5px 0; /*this was to prevent glitches on hover*/
	padding-right: 20px;
	color: #007FFF;
}
div.azrcrv-b-arrowbreadcrumbs a:not(:first-child):not(:last-child){
	color: #007FFF;
}

/*adding the arrows for the azrcrv-b-arrowbreadcrumbss using rotated pseudo elements*/
div.azrcrv-b-arrowbreadcrumbs a:after {
	content: '';
	position: absolute;
	top: 0;
	/*half of square's length*/
	right: -10px;
	/*same dimension as the line-height of div.azrcrv-b-arrowbreadcrumbs a */
	width: 20px; 
	height: 20px;
	transform: scale(0.707) rotate(45deg);
	/*we need to prevent the arrows from getting buried under the next link*/
	z-index: 1;
	/*stylish arrow design using box shadow*/
	box-shadow:
		2px -2px 0 2px #007FFF, 
		3px -3px 0 2px #007FFF;
	border-radius: 0 5px 0 50px;
}

div.azrcrv-b-arrowbreadcrumbs a, div.azrcrv-b-arrowbreadcrumbs a:after {
	background: #FFF;
	transition: all 0.5s;
}
div.azrcrv-b-arrowbreadcrumbs a:hover, div.azrcrv-b-arrowbreadcrumbs a.active, 
div.azrcrv-b-arrowbreadcrumbs a:hover:after, div.azrcrv-b-arrowbreadcrumbs a.active:after,
div.azrcrv-b-arrowbreadcrumbs a:not(:first-child):not(:last-child):hover{
	background: #007FFF;
	color: #FFF;
}",
					);

	$options = get_option($option_name, $defaults);

	$options = wp_parse_args($options, $defaults);

	return $options;

 }

/**
 * Add Breadcrumbs action link on plugins page.
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_add_plugin_action_link($links, $file){
	static $this_plugin;

	if (!$this_plugin){
		$this_plugin = plugin_basename(__FILE__);
	}

	if ($file == $this_plugin){
		$settings_link = '<a href="'.admin_url('admin.php?page=azrcrv-b').'"><img src="'.plugins_url('/pluginmenu/images/logo.svg', __FILE__).'" style="padding-top: 2px; margin-right: -5px; height: 16px; width: 16px;" alt="azurecurve" />'.esc_html__('Settings' ,'breadcrumbs').'</a>';
		array_unshift($links, $settings_link);
	}

	return $links;
}

/**
 * Add Breadcrumbs menu to plugin menu.
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_create_admin_menu(){
	//global $admin_page_hooks;
	
	add_submenu_page("azrcrv-plugin-menu"
						,esc_html__("Breadcrumbs Settings", "breadcrumbs")
						,esc_html__("Breadcrumbs", "breadcrumbs")
						,'manage_options'
						,'azrcrv-b'
						,'azrcrv_b_settings');
}

/**
 * Display Settings page.
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_settings(){
	if (!current_user_can('manage_options')){
		$error = new WP_Error('not_found', esc_html__('You do not have sufficient permissions to access this page.' , 'azc_b'), array('response' => '200'));
		if(is_wp_error($error)){
			wp_die($error, '', $error->get_error_data());
		}
	}
	
	// Retrieve plugin configuration options from database
	$options = azrcrv_b_get_option('azrcrv-b');
	
	?>
	<div id="azrcrv-b-general" class="wrap">
		<fieldset>
			<h1>
				<?php
					echo '<a href="https://development.azurecurve.co.uk/classicpress-plugins/"><img src="'.plugins_url('/pluginmenu/images/logo.svg', __FILE__).'" style="padding-right: 6px; height: 20px; width: 20px;" alt="azurecurve" /></a>';
					esc_html_e(get_admin_page_title());
				?>
			</h1>
			<?php if(isset($_GET['settings-updated'])){ ?>
				<div class="notice notice-success is-dismissible">
					<p><strong><?php esc_html_e('Settings have been saved.', 'breadcrumbs') ?></strong></p>
				</div>
			<?php } ?>
			<form method="post" action="admin-post.php">
				<input type="hidden" name="action" value="azrcrv_b_save_options" />
				<input name="page_options" type="hidden" value="show-on-homepageadd-homepage,before-title,after-title,page-before,page-after,style" />
				
				<!-- Adding security through hidden referrer field -->
				<?php wp_nonce_field('azrcrv-b', 'azrcrv-b-nonce'); ?>
				<table class="form-table">
				<tr><th scope="row" colspan="2">
					<label for="explanation">
						<?php esc_html_e('Breadcrumbs allows the display of breadcrumbs before and after the title and content.', 'azc_b'); ?>
					</label>
				</th></tr>
				<tr><th scope="row"><?php esc_html_e('Show on homepage', 'breadcrumbs'); ?></th><td>
					<fieldset><legend class="screen-reader-text"><span><?php esc_html_e("Show on Homepage", "breadcrumbs"); ?></span></legend>
						<label for="show-on-homepage"><input name="show-on-homepage" type="checkbox" id="show-on-homepage" value="1" <?php checked('1', $options['show-on-homepage']); ?> /></label>
					</fieldset>
					<p class="description"><?php esc_html_e('Shows breadcrumbs on the homepage.', 'breadcrumbs'); ?></p>
				</td></tr>
				<tr><th scope="row"><?php esc_html_e('Add homepage', 'breadcrumbs'); ?></th><td>
					<fieldset><legend class="screen-reader-text"><span><?php esc_html_e("Add Homepage", "breadcrumbs"); ?></span></legend>
						<label for="add-homepage"><input name="add-homepage" type="checkbox" id="add-homepage" value="1" <?php checked('1', $options['add-homepage']); ?> /></label>
					</fieldset>
					<p class="description"><?php esc_html_e('Adds homepage to the breadcrumb trail.', 'breadcrumbs'); ?></p>
				</td></tr>
				<tr><th scope="row"><?php esc_html_e('Breadcrumbs Before Page', 'breadcrumbs'); ?></th><td>
					<select name="page-before">
						<option value="none" <?php if($options['page-before'] == 'none'){ echo ' selected="selected"'; } ?>><?php esc_html_e("None", "breadcrumbs"); ?></option>
						<option value="text" <?php if($options['page-before'] == 'text'){ echo ' selected="selected"'; } ?>><?php esc_html_e("Text", "breadcrumbs"); ?></option>
						<option value="arrow" <?php if($options['page-before'] == 'arrow'){ echo ' selected="selected"'; } ?>><?php esc_html_e("Arrow", "breadcrumbs"); ?></option>
					</select>
					<p class="description"><?php esc_html_e('Shows breadcumbs before page.', 'breadcrumbs'); ?></p>
				</td></tr>
				<tr><th scope="row"><?php esc_html_e('Breadcrumbs After Page', 'breadcrumbs'); ?></th><td>
					<select name="page-after">
						<option value="none" <?php if($options['page-after'] == 'none'){ echo ' selected="selected"'; } ?>><?php esc_html_e("None", "breadcrumbs"); ?></option>
						<option value="text" <?php if($options['page-after'] == 'text'){ echo ' selected="selected"'; } ?>><?php esc_html_e("Text", "breadcrumbs"); ?></option>
						<option value="arrow" <?php if($options['page-after'] == 'arrow'){ echo ' selected="selected"'; } ?>><?php esc_html_e("Arrow", "breadcrumbs"); ?></option>
					</select>
					<p class="description"><?php esc_html_e('Shows breadcumbs after page.', 'breadcrumbs'); ?></p>
				</td></tr>
				<tr><th scope="row"><label for="breadcrumb-separator"><?php esc_html_e('Text Breadcrumbs Separator', 'breadcrumbs'); ?></label></th><td>
					<input type="text" name="breadcrumb-separator" value="<?php echo esc_html(stripslashes($options['breadcrumb-separator'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e(sprintf('Character(s) to show between text breadcrumbs (for example %s or %s).', '<strong>&amp;raquo;</strong>', '<strong>::</strong>'), 'breadcrumbs'); ?></p>
				</td></tr>
				<tr><th scope="row"><?php esc_html_e('Style for text breadcrumbs', 'breadcrumbs'); ?></th><td>
					<textarea name="style-text" rows="20" cols="80" id="style-text" class="large-text code"><?php echo esc_textarea(stripslashes($options['style-text'])) ?></textarea>
				</td></tr>
				<tr><th scope="row"><?php esc_html_e('Style for arrow breadcrumbs', 'breadcrumbs'); ?></th><td>
					<textarea name="style-arrow" rows="40" cols="80" id="style" class="large-text code"><?php echo esc_textarea(stripslashes($options['style-arrow'])) ?></textarea>
				</td></tr>
				<tr><th scope="row"><label for="shortcode"><?php esc_html_e('Shortcode', 'breadcrumbs'); ?></label></th><td>
					<?php printf(esc_html__('%s can be added anywhere to place breadcrumbs in desired location.', 'breadcrumbs'), "<strong>[getbreadcrumbs=arrow]</strong>"); ?>
				</td></tr>
				<tr><th scope="row"><label for="function"><?php esc_html_e('Function', 'breadcrumbs'); ?></label></th><td>
					<?php printf(esc_html__('%s can be added to a theme to place breadcrumbs in desired location; exists syntax prevents errors if plugin deactivated.', 'breadcrumbs'), "<strong>if (function_exists('getbreadcrumbs')){ echo getbreadcrumbs('arrow'); }</strong>"); ?>
				</td></tr>
				</table>
				<input type="submit" value="Save Changes" class="button-primary"/>
			</form>
		</fieldset>
	</div>
	<?php
}

/**
 * Save Settings.
 *
 * @since 1.0.0
 *
 */
function azrcrv_b_process_options(){
	// Check that user has proper security level
	if (!current_user_can('manage_options')){
		wp_die(esc_html__('You do not have permissions to perform this action', 'breadcrumbs'));
	}
	// Check that nonce field created in configuration form is present
	if (! empty($_POST) && check_admin_referer('azrcrv-b', 'azrcrv-b-nonce')){
	
		// Retrieve original plugin options array
		$options = get_option('azrcrv-b');
		
		$option_name = 'show-on-homepage';
		if (isset($_POST[$option_name])){
			$options[$option_name] = 1;
		}else{
			$options[$option_name] = 0;
		}
		
		$option_name = 'add-homepage';
		if (isset($_POST[$option_name])){
			$options[$option_name] = 1;
		}else{
			$options[$option_name] = 0;
		}
		
		$option_name = 'page-before';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		
		$option_name = 'page-after';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		
		$option_name = 'breadcrumb-separator';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		
		$option_name = 'style-text';
		if (isset($_POST[$option_name])){
			$options[$option_name] = implode("\n", array_map('sanitize_text_field', explode("\n", $_POST[$option_name])));
		}
		
		$option_name = 'style-arrow';
		if (isset($_POST[$option_name])){
			$options[$option_name] = implode("\n", array_map('sanitize_text_field', explode("\n", $_POST[$option_name])));
		}
		
		// Store updated options array to database
		update_option('azrcrv-b', $options);
		
		// Redirect the page to the configuration form that was processed
		wp_redirect(add_query_arg('page', 'azrcrv-b&settings-updated', admin_url('admin.php')));
		exit;
	}
}

/**
 * function to get breadcrumbs
 *
 * @since 1.0.0
 *
 */
function getbreadcrumbs($type){
	echo azrcrv_b_generate_breadcrumbs(get_the_ID(), $type);
}

/**
 * old function to get breadcrumbs including for backward compatibility
 *
 * @since 1.0.0
 *
 */
function azc_b_getbreadcrumbs($type){
	echo azrcrv_b_generate_breadcrumbs(get_the_ID(), $type);
}

/**
 * get id or category id if in loop
 *
 * @since 1.1.0
 *
 */
function azrcrv_b_get_the_ID($id) {
	if (in_the_loop()) {
		$post_id = $id;
	} else {
		$post_id = get_queried_object_id() == 0 ? 999999999999 :get_queried_object_id();
	}
	return $post_id;
}

?>