
function rbge_syndicate_changed(){
    
    var targetSelect = document.getElementById("rbge-syndicate-meta-box-target");
    var imageSelect = document.getElementById("rbge-syndicate-meta-box-image-size");
    
    var slug = targetSelect.options[targetSelect.selectedIndex].value;
    var imageSize = imageSelect.options[imageSelect.selectedIndex].value;
    
    var template = document.rbge_syndicate_date[slug];
    var out = template.replace("~IMAGE_SIZE~", imageSize);
    
    window.prompt("Copy to clipboard: Ctrl+C (or Cmd-C on Mac) then Enter", out);
    
}
