jQuery(document).ready(function() {
    resizeNav();
    jQuery('.navbar-toggler').click(function(){
        jQuery('#wrap').toggleClass('menu-opened');
        jQuery('#wpadminbar').toggleClass('menu-opened');
        resizeNav();
    })
});
jQuery(window).on('resize', resizeNav);

function resizeNav(){
    var nav_content = jQuery("#navbarSupportedContent");
    //if(nav_content.hasClass('show')){
        var heigth_logo = jQuery('.div-logo').height();
        var admin_bar = jQuery('#wpadminbar');
        var tam = heigth_logo;
        if(admin_bar) {
            tam += admin_bar.height();
        }
        var windowHeight = jQuery(window).height() - tam;
        nav_content.css('top',heigth_logo);
        nav_content.css('min-height',windowHeight);
    //}
}
