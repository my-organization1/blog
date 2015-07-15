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
    //单选和多选框样式
    $("input[type=radio],input[type=checkbox]").uniform();
    //下拉框效果
    $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
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
                return false;
            }
        }
    })
    return false;
}

//Ajax按钮提交
function AjaxBtn(dom){
    if($(dom).attr('disabled')){
        return false;
    }

    var url = $(dom).attr('href');

    $(dom).attr('disabled','disabled');

    var d = dialog({
        title: '提示',
        content: '您确定继续吗?',
        okValue: '确定',
        width:'400',
        ok: function () {
            var result = true;
            $.ajax({
                url:url,
                type:'get',
                dataType:'json',
                success:function(i){
                    $(dom).removeAttr('disabled');
                    if(i.status == 1){
                        window.location.href = i.url;
                    }else{
                        showAlert('发生错误了',i.info);
                        result = false;
                    }
                }
            })
        },
        cancelValue: '取消',
        cancel: function () {}
    });
    d.showModal();

    return false;
}

//Alert提示
function showAlert(title,msg){
    var d = dialog({
        title: title,
        content: msg,
        width:'400',
        Value: '确定',
        ok: function () {}
    });
    d.showModal();
}
