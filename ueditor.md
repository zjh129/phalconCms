###ueditor问题修复
1、点击上传图片按钮弹出很慢问题
修改路径:/ueditor/dialogs/image/image.js
```javascript
accept: {
    title: 'Images',
    extensions: acceptExtensions,
    mimeTypes: 'image/*'
}
```
改为如下：
```javascript
accept: {
    title: 'Images',
    extensions: acceptExtensions,
    mimeTypes: 'image/gif,image/jpeg,image/png,image/jpg,image/bmp'
}
```
2、发现单图上传也会有这个问题
修改路径：/ueditor/ueditor.all.js
或者搜索 accept="image/ 在这个方法里面将 image/* 替换成 image/gif,image/jpeg,image/png,image/jpg,image/bmp 即可。


###如何让ueditor支持七牛上传
Ueditor做为百度的可视化编辑器，受到了广大用户的追捧！而七牛云储存是专门为用户提供附件存储、快速上传、附件安全的一个云产品，很多公司不打算用镜像存储的方法来同步数据，而是想通过可视化编辑器，将图片、附件等上传到七牛云存储，因为一个网站上主要是附件和图片占用资源多，对带宽的耗损比较严重！Ueditor和七牛云存储的结合实现了-图片和附件直接上传到七牛，图片在线管理等功能~~

改造参考网址:
http://www.widuu.com/archives/09/1091.html
http://www.widuu.com/archives/09/1096.html

####配置项改为从服务端获取
例如：
```javascript
var ue_container = UE.getEditor('container', 
{
    "serverUrl": "/admin/Upload/uedituploader"
});
```
####打印输出配置项时增加如下配置
```php
$jsonConfig['uploadType'] = 'qiniu';
$jsonConfig['tokenActionName'] = 'getToken';
$jsonConfig['uploadUrl'] = 'http://upload.qiniu.com/';
$jsonConfig['callbackAction'] = 'callBack';
$jsonConfig['imageFieldName'] = 'file';
$jsonConfig['videoFieldName'] = 'file';
$jsonConfig['fileFieldName'] = 'file';
```
####image上传调整
./dialogs/image/image.js中
```javascript
uploader.option('server', url);
```
改成：
```javascript
uploadType = editor.getOpt('uploadType');
if (uploadType == 'qiniu') {
    uploader.option('server', editor.getOpt('uploadUrl'));
}else{
    uploader.option('server', url);
}
```

```javascript
uploader.on('uploadBeforeSend', function (file, data, header) {
            //这里可以通过data对象添加POST参数
            header['X_Requested_With'] = 'XMLHttpRequest';
});
```
改成:
```javascript
uploader.on('uploadBeforeSend', function (file, data, header) {
                //这里可以通过data对象添加POST参数
                header['X_Requested_With'] = 'XMLHttpRequest';
                uploadType = editor.getOpt('uploadType');
                if (uploadType == 'qiniu') {
                    var token ="";
                    var key = "";
                    var url = editor.getActionUrl(editor.getOpt('tokenActionName'));
                    $.ajax({
                        dataType:'json',
                        async:false,
                        url:url,
                        data:{
                            type:'image',
                            fileName:file.file.name,
                            fileSize:file.file.size,
                            ext:file.file.ext,
                        },
                        success:function(data) {
                            if (data.token != '') {
                                token = data.token;
                            }
                            if (data.key != '') {
                                key = data.key;
                            }
                        }
                    });
                    data['key'] = key;
                    data['token'] = token;
                }
});
```
上传成功数据回写：
```javascript
uploader.on('uploadSuccess', function (file, ret) {
                var $file = $('#' + file.id);
                try {
                    var responseText = (ret._raw || ret),
                        json = utils.str2json(responseText);
                    if (json.state == 'SUCCESS') {
                        _this.imageList.push(json);
                        $file.append('<span class="success"></span>');
                        //七牛上传文件数据回写
                        if (uploadType == 'qiniu') {
                            var url = editor.getActionUrl(editor.getOpt('callbackAction'));
                            $.ajax({
                                type:'POST',
                                dataType:'json',
                                async:true,
                                url:url,
                                data:json,
                                success:function(data) {
                                    
                                }
                            });
                        }
                    } else {
                        $file.find('.error').text(json.state).show();
                    }
                } catch (e) {
                    $file.find('.error').text(lang.errorServerUpload).show();
                }
            });
```

####其他上传类别改造
`./dialogs/attachment/attachment.js` `./dialogs/video/video.js` 改造方法类似image.js的改造，
####然后在设置的serverUrl设置getToken动作，用于返回
```json
{
    key:'ueditor/php/upload/image/20161222/1482398281940863.jpg',//保存到七牛上的图片路径
    token:'xxxxxx',//上传秘钥，七牛php的sdk提供了此方法
}
```


###单独调用多图片上传组件
使用方式：
```javascript
$("body").append('<div id="upload" style="display:none;"></div>');
var ue_upload = UE.getEditor('upload', 
{
    "serverUrl": "/admin/Upload/uedituploader",
    "toolbars": [
        [
            "insertimage"
        ]
    ],
    "isShow": false
});
ue_upload.ready(function () {
    //侦听图片上传
    ue_upload.addListener('beforeInsertImage', function (t, arg) {
        //调用回调方法
        if(typeof(uploadCallback) === "function"){
            uploadCallback(arg);
        }else{
            console.log("您未设置回调方法[uploadCallback(fileList)]");
        }
    })
});
$("#upload_btn").click(function(){
    var uploadImage = ue_upload.getDialog("insertimage");
    uploadImage.open();
});
//自定义回调方法
function uploadCallback(list){
    $.each(list, function(i, data){
        var html = '';
        html += '<a target="_blank" href="'+data.url+'" class="thumbnail" style="widht:200px; float:left;"><img class="carousel-inner img-responsive img-rounded" src="'+data.url+'"></a>'+"\n";
        $('#uploadBox').append(html);
    });
}
```
###单独调用文件上传组件
`dialogs/attachment/attachment.js` 调整
```javascript
editor.execCommand('insertfile', list);
//下面增加一行增加
editor.fireEvent('afterUpfile', list);
```
使用方式：
```javascript
$("body").append('<div id="upload" style="display:none;"></div>');
var ue_upload = UE.getEditor('upload', 
{
    "serverUrl": "/admin/Upload/uedituploader",
    "toolbars": [
        [
            "attachment"
        ]
    ],
    "isShow": false
});
ue_upload.ready(function () {
    //侦听文件上传
    ue_upload.addListener('afterUpfile', function (t, arg) {
        if(typeof(uploadCallback) === "function"){
            uploadCallback(arg);
        }else{
            alert("您未设置回调方法[uploadCallback(list)]");
        }
    })
});
$("#upload_btn").click(function(){
    var uploadFiles = ue_upload.getDialog("attachment");
    uploadFiles.open();
});
//自定义回调方法
function uploadCallback(list){
    $.each(list, function(i, data){
        var html = '';
        html += '<a target="_blank" href="'+data.url+'" class="thumbnail" style="widht:200px; float:left;"><img class="carousel-inner img-responsive img-rounded" src="'+data.url+'"></a>'+"\n";
        $('#uploadBox').append(html);
    });
}
```
