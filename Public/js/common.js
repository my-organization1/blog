// 表单验证
$(function(){
    $('[validate]').validate({
        onsubmit:true,
        onfocusout:false,
        onkeyup:false,
        onclick:false,
        focusInvalid:true,

        submitHandler:function(form){
            AjaxForm(form);
        },

        showErrors:function(errorMap,errorList){
            $.each( errorList, function(i,v){
                if(v.message != ''){
                    showAlert('发生错误了',v.message);
                    return false;
                }
            });
        }
    })
})

//ajax提交表单
function AjaxForm(dom){
    var url = $(dom).attr('action');
    var data = $(dom).serialize();
    $(dom).find('[type=submit]').attr('disabled','disabled');
    $.ajax({
        url:url,
        data:data,
        type:'post',
        dataType:'json',
        success:function(i){
            $(dom).find('[type=submit]').removeAttr('disabled');
            if(i.status == 1){
                window.location.href = i.url;
            }else{
                showAlert('发生错误了',i.info);
            }
        }
    })
    return false;
}

//Alert提示
function showAlert(title,msg){
    var d = dialog({
        title: title,
        content: msg,
        width:'400',
        okValue: '确定',
        ok: function () {}
    });
    d.showModal();
}