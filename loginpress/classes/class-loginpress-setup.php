<?php
/**
 * LoginPress Settings
 *
 * @since 1.0.9
 */
if ( ! class_exists( 'LoginPress_Settings' ) ):

class LoginPress_Settings {

  private $settings_api;

  function __construct() {

    include_once( LOGINPRESS_ROOT_PATH . '/classes/class-loginpress-settings-api.php' );
    $this->settings_api = new LoginPress_Settings_API;

    add_action( 'admin_init', array( $this, 'loginpress_setting_init' ) );
    add_action( 'admin_menu', array( $this, 'loginpress_setting_menu' ) );
  }

  function loginpress_setting_init() {

    //set the settings.
    $this->settings_api->set_sections( $this->get_settings_sections() );
    $this->settings_api->set_fields( $this->get_settings_fields() );

    //initialize settings.
    $this->settings_api->admin_init();

    //reset settings.
    $this->load_default_settings();
  }

  function load_default_settings() {

    $_loginpress_Setting = get_option( 'loginpress_setting' );
    if ( isset( $_loginpress_Setting['reset_settings'] ) && 'on' == $_loginpress_Setting['reset_settings'] ) {

       $loginpress_last_reset = array( 'last_reset_on' => date('Y-m-d') );
       update_option( 'loginpress_customization', $loginpress_last_reset );
       update_option( 'customize_presets_settings', 'default1' );
       $_loginpress_Setting['reset_settings'] = 'off';
       update_option( 'loginpress_setting', $_loginpress_Setting );
       add_action( 'admin_notices', array( $this, 'settings_reset_message' ) );
    }
  }

  function settings_reset_message() {

    $class = 'notice notice-success';
    $message = __( 'Default Settings Restored', 'loginpress' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
  }

  function loginpress_setting_menu() {

    add_menu_page( __( 'LoginPress', 'loginpress' ), __( 'LoginPress', 'loginpress' ), 'manage_options', "loginpress-settings", array( $this, 'plugin_page' ), '', 50 );

    add_submenu_page( 'loginpress-settings', __( 'Settings', 'loginpress' ), __( 'Settings', 'loginpress' ), 'manage_options', "loginpress-settings", array( $this, 'plugin_page' ) );

    add_submenu_page( 'loginpress-settings', __( 'Customizer', 'loginpress' ), __( 'Customizer', 'loginpress' ), 'manage_options', "loginpress", '__return_null' );

    add_submenu_page( 'loginpress-settings', __( 'Help', 'loginpress' ), __( 'Help', 'loginpress' ), 'manage_options', "loginpress-help", array( $this, 'loginpress_help_page' ) );

    add_submenu_page( 'loginpress-settings', __( 'Import/Export LoginPress Settings', 'loginpress' ), __( 'Import / Export', 'loginpress' ), 'manage_options', "loginpress-import-export", array( $this, 'loginpress_import_export_page' ) );

    add_submenu_page( 'loginpress-settings', __( 'Add-Ons', 'loginpress' ), __( 'Add-Ons', 'loginpress' ), 'manage_options', "loginpress-addons", array( $this, 'loginpress_addons_page' ) );

  }

  function get_settings_sections() {

    $loginpress_general_tab = array(
      array(
        'id'    => 'loginpress_setting',
        'title' => __( 'Settings', 'loginpress' ),
        'desc'  => sprintf( __( 'Everything else is customizable through %1$sWordPress Customizer%2$s.', 'loginpress' ), '<a href="' . admin_url( 'admin.php?page=loginpress' ) . '">', '</a>' ),
      ),
    );
    // if ( has_action( 'loginpress_pro_add_template' ) ) {
    //
    //   $loginpress_license =
    //   array(
    //     'id'    => 'loginpress_license',
    //     'title' => __( 'License', 'loginpress' ),
    //     'desc'  => __( 'License Description', 'loginpress' ),
    //   );
    //   array_push( $loginpress_general_tab , $loginpress_license );
    // }
    if ( ! has_action( 'loginpress_pro_add_template' ) ) {

      $loginpress_premium =
        array(
          'id'    => 'loginpress_premium',
          'title' => __( 'Upgrade to Pro for More Features', 'loginpress' )
        );

      array_push( $loginpress_general_tab , $loginpress_premium );
    }

      $sections = apply_filters( 'loginpress_settings_tab', $loginpress_general_tab );

      return $sections;
  }

  /**
   * Returns all the settings fields
   *
   * @return array settings fields
   */
  function get_settings_fields() {

    /**
     * [$_free_fields array of free fields]
     * @var array
     */
    $_free_fields = array(
      array(
        'name'        => 'session_expiration',
        'label'       => __( 'Session Expire', 'loginpress' ),
        'desc'        => __( 'Set the session expiration time in minutes. e.g: 10', 'loginpress' ), //<br /> When you set the time, here you need to set the expiration cookies. for this, you just need to logout at least one time. After login again, it should be working fine.<br />For removing the session expiration just pass empty value in “Expiration” field and save it. Now clear the expiration cookies by logout at least one time.
        'placeholder' => __( '10', 'loginpress' ),
        'min'         => 0,
        // 'max'         => 100,
        'step'        => '1',
        'type'        => 'number',
        'default'     => 'Title',
        'sanitize_callback' => 'intval'
      ),
      // array(
      //   'name'  => 'enable_privacy_policy',
      //   'label' => __( 'Enable Privacy Policy', 'loginpress' ),
      //   'desc'  => __( 'Enable Privacy Policy checkbox on registration page.', 'loginpress' ),
      //   'type'  => 'checkbox'
      // ),
      // array(
      //   'name'  => 'privacy_policy',
      //   'label' => __( 'Privacy & Policy', 'loginpress' ),
      //   'desc'  => __( 'Right down the privacy and policy description.', 'loginpress' ),
      //   'type'  => 'wysiwyg',
      //   'default' => __( sprintf( __( '%1$sPrivacy Policy%2$s.', 'loginpress' ), '<a href="' . admin_url( 'admin.php?page=loginpress-settings' ) . '">', '</a>' ) )
      // ),
      array(
        'name'  => 'enable_reg_pass_field',
        'label' => __( 'Custom Password Fields', 'loginpress' ),
        'desc'  => __( 'Enable custom password fields on registration form.', 'loginpress' ),
        'type'  => 'checkbox'
      ),
      array(
        'name'    => 'login_order',
        'label'   => __( 'Login Order', 'loginpress' ),
        'desc'    => __( 'Enable users to login using their username and/or email address.', 'loginpress' ),
        'type'    => 'radio',
        'default' => 'default',
        'options' => array(
            'default' => 'Both Username Or Email Address',
            'username'  => 'Only Username',
            'email' => 'Only Email Address'
        )
      ),
      // array(
      //   'name'  => 'login_with_email',
      //   'label' => __( 'Login with Email', 'loginpress' ),
      //   'desc'  => __( 'Force user to login with Email Only Instead Username.', 'loginpress' ),
      //   'type'  => 'checkbox'
      // ),
      array(
        'name'  => 'reset_settings',
        'label' => __( 'Reset Default Settings', 'loginpress' ),
        'desc'  => __( 'Remove my custom settings.', 'loginpress' ),
        'type'  => 'checkbox'
      ),
    );

    // Hide Advertisement in version 1.1.3
    // if ( ! has_action( 'loginpress_pro_add_template' ) ) {
    //   array_unshift( $_free_fields , array(
    //     'name'  => 'enable_repatcha_promo',
    //     'label' => __( 'Enable reCAPTCHA', 'loginpress' ),
    //     'desc'  => __( 'Enable LoginPress reCaptcha', 'loginpress' ),
    //     'type'  => 'checkbox'
    //   ) );
    // }

    $_settings_fields = apply_filters( 'loginpress_pro_settings', $_free_fields );

    $settings_fields = array( 'loginpress_setting' => $_settings_fields );

    $tab = apply_filters( 'loginpress_settings_fields', $settings_fields );

    return $tab;
  }

  function plugin_page() {

      echo '<div class="wrap loginpress-admin-setting">';
      echo '<h2 style="margin: 20px 0 20px 0;">';
      esc_html_e( 'LoginPress - Rebranding your boring WordPress Login pages', 'loginpress' );
      echo '</h2>';

      $this->settings_api->show_navigation();
      $this->settings_api->show_forms();

      echo '</div>';
  }

  /**
   * [loginpress_help_page callback function for sub-page Help]
   * @since 1.0.19
   */
  function loginpress_help_page(){

    include LOGINPRESS_DIR_PATH . 'classes/class-loginpress-log.php';

    $html = '<div class="loginpress-help-page">';
    $html .= '<h2>Help & Troubleshooting</h2>';
    $html .= sprintf( __( 'Free support is available on the %1$s plugin support forums%2$s.', 'loginpress' ), '<a href="https://wordpress.org/support/plugin/loginpress" target="_blank">', '</a>' );
    $html .="<br /><br />";
    $html .= sprintf( __( 'For premium features, add-ons and priority email support, %1$s upgrade to pro%2$s.', 'loginpress' ), '<a href="https://wpbrigade.com/wordpress/plugins/loginpress-pro/?utm_source=loginpress-lite&utm_medium=help-page&utm_campaign=pro-upgrade" target="_blank">', '</a>' );
    $html .="<br /><br />";
    $html .= 'Found a bug or have a feature request? Please submit an issue <a href="https://wpbrigade.com/contact/" target="_blank">here</a>!';
    $html .= '<pre><textarea rows="25" cols="75" readonly="readonly">';
    $html .= LoginPress_Log_Info::get_sysinfo();
    $html .= '</textarea></pre>';
    $html .= '<input type="button" class="button loginpress-log-file" value="' . __( 'Download Log File', 'loginpress' ) . '"/>';
    $html .= '<span class="log-file-sniper"><img src="'. admin_url( 'images/wpspin_light.gif' ) .'" /></span>';
    $html .= '<span class="log-file-text">LoginPress Log File Downloaded Successfully!</span>';
    $html .= '</div>';
    echo $html;
  }

  /**
   * [loginpress_import_export_page callback function for sub-page Import / Export]
   * @since 1.0.19
   */
  function loginpress_import_export_page(){

    include LOGINPRESS_DIR_PATH . 'include/loginpress-import-export.php';
  }

  /**
   * [loginpress_addons_page callback function for sub-page Add-ons]
   * @since 1.0.19
   */
  function loginpress_addons_page() {

    include LOGINPRESS_DIR_PATH . 'classes/class-loginpress-addons.php';
  }

  /**
   * Get all the pages
   *
   * @return array page names with key value pairs
   */
  function get_pages() {
    $pages = get_pages();
    $pages_options = array();
    if ( $pages ) {
        foreach ($pages as $page) {
            $pages_options[$page->ID] = $page->post_title;
        }
    }

    return $pages_options;
  }

}
endif;
