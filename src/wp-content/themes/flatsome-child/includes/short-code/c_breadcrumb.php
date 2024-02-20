<?php
add_shortcode('c_breadcrumb', function () {
    if (is_single() || is_category() || is_page()) {
        $breadcrumb_html = '<nav aria-label="Breadcrumb"><ul class="breadcrumb nav">';
        $breadcrumb_html .= '<li class="breadcrumb-item"><a href="' . get_bloginfo('url') . '">Trang chủ</a></li>';
        if (is_category() || is_single()) {
            $category = get_the_category();
            if ($category) {
                $cat = $category[0];
                $breadcrumb_html .= '<li class="breadcrumb-item"><a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a></li>';
            }
        }
        if (is_single()) {
            $breadcrumb_html .= '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
        }
        if (is_page()) {
            $breadcrumb_html .= '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
        }
        $breadcrumb_html .= '</ul></nav>';
        $css =<<<EOF
<style>
.breadcrumb li{margin-left: 0!important;}
.breadcrumb-item + .breadcrumb-item::before { content: ">>";padding: 0 10px;}
</style>
EOF;

        return $breadcrumb_html.$css;
    }
    return '';
});

