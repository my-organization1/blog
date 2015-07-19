function setPermision(dom,node_id,group_id)
{
    var span = $(dom).parents('span');

    if (span.hasClass('checked')) {
        var url = delPermisionUrl;
    } else {
        var url = addPermisionUrl;
    }
    $.ajax({
        url:url,
        data:{
            group_id:group_id,
            node_id:node_id,
        },
        type:'post',
        dataType:'json',
        success:function(i){
            if (i.status == 1) {
                window.location.reload();
            } else {
                alert(i.info);
            }
        }
    })
    return false;
}
