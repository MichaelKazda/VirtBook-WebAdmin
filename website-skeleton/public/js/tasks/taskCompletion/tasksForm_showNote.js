$(document).ready(function() {
    $('.switchBox').each(function (){
        var checkBox = $(this).find('input:checkbox');
        var hiddenPart = $(this).find('.inputPartHidden');

        // For first load
        if (checkBox.is(':checked')){
            hiddenPart.show();
        }else if(checkBox.not(':checked')){
            hiddenPart.hide();
        }

        // For change on checkBox
        checkBox.change(function () {
            if (checkBox.is(':checked')){
                hiddenPart.show();
            }else if(checkBox.not(':checked')){
                hiddenPart.hide();
            }
        });
    });

});