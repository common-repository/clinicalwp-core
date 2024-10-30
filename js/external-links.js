jQuery(document).ready(function($){
    jQuery.expr[':'].external = function(obj) {
        return !obj.href.match(/^mailto\:/) && (obj.hostname != location.hostname) && (obj.hostname !== '') && (obj.hostname != ' ') && (obj.hostname != '#') && (obj.hostname != 'javascript:');
    };
    jQuery('a:external').attr('target','_blank');
}); //.ready