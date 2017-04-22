<?php

class RbgeSyndicateFront {

    
    public function get_tag_content($params){
        wp_enqueue_style( 'rbge_syndicate_css' );
        return $out . $this->get_content($params);
    }
    
    function write_javascript_include(){
        
        $style = '<style type="text/css" >';
        $style .= file_get_contents('style.css');
        $style .= '</style>';
        
        $content = $this->get_content($_GET);

        // then the content
        echo "document.write("  .  json_encode($style) .   ");\n";
        echo "document.write("  .  json_encode($content) .   ");\n";

    }
    
    function get_content($params){
        
        global $post;
        $out = '';

        // either get a single post or look to get a list
        if(isset($params['post_id'])){
            $myposts[] = get_post($params['post_id']);
        }else{
            // set up the arguments for fetching the posts
            $args = array();

            // standards for everything
            $args['posts_per_page'] = 10; // maximum of 10
            $args['post_type'] = 'post'; // only posts
            $args['post_status'] = 'publish'; // only published

            // if we have set the category then only from that category
            if(isset($params['category'])) $args['category_name'] = $params['category'];

            // if they have set a tag use that
            if(isset($params['tag'])) $args['tag'] = $params['tag'];

            // restrict to a particular year
            if(isset($params['year'])) $args['year'] = $params['year'];

            // set the ordering but defaults is desc
            if(isset($params['order'])) $args['order'] = $params['order'];

            // set the order field but defaults to date
            if(isset($params['orderby'])) $args['orderby'] = $params['orderby'];

            // number of posts to display (max)
            if(isset($params['number'])){
                $args['posts_per_page'] = $params['number']; 
            }else{
                $args['posts_per_page'] = 10; 
            }

            $myposts = get_posts( $args );

        }

        // what kind of picture do we want?
        if(isset($params['image_size'])) $image_size = $params['image_size'];
        else $image_size = 'thumbnail';

        // loop through the posts
        foreach ( $myposts as $post ){
            
            setup_postdata($post);
            
            // we use the 
            if(has_post_thumbnail()){
                $image = get_the_post_thumbnail($post->ID, $image_size);
            }else{
                // no thumbnail so use the first attached image
                $images = get_attached_media( 'image/jpeg');
                if(count($images)> 0){
                    $keys = array_keys($images);
                    $image_id = $images[$keys[0]]->ID;
                    $image =  wp_get_attachment_image( $image_id, $image_size );
                }else{
                    // no image to show so give up on this one
                    continue;
                }
            }
            
            $out .=  '<div class="botanics-stories-promo">';

            $out .= '<a  href="' . get_permalink() . '">';

            $out .= $image;
            $out .= '</a>';

            $out .= '<a  href="' . get_permalink() . '">';
            $out .= "<h3>";
            $out .= get_the_title();
            $out .= "</h3>";
            $out .= '</a>';
            $out .= get_the_excerpt();
            $out .= "</div>";
            
            wp_reset_postdata();
        }
        
        return $out;
    }
    


}

?>