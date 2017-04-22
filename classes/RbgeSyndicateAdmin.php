<?php

class RbgeSyndicateAdmin {

    // Create the function used in the action hook
    public static function init() {
        error_log("RbgeSyndicate:init");
        add_meta_box(
                    'rbge_syndicate_meta_box',
                    'RBGE Syndicate Code Generator',
                     array('RbgeSyndicateAdmin','render'),
                     'post',
                     'side'
                );
    }

    public static function render($post) {

       // base URI for the call in the javascript
       $base_url =  plugin_dir_url() . 'rbge_syndicate/get_post.php';
       $script_start = "<script type=\"text/javascript\" src=\"$base_url?";
       $script_stop = "&amp;image_size=~IMAGE_SIZE~\" ></script>";

       echo '<div id="rbge-syndicate-meta-box">';
       
?>
        <p>Embed this story or the latest stories in a category or tag on this site (with a Short Code) or on an unrelated site (with Javascript). 
        [<a href="#" onclick="return rbge_syndicate_fire_help();" >Help</a>]    
        </p>

<?php
       echo '<input id="rbge-syndicate-meta-box-base-uri" type="hidden" value="'.$base_url.'"/>';
       
       echo '<select id="rbge-syndicate-meta-box-target" >';
       
       // first put in this post
       echo "<option value=\"$post->ID\">Embed this post</option>";
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
      
      
       echo '<a class="button" id="rbge-syndicate-short-code-btn" >Short Code</a>'; 
       echo '<a class="button" id="rbge-syndicate-javascript-btn">Javascript</a>';
      
       
       echo '</div>';
       
    }
    
    public static function help(){

           $help = '

           <h3>RBGE Syndicate</h3>
           <p>
              Use this plugin to generate a pretty looking list of posts either on a post within this site or as a Javascript include in the HTML of another website.
              <strong>Note:</strong> Posts must have an image to appear in the list and it is recommended you specify a featured image or results can be unpredictable.
           </p>
           <p>
             Choose to display this post or the latests posts from a tag or category using the drop down list, select the image size you require then click one of the two buttons.
           <p/>
           <p>
               Clicking the <strong>Short Code</strong> button gives a square bracket code that can be pasted into a post on this site.
           </p>
           <p>
               Clicking the <strong>Javascript</strong> button gives a piece of Javascript code that can be included in the HTML of another site.
               Be aware that most rich text editors will strip this code from the page when you click save so you must only include it in raw HTML.
           </p>
           <p>
               <strong>Advanced Options:</strong> By default the first ten posts will be listed but you can set this to another number by manually including a number parameter in the code supplied by the wizard.
           </p>
           ';

           if ($screen = get_current_screen()) {
                   $screen->add_help_tab(array(
                       'id' => 'rbge_syndicate_help',
                       'title' => 'RBGE Syndicate',
                       'content' => $help,
                   ));
           }

       }
    

}

?>