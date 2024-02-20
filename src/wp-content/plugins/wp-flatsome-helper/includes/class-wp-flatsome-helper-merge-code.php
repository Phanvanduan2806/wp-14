<?php

class Wp_Flatsome_Helper_MergeCode
{
    private $use_in;
    private $post_id;
    private $arr_section;

    public function __construct($use_in)
    {
        $this->use_in = $use_in;
        $last_dot_index = strrpos($this->use_in, '.');
        $post_id = ($last_dot_index !== false) ? substr($this->use_in, $last_dot_index + 1) : '';
        $this->post_id = $post_id;
    }

    public function createAssetFile($file_path, $content)
    {
        if (file_exists($file_path)) {
            error_log('Error: File already exists.');
            return false;
        }
        $directory = dirname($file_path);
        if (!file_exists($directory)) {
            if (!mkdir($directory, 0755, true)) {
                error_log('Error: Failed to create directory.');
                return false;
            }
        }
        if (file_put_contents($file_path, $content) === false) {
            error_log('Error: Failed to write to file.');
            return false;
        }
        return true;
    }

    public function appendCodeToPage($sectionWithoutCode)
    {
        $post_id = $this->post_id;
        $post = get_post($post_id);
        if ($post) {
            $new_content = $post->post_content . $sectionWithoutCode;
            $updated_post = array(
                'ID' => $post_id,
                'post_content' => $new_content,
            );
            wp_update_post($updated_post);
            return $post_id;
        }
        error_log("Post with ID $post_id not found.");
        return false;
    }

    public function getSectionWithoutCode()
    {
        $str_section = implode('', $this->arr_section);
        $patterns = array(
            'css_code' => '/\[ux_html[^\]]+css_code[^\]]+\](.*?)\[\/ux_html\]/s',
            'css_responsive' => '/\[ux_html[^\]]+css_responsive[^\]]+\](.*?)\[\/ux_html\]/s',
            'js_code' => '/\[ux_html[^\]]+js_code[^\]]+\](.*?)\[\/ux_html\]/s',
        );
        foreach ($patterns as $pattern) {
            $str_section = preg_replace($pattern, '', $str_section);
        }
        return $str_section;
    }

    public function extractCodeSections()
    {
        $output = array();
        $patterns = array(
            'css_code' => '/\[ux_html[^\]]+css_code[^\]]+\]<style>(.*?)<\/style>/s',
            'css_responsive' => '/\[ux_html[^\]]+css_responsive[^\]]+\]<style>(.*?)<\/style>/s',
            'js_code' => '/\[ux_html[^\]]+js_code[^\]]+\]<script>(.*?)<\/script>/s',
        );
        $str_section = implode('', $this->arr_section);
        $str_section = htmlspecialchars_decode($str_section);
        foreach ($patterns as $key => $pattern) {
            preg_match_all($pattern, $str_section, $matches);
            $output[$key] = isset($matches[1]) ? $matches[1] : array();
        }
        return $output;
    }

    public function getContentOfPost()
    {
        return get_post_field('post_content', $this->post_id);
    }

    public function getContentsOfWpfhBlocks()
    {
        $args = array(
            'post_type' => 'wpfh_blocks',
            'tax_query' => array(
                array(
                    'taxonomy' => 'use_in',
                    'field' => 'name',
                    'terms' => $this->use_in,
                ),
            ),
        );
        $query = new WP_Query($args);
        $results = array();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $content = get_the_content();
                $results[] = $content;
            }
            wp_reset_postdata();
        }
        $this->arr_section = $results;
        return $results;
    }

}
