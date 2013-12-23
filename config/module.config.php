<?php

return array(
    'view_manager' => array(
        'template_map' => array(
            'download/csv' => __DIR__ . '/../view/h-commons/download/csv.phtml',
            'hcommons/image/png' => __DIR__ . '/../view/h-commons/image/png.phtml',
        ),
        'strategies' => array(
            'ViewCsvStrategy',
            'HCommons\View\ImageStrategy'
        )
    )
);
