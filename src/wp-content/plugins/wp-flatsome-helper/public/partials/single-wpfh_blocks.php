<?php

$post_id = get_the_ID();
$raw_content = get_post_field('post_content', $post_id);
echo <<<EOF
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
EOF;
echo do_shortcode($raw_content);

echo <<<EOF
<style>
#wpadminbar,#wrapper{display: none;}
</style>
EOF;

get_header();
get_footer();