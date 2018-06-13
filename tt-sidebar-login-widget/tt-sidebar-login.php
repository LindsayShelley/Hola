<?php
/*
Plugin Name: Sidebar Login Widget
Plugin URI: http://www.technologiestoday.com.au/guide-to-use-tt-sidebar-login-widget-plugin-for-wordpress/
Description: Sidebar widget to log into Wordpress Account
Author: Rashed Latif
Author URI: http://www.technologiestoday.com.au/rashed-latif
Donate link: http://www.technologiestoday.com.au/donate
Requires at least: 3.0.1
Tested up to: 4.0
Version: 2.0.1
*/


class TTSidebarLogin extends WP_Widget{
	
	function __construct(){
		$params = array(
			'description'	=> 'Sidebar Login to Wordpress Account',
			'name'			=> 'Sidebar Login Widget'
			);
		//Enque Style sheet
		wp_enqueue_style( 'tp-sidebar-login', plugins_url( 'assets/css/tt-sidebar-login.css', __FILE__ ));
		
		//Overriding Parent Class's constructor. 3 parameters - id,name,parameters
		parent::__construct('SidebarLogin', '', $params);
	
	}
	
	/*This method is responsible for updating the widget option form*/	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['chk_show_avatar'] = strip_tags($new_instance['chk_show_avatar']);
		$instance['chk_show_remember'] = strip_tags($new_instance['chk_show_remember']);
		$instance['chk_show_register'] = strip_tags($new_instance['chk_show_register']);
		$instance['chk_show_forgot'] = strip_tags($new_instance['chk_show_forgot']);
		$instance['chk_show_dash'] = strip_tags($new_instance['chk_show_dash']);
		$instance['chk_show_profile'] = strip_tags($new_instance['chk_show_profile']);
		$instance['chk_show_postcount'] = strip_tags($new_instance['chk_show_postcount']);
		return $instance;
	}

	/*
	 * This function is responsible for displaying forms
	 * This method accepts a parameter which is an array
	 */

	public function form($instance){
		
		/*An array containing default values when the widget will be used first time*/
		$defaults = array(
				  'title' => 'Login',
				  'chk_show_avatar' => 'on',
				  'chk_show_remember' => 'on',
				  'chk_show_register' => 'on',
				  'chk_show_forgot' => 'on',
				  'chk_show_dash' => 'on',
				  'chk_show_postcount' => 'on',
				  'chk_show_profile' => 'on'
				  );
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		extract($instance, EXTR_SKIP);
		
		?>
		<!-- Text field for Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ttslw_text_domain'); ?></label>
			<input 
				class="widefat"
				type="text"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php if(isset($title)) echo esc_attr($title); ?>"
			/>
		</p>
		<!-- Checkbox to turn on/off the option to display avatar -->
		<p>
			<input
				type="checkbox"
				<?php checked("$chk_show_avatar", 'on' );?>			
				class="checkbox"
				id="<?php echo $this->get_field_id('chk_show_avatar'); ?>"
				name="<?php echo $this->get_field_name('chk_show_avatar'); ?>"
			/>
			<label for="<?php echo $this->get_field_id('chk_show_avatar'); ?>"><?php _e('Show Avatar', 'ttslw_text_domain'); ?></label>
		        	
		</p>
		
		<!-- Checkbox to turn on/off the option to display Dashboard link when logged in -->
		<p>
			<input
				type="checkbox"
				<?php checked("$chk_show_dash", 'on' ); ?>			
				class="checkbox"
				id="<?php echo $this->get_field_id('chk_show_dash'); ?>"
				name="<?php echo $this->get_field_name('chk_show_dash'); ?>"
			/>
			<label for="<?php echo $this->get_field_id('chk_show_dash'); ?>"> <?php _e('Show Dashboard Link', 'ttslw_text_domain'); ?> </label>
		        	
		</p>
		
		<!-- Checkbox to turn on/off the option to display profile link when logged in -->
		<p>
			<input
				type="checkbox"
				<?php checked("$chk_show_profile", 'on' ); ?>			
				class="checkbox"
				id="<?php echo $this->get_field_id('chk_show_profile'); ?>"
				name="<?php echo $this->get_field_name('chk_show_profile'); ?>"
			/>
			<label for="<?php echo $this->get_field_id('chk_show_profile'); ?>"> <?php _e('Show Profile Link', 'ttslw_text_domain'); ?> </label>
		        	
		</p>
		
		<!-- Checkbox to turn on/off the option to display Remember me option when not logged in -->
		<p>
			<input
				type="checkbox"
				<?php checked("$chk_show_remember", 'on' ); ?>			
				class="checkbox"
				id="<?php echo $this->get_field_id('chk_show_remember'); ?>"
				name="<?php echo $this->get_field_name('chk_show_remember'); ?>"
			/>
			<label for="<?php echo $this->get_field_id('chk_show_remember'); ?>"> <?php _e('Show Remember me', 'ttslw_text_domain'); ?> </label>
		        	
		</p>
		
		<!-- Checkbox to turn on/off the option to display Register link on login form -->
		<p>
			<input
				type="checkbox"
				<?php checked("$chk_show_register", 'on' ); ?>			
				class="checkbox"
				id="<?php echo $this->get_field_id('chk_show_register'); ?>"
				name="<?php echo $this->get_field_name('chk_show_register'); ?>"
			/>
			<label for="<?php echo $this->get_field_id('chk_show_register'); ?>"> <?php _e('Show Register Link', 'ttslw_text_domain'); ?> </label>
		        	
		</p>
		
		<!-- Checkbox to turn on/off the option to display Forgot Password link on login form -->
		<p>
			<input
				type="checkbox"
				<?php checked("$chk_show_forgot", 'on' ); ?>			
				class="checkbox"
				id="<?php echo $this->get_field_id('chk_show_forgot'); ?>"
				name="<?php echo $this->get_field_name('chk_show_forgot'); ?>"
			/>
			<label for="<?php echo $this->get_field_id('chk_show_forgot'); ?>"> <?php _e('Show Forgotten Password Link', 'ttslw_text_domain'); ?> </label>
		        	
		</p>
		
		<!-- Checkbox to turn on/off the option to display Post count -->
		<p>
			<input
				type="checkbox"
				<?php checked("$chk_show_postcount", 'on' ); ?>			
				class="checkbox"
				id="<?php echo $this->get_field_id('chk_show_postcount'); ?>"
				name="<?php echo $this->get_field_name('chk_show_postcount'); ?>"
			/>
			<label for="<?php echo $this->get_field_id('chk_show_postcount'); ?>"> <?php _e('Show Post Count', 'ttslw_text_domain'); ?> </label>
		        	
		</p>
		<?php
	}
	
	/*
	 *This method is responsible for displaying the outputs in the widgetized area
	 */
	
	public function widget($args, $instance){
		extract($args);
		extract($instance);
	
		global $user_login;
		
		// Setting default title when nothing is set from widget option
		if(empty($title)){
			$title = __("Member's Login", "ttslw_text_domain");
		}
		else{
			$title = apply_filters('widget_title', $title );
		}
		
				
		if(is_user_logged_in()){
			$user_info = get_user_by('login', $user_login);

			$title = (!empty($user_info->first_name) || !empty($user_info->last_name))? __('Welcome','ttslw_text_domain')." ".$user_info->first_name." ".$user_info->last_name : __('Welcome','ttslw_text_domain')." ".$user_login;
		}
		
		echo $before_widget;
			echo $before_title;
				echo $title;
			echo $after_title;
			
			$redirect = site_url();
			if (isset($_GET['login'])) {
				
				$login = $_GET['login']; // This variable is used when login failure occurs
				$current_error = $_GET['errcode']; // This variable is used to display the type of error during login
				
				if ($login == 'failed'){
					
					if ($current_error == "empty_username" || $current_error == "empty_password"){
						$error_msg = __('Enter both Username and Password', 'ttslw_text_domain');
					}
					elseif($current_error == 'invalid_username'){
						$error_msg = __('Username is not registered', 'ttslw_text_domain');
					}
					elseif($current_error == 'incorrect_password'){
						$error_msg = __('Incorrect Password', 'ttslw_text_domain');
					}
						
					echo "<div id='message' class='error fade'><p><strong>".$error_msg."</strong></p></div>";
				
				}
			
			}
			/*Check if user is logged in then show user information and logout,dashboardand profile link*/
			if (is_user_logged_in()) {
				
					?>
					<div class="sidebar-login-info">
					<?php
					
					if ($chk_show_avatar == "on"){
						$show_avatar = isset( $show_avatar ) ? $show_avatar : 1;
						if ( $show_avatar == 1 )
							echo '<div class="avatar_container">' . get_avatar( $user_info->ID, apply_filters( 'sidebar_login_widget_avatar_size', 45 ) ) . '</div>';
					}
					echo '<p>';
						_e('Logged in as ', 'ttslw_text_domain');
						echo '<strong>' . ucfirst( implode(', ', $user_info->roles)) . '</strong> <br>';
						if($chk_show_postcount=='on'){
							 _e('Posts by you','ttslw_text_domain'); echo ': '. count_user_posts( $user_info->ID ).'<br>';
						}
					echo "</p>";
					?>
					</div>		
		
					<ul id="<?php if($chk_show_avatar=='on') echo 'sidebar-login-links';else echo 'sidebar-login-links-left'; ?>">
						
						<?php if($chk_show_dash == 'on'){ ?>
							<li><a href="<?php echo admin_url() ?>"><?php _e( 'Dashboard' , 'ttslw_text_domain' )//_e( 'Dashboard' , 'default' ) ?> </a>|</li>
						<?php } ?>
						<?php if($chk_show_profile == 'on'){ ?>
							<li><a href="<?php echo admin_url() ?>profile.php"><?php _e( 'Profile' , 'ttslw_text_domain' )//_e( 'Profile' , 'tie' ) ?> </a>|</li>
						<?php } ?>	
							<li><a href="<?php echo wp_logout_url($redirect); ?>"><?php _e( 'Logout' , 'ttslw_text_domain' )//_e( 'Logout' , 'tie' ) ?> </a></li>
												
					</ul>
					
					<?php
			}
			/*If user is not logged in then show login form*/
			else{
				$remember_val = ($chk_show_remember == 'on') ? true : false; 
				
				wp_login_form(array( 'value_remember' => 0,
						     'redirect' => $redirect,
						     'label_username' 	=> __( 'Username', 'ttslw_text_domain' ),
						     'label_password' 	=> __( 'Password', 'ttslw_text_domain' ),
						     'remember' 	=> $remember_val
						    ));
				?>
				<p id="reglost">
					<?php
					if ($chk_show_register == 'on') echo '<a href="' . wp_registration_url() . '" title="Register">'.__('Register', 'ttslw_text_domain').'</a>';
					if ($chk_show_register == 'on' and $chk_show_forgot == 'on')echo "|  ";
					if ($chk_show_forgot == 'on') echo '<a href="' . wp_lostpassword_url($redirect) . '?sli=lost" rel="nofollow" title="Forgot Password">' . __('Forgot Password?','ttslw_text_domain') . '</a>';
					?>
				</p>
				<?php
			}			
		echo $after_widget;		
	}
}

/* */

add_action('widgets_init','tp_register_sidebar_login');
function tp_register_sidebar_login(){
	//Register a widget. 1 parameter: name of the class
	register_widget('TTSidebarLogin');

}


add_action('wp_login_failed', 'handle_login_failure');
/*
 * This method will handle the login failure process. 
 */
function handle_login_failure($username){
	// check what page the login attempt is coming from
  	global $current_error;
	$referrer = $_SERVER['HTTP_REFERER'];
	 
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		wp_redirect(home_url() . '/?login=failed&errcode='.$current_error );
		exit;
	}
}

if ( !function_exists('wp_authenticate') ) {
	function wp_authenticate($username, $password) {
		global $current_error;
		$username = sanitize_user($username);
		$password = trim($password);
		$user = apply_filters('authenticate', null, $username, $password);
		if ( $user == null ) {
			// TODO what should the error message be? (Or would these even happen?)
			// Only needed if all authentication handlers fail to return anything.
			$user = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));
		}
		$ignore_codes = array('empty_username', 'empty_password', 'invalid_username', 'incorrect_password');
		
		if (is_wp_error($user) && in_array($user->get_error_code(), $ignore_codes) ) {
			$current_error = $user->get_error_code();
			do_action('wp_login_failed', $username);
		}
		
		return $user;
	}
}

add_action( 'init', 'ttslw_plugin_init' );
function ttslw_plugin_init() {
	load_plugin_textdomain( 'ttslw_text_domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}


?>