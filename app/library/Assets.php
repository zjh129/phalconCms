<?php
namespace MyApp\Library;

use Phalcon\Mvc\User\Component;

/**
 * 资源定义组件
 * <code>
 * //头部视图输入
 * $this->assets->outputCss("headerCss");
 * $this->assets->outputJs("headerJs");
 * //底部视图输入
 * $this->assets->outputJs("footerJs");
 * </code>
 * @package MyApp\Library
 */
class Assets extends Component
{
    private $assetsList = [];

    public function __construct($assetsList = [])
    {
        $this->assetsList = $assetsList;
    }

    /**
     * 定义资源
     */
    public function register()
    {
        // HTML 头部的Js资源
        $headerJs = $this->assets->collection("headerJs");
        // HTML 头部的Css资源
        $headerCss = $this->assets->collection("headerCss");
        // HTML尾部的资源
        $footerJs = $this->assets->collection("footerJs");

        $isLocal = $this->config->environment == 'dev' ? true : false;

        $version = 201612271308;

        //Bootstrap 3.3.7
        if (in_array('bootstrap', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/bootstrap/3.3.7/css/bootstrap.min.css?v='.$version, false);
            $footerJs->addJs('//static.tudouyu.cn/bootstrap/3.3.7/js/bootstrap.min.js?v='.$version, false);
        }
        //Font-Awesome
        if (in_array('Font-Awesome', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/font-awesome/4.7.0/css/font-awesome.min.css', false);
        }
        ///Ionicons
        if (in_array('Ionicons', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/ionicons/2.0.1/css/ionicons.min.css', false);
        }
        //AdminLTE
        if (in_array('AdminLTE', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/AdminLTE/2.3.8/css/AdminLTE.min.css?v='.$version, false);
            $headerCss->addCss('//static.tudouyu.cn/AdminLTE/2.3.8/css/skins/_all-skins.min.css', false);
            $footerJs->addJs('//static.tudouyu.cn/AdminLTE/2.3.8/js/app.min.js', false);
            $footerJs->addJs('//static.tudouyu.cn/AdminLTE/2.3.8/js/demo.js', false);
        }
        //jQuery2.2.4
        if (in_array('jQuery2.2.4', $this->assetsList)) {
            $headerJs->addJs('//static.tudouyu.cn/jQuery/jquery-2.2.4.min.js', false);
        }
        //jQuery1.12.4
        if (in_array('jQuery1.12.4', $this->assetsList)) {
            $headerJs->addJs('//static.tudouyu.cn/jQuery/jquery-1.12.4.min.js', false);
        }
        //jQuery1.10.2
        if (in_array('jQuery1.10.2', $this->assetsList)) {
            $headerJs->addJs('//static.tudouyu.cn/jQuery/jquery-1.10.2.min.js', false);
        }
        //jQuery-UI 1.11.4
        if (in_array('jQuery-UI', $this->assetsList)) {
            $footerJs->addJs('//static.tudouyu.cn/jQueryUI/1.11.4/jquery-ui.min.js', false);
        }
        //jquery-confirm files
        if (in_array('jquery-confirm', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/jquery-confirm/3.0.1/jquery-confirm.min.css', false);
            $headerJs->addJs('//static.tudouyu.cn/jquery-confirm/3.0.1/jquery-confirm.min.js', false);
        }
        //DataTables
        if (in_array('DataTables', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/datatables/1.10.13/css/dataTables.bootstrap.min.css', false);
            $headerJs->addJs('//static.tudouyu.cn/datatables/1.10.13/js/jquery.dataTables.min.js', false);
            $headerJs->addJs('//static.tudouyu.cn/datatables/1.10.13/js/dataTables.bootstrap.min.js', false);
        }
        //Select2
        if (in_array('Select2', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/select2/4.0.3/select2.min.css', false);
            $headerJs->addJs('//static.tudouyu.cn/select2/4.0.3/select2.full.min.js', false);
        }
        //iCheck for checkboxes and radio inputs
        if (in_array('iCheck', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/iCheck/1.0.2/skins/all.css', false);
            $headerJs->addJs('//static.tudouyu.cn/iCheck/1.0.2/icheck.min.js', false);
        }
        //bootstrapValidator
        if (in_array('bootstrapValidator', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/bootstrapvalidator/0.5.3/bootstrapValidator.min.css', false);
            $headerJs->addJs('//static.tudouyu.cn/bootstrapvalidator/0.5.3/bootstrapValidator.min.js', false);
            $headerJs->addJs('//static.tudouyu.cn/bootstrapvalidator/0.5.3/language/zh_CN.js', false);
        }
        //UEditor,选用本地文件，修复点击上传图片时等待很慢的问题，坑爹的百度编辑器，居然不能外网引用
        //修复地址：https://github.com/fex-team/ueditor/issues/2983#issuecomment-239741212
        if (in_array('UEditor', $this->assetsList)){
            $headerJs->addJs('/ueditor/ueditor.config.js');
            $headerJs->addJs('/ueditor/ueditor.all.min.js');
        }
        //webuploader
        if (in_array('webuploader', $this->assetsList)){
            $headerCss->addCss('//static.tudouyu.cn/ueditor/1.4.3/third-party/webuploader/webuploader.css');
            $headerJs->addJs('//static.tudouyu.cn/ueditor/1.4.3/third-party/webuploader/webuploader.min.js');
        }
    }

    /**
     * 添加资源文件
     * @param array $assets
     */
    public function addAssets($assets = [])
    {
        if ($assets) {
            $this->assetsList = array_merge($this->assetsList, $assets);
            $this->assetsList = array_unique($this->assetsList);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除资源文件
     * @param array $assets
     */
    public function delAssets($assets = [])
    {
        if ($assets) {
            foreach ($assets as $v) {
                unset($this->assetsList[array_search($v, $this->assetsList)]);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 清空资源文件
     */
    public function cleanAssets()
    {
        $this->assetsList = [];
        return true;
    }
}