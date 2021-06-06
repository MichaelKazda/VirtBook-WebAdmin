// Popup window to confirm submit of form
$(document).ready(function () {
    var popup = $(document).find('#popup');
    var overlay = $(document).find('.overlay');
    $('#submitPopup').click(function(event){
        event.preventDefault();
        if (popup.css('display') === 'none') {
            popup.show();
            overlay.show();
        }else {
            popup.hide();
            overlay.hide();
        }
    });

    $('#popupNo').click(function(){
        popup.hide();
        overlay.hide();
    });
    $(document).click(function(event){
       if(popup.css('display') !== 'none' && $(event.target).closest(popup).length === 0 && $(event.target).closest('#submitPopup').length === 0){
           popup.hide();
           overlay.hide();
       }
    });
    $('#popupYes').click(function(){
        $('#form').submit();
    });
});