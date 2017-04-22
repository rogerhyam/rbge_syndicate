

jQuery( document ).ready(function() {
    
    // only run the init if the map div has been loaded
    jQuery("#rbge-syndicate-short-code-btn").on('click', function(event){
       
       var cat_tag_id = jQuery('#rbge-syndicate-meta-box-target').val();
       var imageSize = jQuery('#rbge-syndicate-meta-box-image-size').val();
       
       var out = '[rbge_post_list ';
       
       if(!isNaN(parseInt(cat_tag_id))) out += 'post_id="' + cat_tag_id + '" ';
       if(cat_tag_id.startsWith('tag:')) out += 'tag="' + cat_tag_id.substring(4) + '" ';
       if(cat_tag_id.startsWith('cat:')) out += 'cat="' + cat_tag_id.substring(4) + '" ';
       
       out += ']';
       
       window.prompt("Copy to clipboard: Ctrl+C (or Cmd-C on Mac) then Enter", out);
       
    });
    
    jQuery("#rbge-syndicate-javascript-btn").on('click', function(event){
         
         var cat_tag_id = jQuery('#rbge-syndicate-meta-box-target').val();
         var imageSize = jQuery('#rbge-syndicate-meta-box-image-size').val();
         var baseUri = jQuery('#rbge-syndicate-meta-box-base-uri').val();
         
         var out = '<script type="text/javascript" src="';
         out += baseUri;
         out += '?';
         if(!isNaN(parseInt(cat_tag_id))) out += 'post_id=' + cat_tag_id + '&amp;';
         if(cat_tag_id.startsWith('tag:')) out += 'tag=' + cat_tag_id.substring(4) + '&amp;';
         if(cat_tag_id.startsWith('cat:')) out += 'cat=' + cat_tag_id.substring(4) + '&amp;';
         out += '" ></script>';
         
         window.prompt("Copy to clipboard: Ctrl+C (or Cmd-C on Mac) then Enter", out);
         
        
    });
    

});

function rbge_syndicate_fire_help(){
    window.scrollTo(0, 0);
    jQuery('#contextual-help-link').click();
    jQuery('#tab-link-rbge_syndicate_help a').click();
    return false;
}