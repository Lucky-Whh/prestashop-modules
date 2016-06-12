$(document).ready(function(){
    $("#image-selectbutton").click(function(e){
        $("#image").trigger("click");
    });
    $("#image").change(function(e){
        var val = $(this).val();
        var file = val.split(/[\/]/);
        $("#image-name").val(file[file.length-1]);
    });
});
var floor_type = new Array('Default', 'Category', 'New', 'Special', 'Topic');
$('#floor_type').change(function(){
    for (i in floor_type)
    {
        var a = $(this).val();
        var b = floor_type[i];

        if ($(this).val() == floor_type[i])
            $('#' + floor_type[i] + '_floor_div').show(400);
        else
            $('#' + floor_type[i] + '_floor_div').hide(200);
    }
});
for (i in floor_type)
{
    $('#' + floor_type[i] + '_select_remove').click(function() {
        removeFloorOption(this);
    });
    $('#' + floor_type[i] + '_select_add').click(function() {
        addFloorOption(this);
    });
}
function removeFloorOption(item)
{
    var id = $(item).attr('id').replace('_remove', '');
    $('#' + id + '_2 option:selected').remove().appendTo('#' + id + '_1');
}
function addFloorOption(item)
{
    var id = $(item).attr('id').replace('_add', '');
    $('#' + id + '_1 option:selected').remove().appendTo('#' + id + '_2');
}
function addTopicGroup()
{
    var i = parseInt($("input[name=topic_group]").val()) + 1;
    var content = getTopicGroup(i);
    $('#topic_group_table').append(content);
    $("#image-selectbutton-"+i).click(function(e){
        $("#image_"+i).trigger("click");
    });
    $("#image_"+i).change(function(e){
        var val = $(this).val();
        var file = val.split(/[\/]/);
        $("#image-name-"+i).val(file[file.length-1]);
    });
}
function getTopicGroup(i){
    $("input[name=topic_group]").val(i);
    return "<tr id='topic_group_"+i+"_tr'>"+
        "<td><a class='btn btn-default' href='javascript:removeTopicGroup("+i+");'>"+
        "<i class='icon-remove text-danger'></i></a> </td>"+
        "<td><div class='animation form-group' id='animation_image'><label class='control-label col-lg-3'>选择文件：</label>"+
        "<div class='col-lg-6'>"+
        "<input id='image_"+i+"' type='file' name='image[value]' class='hide'>"+
        " <input type='hidden' name='imagehidden' value=''>"+
        "<div class='dummyfile input-group'>"+
        " <span class='input-group-addon'><i class='icon-file'></i></span>"+
        " <input id='image-name-"+i+"' type='text' class='disabled' name='animation[image[value]]' value='' readonly=''>"+
        "<span class='input-group-btn'>"+
        " <button id='image-selectbutton-"+i+"' type='button' name='submitAddAttachments' class='btn btn-default'>"+
        "<i class='icon-folder-open'></i> 上传文件"+
        "</button></span></div></div><div class='clear'></div></div>"+
        "<div class='form-group'>"+
        " <label class='control-label col-lg-3'>Title</label>"+
        "<div class='col-lg-9'>"+
        " <input type='hidden' name='topic_group[]' value='"+i+"'>"+
        "<input class='form-control' type='text' name='topic_group_"+i+"[tit]' value=''>"+
        "</div></div>"+
        "<div class='form-group'>"+
        "<label class='control-label col-lg-3'>描述</label>"+
        "<div class='col-lg-9'>"+
        "<input class='form-control' type='text' name='topic_group_"+i+"[desc]' value=''>"+
        "</div></div>"+
        " <div class='form-group'>"+
        "<label class='control-label col-lg-3'>链接</label>"+
        "<div class='col-lg-9'>"+
        "<input class='form-control' type='text' name='topic_group_"+i+"[url]' value=''>"+
        "</div></div></td></tr>";

}
function removeTopicGroup(id)
{
    $('#topic_group_' + id + '_tr').remove();
}