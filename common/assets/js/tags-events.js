/**
 * Created by El Teta on 06/04/2017.
 */
var lostFocus = false;
var FIELD_ID = 'tagsValidationModel';
var tags = [];


$(function(){
    initTags();
    $(".tag-field").click(tagBtnClick);

})

var initTags = function(){
    var tagsText = $("#"+FIELD_ID).val();
    if(!tagsText || tagsText == "") return;
    tags = tagsText.split(',');
    for(var tag in tags){
        tag = tags[tag];
        var label = "<span class='tag-label'>" + tag +"</span>";
        var btn = "<span class='btn btn-danger close-tag-field'><span class='glyphicon glyphicon-remove'></span></span>";
        var html = "<span class='tag-field-group'>" + label + btn + "</span>";
        $(".tag-field").prepend(html);
    }

    $(".close-tag-field").click(closeTagField);
}

var tagBtnClick = function(e){
	if(lostFocus){
		lostFocus = false;
		return;
	}
    var field = "<span class='tag-field-group'><input type='text' class='tag-field-input'><span class='btn btn-danger close-tag-field'><span class='glyphicon glyphicon-remove'></span></span></span>";
    var f = $(field);
	$(this).append(f);
   
    f.find("input").focus();

    $(".close-tag-field").click(closeTagField);
    $(".tag-field-input").focusout(tagInputWriten)


}

var closeTagField = function(e){
    $(this).parent().remove();

    tags = [];
    $(".tag-label").each(function(tag){
        tags.push($(this).html());
    })
    $("#" + FIELD_ID).attr('value', tags.toString());
}

var tagInputWriten = function(){
    var text = $(this).val();
    text = text.trim();
    if(text != ""){
        var span = "<span class='tag-label'>" + text +"</span>";
        $(span).insertAfter($(this));
        $(this).remove();
        tags.push(text);
        $("#" + FIELD_ID).attr('value', tags.toString());
    }else{
        $(this).parent().remove();
    }
	 
	 lostFocus = true;
}