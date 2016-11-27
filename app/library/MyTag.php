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
     * @param array $config
     */
    public static function ueditor($id, $parameters = [])
    {
        $di = self::getDI();
        $di['assetsObj']->addAssets(['UEditor']);
        $code = '<script type="text/javascript">\n\r';
        if ($parameters) {
            $code .= "var ue_" . $id . " = UE.getEditor('" . $id . "', \n\r" . json_encode($parameters) . ");\n\r";
        } else {
            $code .= "var ue_" . $id . " = UE.getEditor('" . $id . "');\n\r";
        }
        $code .= '</script>\n\r';
        return $code;
    }

    /**
     * webuploader上传组件
     * https://my.oschina.net/illone/blog/730174
     * https://github.com/fex-team/webuploader/issues/492
     * http://bbs.csdn.net/topics/391917552
     * @param array $config
     */
    public static function webuploader($id, $fileType = '', $parameters = [])
    {
        $di = self::getDI();
        $code = '';
        $code .= '<script type="text/javascript">' . PHP_EOL;
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
        //文件接受服务器
        $parameters['server'] = isset($parameters['server']) ? $parameters['server'] : $di['url']->get('upload/webuploader',['action'=>'uploadimage']);
        switch ($fileType) {
            case 'images':
                $parameters['accept'] = [
                    'title'      => 'Images',
                    'extensions' => 'gif,jpg,jpeg,bmp,png',
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
                uploader_" . $id . ";";
        $code .= "var uploader_$id = WebUploader.create(" . json_encode($parameters, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK) . ");" . PHP_EOL;
        //当有文件添加进来的时候
        if ($fileType == 'images') {
            $code .= "uploader_$id.on( 'uploadSuccess', function( file, response ) {
                if(response.code == 200){
                    if(!$('#preview_$id').length){
                        $('" . $parameters['pick'] . "').after('<div id=\"preview_$id\" class=\"col-sm-9 thumbnail\" style=\"margin: 0px;\"><img></div>');
                    }
                    // 创建缩略图
                    uploader_$id.makeThumb( file, function( error, src ) {
                        if ( error ) {
                            return;
                        }
                        $('#preview_$id img').attr( 'src', src );
                    }, thumbnailWidth, thumbnailHeight );
                    if($('#{$id}_val').length){
                       $('#{$id}_val').val(response.content.url); 
                    }
                }else{
                    $.alert({title: '提示',content: response.message,autoClose: 'ok|1000',});
                }
            });" . PHP_EOL;
            $code .= "if($('#" . $id . "_val').val() != '' && $('#preview_$id').length){
                $('" . $parameters['pick'] . "').after('<div id=\"preview_$id\" class=\"col-sm-9 thumbnail\" style=\"margin: 0px;\"><img></div>');
            }";
        }
        //文件上传过程中创建进度条实时显示。
        $code .= "uploader_$id.on( 'uploadProgress', function( file, percentage ) {
            if($('#".$id."_progress').length){
                var percent = $('#" . $id . "_progress .progress span');
        
                // 避免重复创建
                if ( !percent.length ) {
                    $('#" . $id . "_progress').html('<p class=\"progress progress-xxs\"><span class=\"progress-bar progress-bar-success progress-bar-striped\"></span></p>');
                }
                percent.css( 'width', percentage * 100 + '%' );
            }
        });" . PHP_EOL;
        //文件上传成功，给item添加成功class, 用样式标记上传成功。
        $code .= "uploader_$id.on( 'uploadSuccess', function( file ) {
            $( '#'+file.id ).addClass('upload-state-done');
        });" . PHP_EOL;
        //文件上传失败，显示上传出错。
        $code .= "uploader_$id.on( 'uploadError', function( file ) {
            $.alert({title: '提示',content: '上传失败',autoClose: 'ok|1000',});
        });" . PHP_EOL;
        //完成上传完了，成功或者失败，先删除进度条。
        $code .= "uploader_$id.on( 'uploadComplete', function( file ) {
                $('#" . $id . "_progress').find('.progress').remove();
            });" . PHP_EOL;
        $code .= "$('" . $parameters['pick'] . "').mouseenter(function(){
            uploader_$id.refresh();
        });" . PHP_EOL;
        $code .= "});" . PHP_EOL;
        $code .= '</script>' . PHP_EOL;
        return $code;
    }
}