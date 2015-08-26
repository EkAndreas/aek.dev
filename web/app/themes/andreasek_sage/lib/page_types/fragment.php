<?php

class Fragment_Page_Type extends Papi_Page_Type
{
    public function page_type()
    {
        return [
            'name'        => 'Fragment',
            'description' => 'Part of other pages for reuse',
            'template'    => 'templates/fragment.php',
            'post_type'   => [ 'page' ],
        ];
    }

    public function register()
    {
        $this->box( 'Description', [
            $this->property( [
                'type'  => 'text',
                'title' => 'Description',
                'slug'  => 'description',
            ] ),
        ] );
    }

}