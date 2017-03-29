<?php

return array(

    'pdf'   => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltopdf',
        'timeout' => false,

        'options' => array(
            'page-size'        => 'A4',
            'margin-top'       => 5,
            'margin-right'     => 5,
            'margin-left'      => 5,
            'margin-bottom'    => 6,
            'orientation'      => 'Portrait',
            // 'footer-center'    => 'Page [page] of [toPage]',
            // 'footer-font-size' => 10,
            'header-font-size' => 10,
            //  'footer-left'      => 'Confidential',
            //  'footer-right'     => 'Sothebys ',
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),

);
