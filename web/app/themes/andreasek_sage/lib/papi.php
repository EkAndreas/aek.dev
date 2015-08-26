<?php

function _site_papi_page_type_directories()
{
    return get_template_directory() . '/lib/page_types';
}
add_filter( 'papi/settings/directories', '_site_papi_page_type_directories' );