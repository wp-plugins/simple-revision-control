<?php

/*

Copyright 2013 Marcin Pietrzak (marcin@iworks.pl)

this program is free software; you can redistribute it and/or modify
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

if ( !defined( 'WPINC' ) ) {
    die;
}

if ( class_exists( 'SimpleRevisionControl' ) ) {
    return;
}

class SimpleRevisionControl
{
    private $dev;
    private $options;
    private static $base;
    private static $capability;
    private static $dir;
    private static $version;
    private $working_mode;

    public function __construct()
    {
        /**
         * static settings
         */
        $this->version         = '0.0.0';
        $this->base            = dirname( __FILE__ );
        $this->dir             = basename( dirname( $this->base ) );
        $this->capability      = apply_filters( 'simple_revision_control_capability', 'manage_options' );
        $this->dev             = ( defined( 'IWORKS_DEV_MODE' ) && IWORKS_DEV_MODE )? '.dev':'';
        /**
         * generate
         */
        add_action( 'init', array( &$this, 'init' ) );
        /**
         * global option object
         */
        global $simple_revision_control_options;
        $this->options = $simple_revision_control_options;
    }

    public function get_version( $file = null )
    {
        if ( defined( 'IWORKS_DEV_MODE' ) && IWORKS_DEV_MODE ) {
            if ( null != $file ) {
                $file = dirname( dirname ( __FILE__ ) ) . $file;
                return md5_file( $file );
            }
            return rand( 0, 99999 );
        }
        return $this->version;
    }

    public function init()
    {
        add_action( 'admin_init', 'simple_revision_control_options_init' );
        add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
        add_filter( 'wp_revisions_to_keep', array( &$this, 'wp_revisions_to_keep' ), PHP_INT_MAX, 2 );
    }

    public function wp_revisions_to_keep( $num, $post )
    {
        $revisions =  $this->options->get_option( $post->post_type );
        if ( empty( $revisions ) ) {
            return $num;
        }
        return $revisions;
    }

    public function admin_init()
    {
        add_filter( 'plugin_row_meta', array( &$this, 'plugin_row_meta' ), 10, 2 );
    }

    public function plugin_row_meta( $links, $file )
    {
        if ( $this->dir.'/simple_revision_control.php' == $file ) {
            if ( !is_multisite() && current_user_can( $this->capability ) ) {
                $links[] = '<a href="themes.php?page='.$this->dir.'/admin/index.php">' . __( 'Settings' ) . '</a>';
            }
            $links[] = '<a href="http://iworks.pl/donate/simple_revision_control.php">' . __( 'Donate' ) . '</a>';
        }
        return $links;
    }

    public function admin_menu()
    {
        add_options_page(
            __( 'Revisions', 'simple_revision_control' ),
            __( 'Revisions', 'simple_revision_control' ),
            $this->capability,
            null,
            array( &$this, 'render_option_page' )
        );
    }

    public function update()
    {
    }

    public function render_option_page()
    {
        include_once ABSPATH.'wp-admin/includes/meta-boxes.php';
        $this->update();
?>
<div class="wrap">
    <?php screen_icon(); ?>
    <h2><?php _e( 'Simple Revision Control', 'simple_revision_control') ?></h2>
    <form method="post" action="options.php" id="simple_revision_control_admin_index">
        <div class="postbox-container" style="width:75%">
<?php
        $option_name = 'index';
        $this->options->settings_fields( $option_name );
        $this->options->build_options( $option_name );
?>
        </div>
        <div class="postbox-container" style="width:23%;margin-left:2%">
            <div class="metabox-holder">
                <div id="help" class="postbox">
                    <h3 class="hndle"><?php _e( 'Need Assistance?', 'simple_revision_control' ); ?></h3>
                    <div class="inside">
                        <p><?php _e( 'Problems? The links bellow can be very helpful to you', 'simple_revision_control' ); ?></p>
                        <ul>
                            <li><a href="<?php _e( 'http://wordpress.org/tags/simple-revision-control', 'simple_revision_control' ); ?>"><?php _e( 'Wordpress Help Forum', 'simple_revision_control' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
    }

}

