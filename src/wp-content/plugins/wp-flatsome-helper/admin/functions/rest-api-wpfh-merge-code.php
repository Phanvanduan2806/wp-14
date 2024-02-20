<?php
function wpfh_merge_code($request)
{
    $payload = $request->get_json_params();
    $use_in = $payload['use_in'];
    $mergecode = new Wp_Flatsome_Helper_MergeCode($use_in);
    $mergecode->getContentsOfWpfhBlocks();

    $codes = $mergecode->extractCodeSections();
    foreach ($codes as $key => $code) {
        $file_path = get_stylesheet_directory() . '/assets/' . $use_in;
        $file_name = 'c-style.css';
        if ($key == 'css_responsive') $file_name = 'c-responsive.css';
        if ($key == 'js_code') $file_name = 'c-script.js';
        $code = implode('', $code);
        $mergecode->createAssetFile($file_path . '/' . $file_name, $code);
    }

    $sectionWithoutCode = $mergecode->getSectionWithoutCode();
    $post_id = $mergecode->appendCodeToPage($sectionWithoutCode);

    $enqueue_code = <<<EOF
// $use_in
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'c-$use_in-style-css', get_stylesheet_directory_uri() . '/assets/$use_in/c-style.css', [], WP_FLATSOME_ASSET_VERSION );
    wp_enqueue_style( 'c-$use_in-responsive-css', get_stylesheet_directory_uri() . '/assets/$use_in/c-responsive.css', [], WP_FLATSOME_ASSET_VERSION );
}, 999);
add_action( 'wp_footer', function () {
    wp_enqueue_script( 'c-$use_in-script-js', get_stylesheet_directory_uri() . '/assets/$use_in/c-script.js', [], WP_FLATSOME_ASSET_VERSION );
});
EOF;
    return ['enqueue_code'=>$enqueue_code, 'post_id' => $post_id];
}