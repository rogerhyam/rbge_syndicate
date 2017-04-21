<?php

/*
Plugin Name: RBGE Syndication Plugin
Description: Generates a Javascript code to embed story in another site.
Version: 0.1
Author: Roger Hyam
License: GPL2
*/

add_action('add_meta_boxes', array('RbgeSyndicate','init') );
add_action('admin_head',  array('RbgeSyndicate','style'));
add_action('admin_head',  array('RbgeSyndicate','script'));

class RbgeSyndicate {

    // Create the function used in the action hook
    public static function init() {
        error_log("RbgeSyndicate:init");
        add_meta_box(
                    'rbge_syndicate_meta_box',
                    'RBGE Syndicate Code Generator',
                     array('RbgeSyndicate','render'),
                     'post',
                     'side'
                );
    }

    public static function render($post) {

       // base URI for the call in the javascript
       $base_url =  plugins_url('get_post.php', __FILE__);
       $script_start = "<script type=\"text/javascript\" src=\"$base_url?";
       $script_stop = "&amp;image_size=~IMAGE_SIZE~\" ></script>";

       echo '<div id="rbge-syndicate-meta-box">';
       
?>
        <p>Create javascript code to embed this story or the latest stories in a category in another website such as MODx.
        Choose what to embed and select an images size then click 'Get Code'. Paste the code into the raw HTML editor of the target website.</p>

        <p><strong>Note:</strong> Stories must have an image attached to appear!</p>

<?php
       
       echo '<select id="rbge-syndicate-meta-box-target" >';
       
       // first put in this post
       echo "<option value=\"0\">Embed this story</option>";
       $js[0] = $script_start . 'post_id=' . $post->ID . $script_stop;
       
       // work through the categories
       $post_categories = wp_get_post_categories( $post->ID );
       echo '<optgroup label="Latest in category:">';
       foreach($post_categories as $c){
            $cat = get_category( $c );
	        $name = $cat->name;
	        $slug = 'cat:' . $cat->slug;
            echo "<option value=\"$slug\">$name</option>";
            $js[$slug] = $script_start . 'category=' . $cat->slug . $script_stop;
       }
       echo '</optgroup>';
      
      
       // work through the tags
       $post_tags = wp_get_post_tags( $post->ID );
       echo '<optgroup label="Latest with tags">';
       foreach($post_tags as $t){
            $tag = get_tag( $t );
            $name = $tag->name;
            $slug = 'tag:'. $tag->slug;
            echo "<option value=\"$slug\">$name</option>";
            $js[$slug] = $script_start . 'tag=' . $tag->slug . $script_stop;
       }

       echo '</optgroup>';
       echo "</select>";
       echo '<select id="rbge-syndicate-meta-box-image-size" >';
       echo "<option value=\"thumbnail\" selected=\"true\">Image size: Thumbnail</option>";
       echo "<option value=\"small\">Image size: Small</option>";
       echo "<option value=\"medium\">Image size: Medium</option>";
       echo "<option value=\"large\">Image size: Large</option>";
       echo "<option value=\"full\">Image size: Original</option>";
       
       echo "</select>";
       
       
       // we put the data on the document to be called later
       echo '<script type="text/javascript">document.rbge_syndicate_date = ';
       echo json_encode($js);
       echo '</script>';
       
       echo '<a class="button" onclick="rbge_syndicate_changed();">Get Code</a>';
       
       
       echo '</div>';
       
    }
    
    public function script() {
        echo '<script type="text/javascript">';
        echo file_get_contents(plugins_url('plugin.js', __FILE__));
        echo '</script>';
    }
    
    
    public function style() {
      echo '<style>';
      echo file_get_contents(plugins_url('plugin_style.css', __FILE__));
      echo '</style>';
    }

}




?>