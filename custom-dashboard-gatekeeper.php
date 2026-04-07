<?php
/**
 * Plugin Name: Custom Dashboard Gatekeeper Pro
 * Description: Redirects non-admins to a custom page with a configurable slug and validation.
 * Version: 1.0
 * Author: kevinkoosk
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 1. SETTINGS PAGE SETUP
 */

add_action( 'admin_menu', 'cdg_add_settings_menu' );
function cdg_add_settings_menu() {
    add_options_page(
        'Dashboard Gatekeeper Settings',
        'Dashboard Gatekeeper',
        'manage_options',
        'cdg-settings',
        'cdg_settings_page_html'
    );
}

add_action( 'admin_init', 'cdg_register_settings' );
function cdg_register_settings() {
    register_setting( 'cdg_settings_group', 'cdg_slug', array(
        'sanitize_callback' => 'cdg_validate_slug',
        'default'           => 'custom-dashboard'
    ));
}

function cdg_validate_slug( $input ) {
    $input = sanitize_title( $input );
    $page = get_page_by_path( $input, OBJECT, 'page' );

    if ( ! $page ) {
        add_settings_error(
            'cdg_slug',
            'page_not_found',
            'Error: The page slug "' . $input . '" does not exist. Please create the page first.',
            'error'
        );
        return get_option( 'cdg_slug' );
    }
    return $input;
}

function cdg_settings_page_html() {
    ?>
    <div class="wrap">
        <h1>Dashboard Gatekeeper Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'cdg_settings_group' );
            do_settings_sections( 'cdg_settings_group' );
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Dashboard Page Slug</th>
                    <td>
                        <input type="text" name="cdg_slug" value="<?php echo esc_attr( get_option( 'cdg_slug' ) ); ?>" class="regular-text" />
                        <p class="description">Enter the slug of the page (e.g., <code>my-dashboard</code>). The page <strong>must</strong> already be published.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * 2. CORE LOGIC
 */

function cdg_get_slug() {
    return get_option( 'cdg_slug', 'custom-dashboard' );
}

add_filter( 'login_redirect', function( $redirect_to, $request, $user ) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( ! in_array( 'administrator', $user->roles ) ) {
            return home_url( '/' . cdg_get_slug() . '/' );
        }
    }
    return $redirect_to;
}, 10, 3 );

add_action( 'admin_init', function() {
    if ( is_admin() && ! current_user_can( 'manage_options' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_safe_redirect( home_url( '/' . cdg_get_slug() . '/' ) );
        exit;
    }
});

add_action( 'after_setup_theme', function() {
    if ( ! current_user_can( 'manage_options' ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
    }
});

add_action( 'template_redirect', function() {
    if ( is_page( cdg_get_slug() ) ) {
        if ( ! is_user_logged_in() ) {
            wp_safe_redirect( home_url() );
            exit;
        }
    }
});
