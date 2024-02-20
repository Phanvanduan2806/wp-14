<?php
/*
 * Template Name: page-wpfh_blocks_preview.php
 */
$use_in = @$_GET['use_in'];
echo <<<EOF
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<title>$use_in - preview</title>
EOF;

$arr_html = [];
$mergecode = new Wp_Flatsome_Helper_MergeCode($use_in);
$arr_html[] = $mergecode->getContentOfPost();
$arr_html = array_merge($arr_html, $mergecode->getContentsOfWpfhBlocks());
$html = implode('', $arr_html);
$html = htmlspecialchars_decode($html);

//echo '<!-- page-wpfh_blocks_preview 1 -->';
echo do_shortcode($html);
//echo '<!-- page-wpfh_blocks_preview 2 -->';

//$codes = $mergecode->extractCodeSections();
//var_dump($codes);
//die();
get_header();
get_footer();