/* Fullwidth stretcher v1.0 */
jQuery.fn.fullwidth_stretcher = function(o){
    
    var _this = jQuery(this),
        _window = jQuery(window); 
        
    if(_this.length > 0) {       
        _window.resize(stretch);
        stretch();
    }
    
    function stretch(){        
        var _windowWidth = _window.width(),
            leftOffset = _this.parent().offset().left;
         
        _this.css({width:_windowWidth, left:-leftOffset});
    }  
}