<?php
namespace MyApp\Library;

use Phalcon\Tag;

/**
 * 扩展自带tag标签
 * @package MyApp\Library
 */
class MyTag extends Tag
{
    /**
     * 百度编辑器
     *
     * @param array $config
     */
    public static function ueditor($id, $type = 'full', $defaultValue = '', $parameters = [])
    {
        $di = self::getDI();
        //$di['assetsObj']->addAssets(['UEditor']);
        $code = '';
        $code .= '<script type="text/javascript">' . PHP_EOL;
        //强制设定参数
        $parameters['serverUrl'] = $di['url']->get('Upload/uedituploader');
        //工具数量
        switch ($type) {
            case 'simple':
                $parameters['toolbars'] = [[
                    'fullscreen', 'source', '|', 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                    'simpleupload', 'insertimage', '|', 'selectall', 'cleardoc',
                ]];
                $defaultValue && $parameters['initialContent'] = htmlspecialchars($defaultValue);
                break;
            case 'files':
                $parameters['toolbars'] = [['attachment']];
                $parameters['isShow'] = false;
                $code .= '$("body").append(\'<div id="' . $id . '" style="display:none;"></div>\');' . PHP_EOL;
                break;
            case 'images':
                $parameters['toolbars'] = [['insertimage']];
                $parameters['isShow'] = false;
                $code .= '$("body").append(\'<div id="' . $id . '" style="display:none;"></div>\');' . PHP_EOL;
                break;
            default:
                $defaultValue && $parameters['initialContent'] = htmlspecialchars($defaultValue);
        }

        $editorName = 'ue_' . $id;
        $code .= "var {$editorName} = UE.getEditor('" . $id . "', " . PHP_EOL . json_encode($parameters, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK) . ");" . PHP_EOL;

        switch ($type) {
            case 'files':
                $code .= "{$editorName}.ready(function () {
                        //侦听文件上传
                        {$editorName}.addListener('afterUpfile', function (t, arg) {
                            if(typeof({$id}Callback) === 'function'){
                                {$id}Callback(arg);
                            }else{
                                console.log('您未设置回调方法[{$id}Callback(fileList)]');
                            }
                        })
                    });" . PHP_EOL;
                $code .= "$('#{$id}_btn').click(function(){
                        var {$id}Files = {$editorName}.getDialog('attachment');
                        {$id}Files.open();
                    });";
                break;
            case 'images':
                $code .= "{$editorName}.ready(function () {
                        //侦听图片上传
                        {$editorName}.addListener('beforeInsertImage', function (t, arg) {
                            //调用回调方法
                            if(typeof({$id}Callback) === 'function'){
                                {$id}Callback(arg);
                            }else{
                                console.log('您未设置回调方法[{$id}Callback(fileList)]');
                            }
                        })
                    });" . PHP_EOL;
                $code .= "$('#{$id}_btn').click(function(){
                        var {$id}Image = {$editorName}.getDialog('insertimage');
                        {$id}Image.open();
                    });" . PHP_EOL;
                break;
        }

        $code .= '</script>' . PHP_EOL;

        return $code;
    }

    /**
     * webuploader上传组件
     * https://my.oschina.net/illone/blog/730174
     * https://github.com/fex-team/webuploader/issues/492
     * http://bbs.csdn.net/topics/391917552
     *
     * @param array $config
     */
    public static function webuploader($id, $fileType = '', $uploadType = 'local', $parameters = [])
    {
        $di = self::getDI();
        $code = '';
        $code .= "<script type=\"text/javascript\">" . PHP_EOL;
        //选择文件的按钮。可选。
        //内部根据当前运行是创建，可能是input元素，也可能是flash.
        $parameters['pick'] = isset($parameters['pick']) ? $parameters['pick'] : "#" . $id . '_btn';
        //选完文件后，是否自动上传。
        $parameters['auto'] = true;
        //swf文件路径
        $parameters['swf'] = 'http://cdn.staticfile.org/webuploader/0.1.5/Uploader.swf';
        $parameters['swf'] = isset($parameters['swf']) ? $parameters['swf'] : '/plugins/ueditor/third-party/webuploader/Uploader.swf';
        //不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        $parameters['resize'] = isset($parameters['resize']) ? $parameters['resize'] : false;
        //设置文件上传域的name
        //$parameters['fileVal'] = 'upfile';
        //文件接受服务器
        switch ($uploadType) {
            case 'qiniu':
                $parameters['server'] = 'http://up.qiniu.com/';
                break;
            default:
                $parameters['server'] = isset($parameters['server']) ? $parameters['server'] : $di['url']->get('upload/uedituploader', ['action' => 'uploadimage']);
        }
        switch ($fileType) {
            case 'images':
                $parameters['accept'] = [
                    'title'      => 'Images',
                    'extensions' => 'gif,jpg,jpeg,bmp,png',
                    'mimeTypes'  => 'image/gif,image/jpg,image/jpeg,image/bmp,image/png',
                ];
                break;
            case 'file':
                $parameters['accept'] = [
                    'title'      => 'Files',
                    'extensions' => 'png,jpg,jpeg,gif,bmp,flv,swf,mkv,avi,rm,rmvb,mpeg,mpg,ogg,ogv,mov,wmv,mp4,webm,mp3,wav,mid,rar,zip,tar,gz,7z,bz2,cab,iso,doc,docx,xls,xlsx,ppt,pptx,pdf,txt,md,xml',
                    'mimeTypes'  => 'image/gif,image/jpg,image/jpeg,image/bmp,image/png',
                ];
                break;
            case 'video':
                $parameters['video'] = [
                    'title'      => 'Files',
                    'extensions' => 'flv,swf,mkv,avi,rm,rmvb,mpeg,mpg,ogg,ogv,mov,wmv,mp4,webm,mp3,wav,mid',
                    'mimeTypes'  => 'image/gif,image/jpg,image/jpeg,image/bmp,image/png',
                ];
                break;
        }
        //初始化Web Uploader
        $code .= "$(function(){" . PHP_EOL;
        $code .= "// 优化retina, 在retina下这个值是2
                var ratio = window.devicePixelRatio || 1,
                // 缩略图大小
                thumbnailWidth = 200 * ratio,
                thumbnailHeight = 200 * ratio,
                uploader_" . $id . ";" . PHP_EOL;;
        $uploadName = 'uploader_' . $id;
        $code .= "var {$uploadName} = WebUploader.create(" . json_encode($parameters, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK) . ");" . PHP_EOL;
        switch ($uploadType) {
            case 'qiniu':
                $code .= "{$uploadName}.on('uploadBeforeSend', function (file, data, header) {
                        //这里可以通过data对象添加POST参数
                        header['X_Requested_With'] = 'XMLHttpRequest';
                        $.ajax({
                            dataType:'json',
                            async:false,
                            url:'" . $di['url']->get('upload/uedituploader', ['action' => 'getToken']) . "',
                            data:{
                                type:'image',
                                fileName:file.file.name,
                                fileSize:file.file.size,
                                ext:file.file.ext,
                            },
                            success:function(rs) {
                                data.key = rs.key;
                                data.token = rs.token;
                            }
                        });
                    });" . PHP_EOL;
                $code .= "{$uploadName}.on( 'uploadSuccess', function( file, response ) {
                        if(response.state == 'SUCCESS'){
                            if(typeof({$id}Callback) === 'function'){
                                {$id}Callback(response);
                            }else{
                                alert('您未设置回调方法[{$id}Callback(response)]');
                            }
                            // 创建缩略图
                            if($('#{$id}Preview').length){
                                {$uploadName}.makeThumb( file, function( error, src ) {
                                    if ( error ) {
                                        return;
                                    }
                                    $('#{$id}Preview img').attr( 'src', src );
                                }, thumbnailWidth, thumbnailHeight );
                            }
                            //七牛上传文件数据回写
                            $.ajax({
                                type:'POST',
                                dataType:'json',
                                async:true,
                                url:'" . $di['url']->get('upload/uedituploader', ['action' => 'callBack']) . "',
                                data:response,
                                success:function(data) {}
                            });
                        }else{
                            alert('上传失败');
                        }
                    });" . PHP_EOL;
                break;
            default:
                $code .= "{$uploadName}.on('uploadBeforeSend', function( block, data, headers) {  
                            data.key = new Date().toLocaleTimeString();  
                        });";
                //文件上传成功，给item添加成功class, 用样式标记上传成功。
                $code .= "{$uploadName}.on( 'uploadSuccess', function( file, response ) {
                            $( '#'+file.id ).addClass('upload-state-done');
                            if(typeof({$id}Callback) === 'function'){
                                {$id}Callback(response);
                            }else{
                                alert('您未设置回调方法[{$id}Callback(response)]');
                            }
                        });" . PHP_EOL;
        }
        //文件上传过程中创建进度条实时显示。
        $code .= "{$uploadName}.on( 'uploadProgress', function( file, percentage ) {
                    if($('#{$id}_progress').length){
                        var percent = $('#{$id}_progress .progress span');
                
                        // 避免重复创建
                        if ( !percent.length ) {
                            $('#" . $id . "_progress').html('<p class=\"progress progress-xxs\"><span class=\"progress-bar progress-bar-success progress-bar-striped\"></span></p>');
                        }
                        percent.css( 'width', percentage * 100 + '%' );
                    }
                });" . PHP_EOL;
        //文件上传失败，显示上传出错。
        $code .= "{$uploadName}.on( 'uploadError', function( file ) {
                    alert('上传失败');
                });" . PHP_EOL;
        //完成上传完了，成功或者失败，先删除进度条。
        $code .= "{$uploadName}.on( 'uploadComplete', function( file ) {
                    $('#{$id}_progress').find('.progress').remove();
                });" . PHP_EOL;
        $code .= "$('" . $parameters['pick'] . "').mouseenter(function(){
                    uploader_{$id}.refresh();
                });" . PHP_EOL;
        $code .= "});" . PHP_EOL;
        $code .= "</script>" . PHP_EOL;

        return $code;
    }
}