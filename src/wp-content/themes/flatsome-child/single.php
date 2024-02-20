<?php
/**
 * The blog template file.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

get_header();

function get_post_excerpt() {
    $post_id = get_the_ID();
    $excerpt = get_the_excerpt($post_id);
    if (empty($excerpt)) {
        $content = get_the_content();
        $excerpt = wp_trim_words($content, 30);
    }
    return strip_tags($excerpt);
}

if (have_posts()) {
    the_post();
    $title = get_the_title();
    $content = get_the_content();
    $excerpt = get_post_excerpt();
    $website_url = get_field('website_url', get_the_ID());
    $thumbnail_id = get_post_thumbnail_id();

}
$buttons1 = <<<EOF
[button text="Xem Website" expand="true" letter_case="lowercase" radius="6" link="$website_url" target="_blank" rel="nofollow" class="sb-btn-1 sb-btn"]
[button text="Đặt hàng ngay" expand="true" letter_case="lowercase" style="outline" radius="6" link="tel:123123123" class="sb-btn-2 sb-btn"]
EOF;
$buttons2 = <<<EOF
[button text="Xem Website" letter_case="lowercase" radius="6" link="$website_url" target="_blank" rel="nofollow" class="sb-btn-1 sb-btn"]
[button text="Đặt hàng ngay" letter_case="lowercase" style="outline" radius="6" link="tel:123123123" class="sb-btn-2 sb-btn"]
EOF;

$html = <<<EOF
[section label="c-chitiet-baiviet" class="c-chitiet-baiviet"]

[row]

[col span="4" span__sm="12" span__md="12"]

[ux_html]
[c_breadcrumb]
[/ux_html]
[ux_text font_size="1.2" text_color="rgb(222, 166, 13)" class="c-title"]

<h1>$title</h1>
[/ux_text]
<p>$excerpt</p>
$buttons1
[gap height="20px"]

[follow style="small" facebook="#" twitter="#" email="#" pinterest="#" linkedin="3"]

[/col]
[col span="8" span__sm="12" span__md="12"]

[ux_image id="$thumbnail_id"]

[gap height="50px" height__md="30px"]

$buttons2
[ux_html]
$content
[/ux_html]
[/col]

[/row]

[/section]
EOF;
echo do_shortcode($html);
get_footer();
