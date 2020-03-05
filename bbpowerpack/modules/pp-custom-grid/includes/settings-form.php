<?php
foreach ( PPCustomGridModule::get_presets( 'all' ) as $preset_type => $preset_data ) :

    $count = 1;

    foreach ( $preset_data as $preset_name => $preset ) :

        FLBuilder::register_settings_form( $preset_name.'_preset', array(
            'title' => __( 'Customize Preset', 'bb-powerpack' ),
            'tabs'  => array(
                'html'          => array(
                    'title'         => __( 'HTML', 'bb-powerpack' ),
                    'sections'      => array(
                        'html'          => array(
                            'title'         => '',
                            'fields'        => array(
                                'original_html' => array(
                                    'type'          => 'pp-hidden-textarea',
                                    'default'       => PPCustomGridModule::get_preset_default( $preset_type, $count, 'html' ),
                                    'value'         => PPCustomGridModule::get_preset_default( $preset_type, $count, 'html' ),
                                    'rows'          => 5
                                ),
                                'html'          => array(
                                    'type'          => 'code',
                                    'editor'        => 'html',
                                    'label'         => '',
                                    'rows'          => '18',
                                    'default'       => PPCustomGridModule::get_preset_data( $preset_type, $count, 'html' ),
                                    'preview'           => array(
                                        'type'              => 'none',
                                    ),
                                    'connections'       => array( 'html', 'string' ),
                                ),
                            ),
                        ),
                    ),
                ),
                'css'           => array(
                    'title'         => __( 'CSS', 'bb-powerpack' ),
                    'sections'      => array(
                        'css'           => array(
                            'title'         => '',
                            'fields'        => array(
                                'original_css'  => array(
                                    'type'          => 'pp-hidden-textarea',
                                    'default'       => PPCustomGridModule::get_preset_default( $preset_type, $count, 'css' ),
                                    'value'         => PPCustomGridModule::get_preset_default( $preset_type, $count, 'css' ),
                                    'rows'          => 5
                                ),
                                'css'           => array(
                                    'type'          => 'code',
                                    'editor'        => 'css',
                                    'label'         => '',
                                    'rows'          => '18',
                                    'default'       => PPCustomGridModule::get_preset_data( $preset_type, $count, 'css' ),
                                    'preview'           => array(
                                        'type'              => 'none',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ));

        $count++;

    endforeach;

endforeach;
