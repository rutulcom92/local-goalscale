<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        'timeout' => false,
        'options' => array(
            'margin-top' => 25,
            'margin-right' => 3,
            'margin-left' => 3,
            'margin-bottom' => 10,
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => 'vendor/h4cc/wkhtmltoimage-amd64/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
);