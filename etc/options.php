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
                'type'              => 'heading',
                'label'             => __( 'Number of revisions', 'simple_revision_control' ),
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
    return $simple_revision_control_options;
}

