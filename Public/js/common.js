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
    //编辑器
    if($('[editor]')){
        $('[editor]').each(function(){
            var id = $(this).attr('id');
            createEditor(id);
        })
    }
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

//编辑器
function createEditor(id){
    var ue = UE.getEditor(id,{
        toolbars: [[
        'fullscreen', 'source', '|', 'undo', 'redo', '|',
        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
        'directionalityltr', 'directionalityrtl', 'indent', '|',
        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
        'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
        'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map',  'insertframe', 'insertcode', 'pagebreak', 'template', 'background', '|',
        'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
        'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
        'print', 'preview', 'searchreplace', 'drafts'
        ]],
        initialFrameHeight: 320,
        autoHeightEnabled: true,
        serverUrl:EditorUploadURl,
    });
}

function uploadImg(dom){
    var id = $(dom).attr('id');
    var DataInput = $(dom).attr('data-input');
    var preview = $('[data-preview='+DataInput+']');
    var input = $('#'+DataInput);

    $.ajaxFileUpload({
        url:AjaxUploadURl,
        secureuri:false,
        fileElementId:'upfile',
        dataType: 'json',
        success: function (i) {
            if (i.status == 1) {
                preview.attr('src', i.info);
                input.attr('value', i.info);
            } else {
                showAlert('发生错误了', i.info);
            }
        },
    })
}
