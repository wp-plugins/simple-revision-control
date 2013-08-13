<?php

function simple_revision_control_options()
{
    $simple_revision_control_options = array();

    /**
     * main settings
     */
    $simple_revision_control_options['index'] = array(
        'use_tabs' => true,
        'version'  => '0.0',
        'options'  => array(
            array(
                'type' => 'heading',
                'label' => __( 'Number of revisions', 'simple_revision_control' ),
                'description' => __( 'Set <b>0</b> to unlimited revisions, set <b>1</b> to no revisions or set any other number.', 'simple_revision_control' ),
            ),
            array(
                'name'    => 'post',
                'class'   => 'small-text',
                'type'    => 'number',
                'th'      => __( 'Post', 'simple_revision_control' ),
                'default' => 0,
                'min'     => 0,
            ),
            array(
                'name'    => 'page',
                'class'   => 'small-text',
                'type'    => 'number',
                'th'      => __( 'Page', 'simple_revision_control' ),
                'default' => 0,
                'min'     => 0,
            ),
        ),
    );
    return simple_revision_control_add_custom_post_types_to_options( $simple_revision_control_options, 'index' );
}

function simple_revision_control_add_custom_post_types_to_options( $options, $options_group )
{
    $custom_post_types = get_post_types( array( '_builtin' => false ), 'object' );
    if ( empty( $custom_post_types ) ) {
        return $options;
    }
    $header = true;
    foreach( $custom_post_types as $name => $post_type ) {
        if ( !post_type_supports( $name, 'revisions' ) ) {
            continue;
        }
        if ( $header ) {
            $options[$options_group]['options'][] = array(
                'type' => 'heading',
                'label' => __( 'Custom Post Types', 'simple_revision_control' ),
            );
        }
        $header = false;
        $options[$options_group]['options'][] = array(
            'name' => $name,
            'class' => 'small-text',
            'type' => 'number',
            'th' => $post_type->label,
            'default' => 0,
            'min' => 0,
        );
    }
    return $options;
}

