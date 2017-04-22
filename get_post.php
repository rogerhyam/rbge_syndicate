<?php

require_once('../../../wp-load.php');
add_theme_support( 'post-thumbnails' );
require_once('classes/RbgeSyndicateFront.php');
$front = new RbgeSyndicateFront();

$front->write_javascript_include();

/*

// make use of wordpress functions
require('../../../wp-load.php');
add_theme_support( 'post-thumbnails' );

// either get a single post or look to get a list
if(isset($_GET['post_id'])){
    $myposts[] = get_post($_GET['post_id']);
}else{
    // set up the arguments for fetching the posts
    $args = array();

    // standards for everything
    $args['posts_per_page'] = 10; // maximum of 10
    $args['post_type'] = 'post'; // only posts
    $args['post_status'] = 'publish'; // only published

    // if we have set the category then only from that category
    if(isset($_GET['category'])) $args['category_name'] = $_GET['category'];

    // if they have set a tag use that
    if(isset($_GET['tag'])) $args['tag'] = $_GET['tag'];
    
    // restrict to a particular year
    if(isset($_GET['year'])) $args['year'] = $_GET['year'];
    
    // set the ordering but defaults is desc
    if(isset($_GET['order'])) $args['order'] = $_GET['order'];

    // set the order field but defaults to date
    if(isset($_GET['orderby'])) $args['orderby'] = $_GET['orderby'];
    
    // number of posts to display (max)
    if(isset($_GET['number'])){
        $args['posts_per_page'] = $_GET['number']; 
    }else{
        $args['posts_per_page'] = 10; 
    }
    
    $myposts = get_posts( $args );
    
}

// what kind of picture do we want?
if(isset($_GET['image_size'])) $image_size = $_GET['image_size'];
else $image_size = 'thumbnail';

// loop through the posts
foreach ( $myposts as $post ){
    
    setup_postdata($post);
    
    // we use the 
    if(has_post_thumbnail()){
        $image = get_the_post_thumbnail($get_ID, $image_size);
    }else{
        // no thumbnail so use the first attached image
        $images = get_attached_media( 'image/jpeg' );
        if(count($images)> 0){
            $keys = array_keys($images);
            $image_id = $images[$keys[0]]->ID;
            $image =  wp_get_attachment_image( $image_id, $image_size );
        }else{
            // no image to show so give up on this one
            continue;
        }
    }
    
    echo '<div class="botanics-stories-promo">';
    
    echo '<a  href="' . get_permalink() . '">';
    //the_post_thumbnail($image_size);
    
    echo $image;
    echo '</a>';
        
    echo '<a  href="' . get_permalink() . '">';
    echo "<h3>";
    the_title();
    echo "</h3>";
    echo '</a>';
    
    the_excerpt();
    
    echo '<span class="botanics-stories-link-back">From&nbsp;<a href="http://stories.rbge.org.uk" >Botanics&nbsp;Stories</a></span>';
    
    echo "</div>";
    wp_reset_postdata();
} 

ob_end_flush();

function wrap_as_javascript($buffer){
    
    // write out the css first
    $style = '<style type="text/css" >';
    $style .= file_get_contents('style.css');
    $style .= '</style>';    
    
    // then the content
    $out = "document.write("  .  json_encode($style) .   ");\n";
    $out .= 'document.write('  .  json_encode($buffer) .   ");\n";
    
    return $out;
}

*/


?>