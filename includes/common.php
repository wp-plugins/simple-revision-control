<?php

/**
 * require: SimpleRevisionControl Class
 */
if ( !class_exists( 'SimpleRevisionControl' ) ) {
    require_once dirname( __FILE__ ).'/class-simple-revision-control.php';
}
/**
 * configuration
 */
require_once dirname( dirname( __FILE__ )).'/etc/options.php';

/**
 * require: IworksOptions Class
 */
if ( !class_exists( 'IworksOptions' ) ) {
    require_once dirname( __FILE__ ).'/class-iworks-options.php';
}

/**
 * i18n
 */
load_plugin_textdomain( 'simple_revision_control', false, dirname( dirname( plugin_basename( __FILE__) ) ).'/languages' );

/**
 * load options
 */
$simple_revision_control_options = new IworksOptions();
$simple_revision_control_options->set_option_function_name( 'simple_revision_control_options' );
$simple_revision_control_options->set_option_prefix( SIMPLE_REVISION_CONTROL_PREFIX );

function simple_revision_control_options_init()
{
    global $simple_revision_control_options;
    $simple_revision_control_options->options_init();
}

function simple_revision_control_activate()
{
    $simple_revision_control_options = new IworksOptions();
    $simple_revision_control_options->set_option_function_name( 'simple_revision_control_options' );
    $simple_revision_control_options->set_option_prefix( SIMPLE_REVISION_CONTROL_PREFIX );
    $simple_revision_control_options->activate();
}

function simple_revision_control_deactivate()
{
    global $simple_revision_control_options;
    $simple_revision_control_options->deactivate();
}

