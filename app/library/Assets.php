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

        //Bootstrap 3.3.7
        if (in_array('bootstrap', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/bootstrap/bootstrap.min.css', false);
            $footerJs->addJs('//static.tudouyu.cn/bootstrap/bootstrap.min.js', false);
        }
        //Font-Awesome
        if (in_array('Font-Awesome', $this->assetsList)) {
            $headerCss->addCss('//static.tudouyu.cn/font-awesome/4.7.0/css/font-awesome.min.css', false);
        }
        ///Ionicons
        if (in_array('Ionicons', $this->assetsList)) {
            $headerCss->addCss('//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css', false);
        }
        //AdminLTE
        if (in_array('AdminLTE', $this->assetsList)) {
            if ($isLocal) {
                $headerCss->addCss('AdminLTE/dist/css/AdminLTE.min.css');
                $headerCss->addCss('AdminLTE/dist/css/skins/_all-skins.min.css');
                //AdminLTE App
                $footerJs->addJs('AdminLTE/dist/js/app.min.js');
                //AdminLTE for demo purposes
                $footerJs->addJs('AdminLTE/dist/js/demo.js');
            } else {
                $headerCss->addCss('//cdn.bootcss.com/admin-lte/2.3.8/css/AdminLTE.min.css', false);
                $headerCss->addCss('//cdn.bootcss.com/admin-lte/2.3.8/css/skins/_all-skins.min.css', false);
                $footerJs->addJs('//cdn.bootcss.com/admin-lte/2.3.8/js/app.min.js', false);
                $footerJs->addJs('//cdn.bootcss.com/admin-lte/2.3.8/js/demo.js', false);
            }
        }
        //jQuery2.2.4
        if (in_array('jQuery2.2.4', $this->assetsList)) {
            if ($isLocal) {
                $headerJs->addJs('plugins/jQuery/jquery-2.2.4.min.js');
            } else {
                $headerJs->addJs('//cdn.bootcss.com/jquery/2.2.4/jquery.min.js', false);
            }
        }
        //jQuery1.12.4
        if (in_array('jQuery1.12.4', $this->assetsList)) {
            if ($isLocal) {
                $headerJs->addJs('plugins/jQuery/jquery-1.12.4.min.js');
            } else {
                $headerJs->addJs('//cdn.bootcss.com/jquery/1.12.4/jquery.min.js', false);
            }
        }
        //jQuery1.10.2
        if (in_array('jQuery1.10.2', $this->assetsList)) {
            if ($isLocal) {
                $headerJs->addJs('plugins/jQuery/jquery-1.10.2.min.js');
            } else {
                $headerJs->addJs('//cdn.bootcss.com/jquery/1.10.2/jquery.min.js', false);
            }
        }
        //jQuery-UI 1.11.4
        if (in_array('jQuery-UI', $this->assetsList)) {
            if ($isLocal) {
                $footerJs->addJs('plugins/jQueryUI/jquery-ui.min.js');
            } else {
                $footerJs->addJs('//cdn.bootcss.com/jqueryui/1.11.4/jquery-ui.min.js', false);
            }
        }
        //jquery-confirm files
        if (in_array('jquery-confirm', $this->assetsList)) {
            if ($isLocal) {
                $headerCss->addCss('plugins/jquery-confirm/jquery-confirm.min.css');
                $headerJs->addJs('plugins/jquery-confirm/jquery-confirm.min.js');
            } else {
                $headerCss->addCss('//cdn.bootcss.com/jquery-confirm/3.0.1/jquery-confirm.min.css', false);
                $headerJs->addJs('//cdn.bootcss.com/jquery-confirm/3.0.1/jquery-confirm.min.js', false);
            }
        }
        //DataTables
        if (in_array('DataTables', $this->assetsList)) {
            if ($isLocal) {
                $headerCss->addCss('plugins/datatables/dataTables.bootstrap.css');
                $headerJs->addJs('plugins/datatables/jquery.dataTables.min.js');
                $headerJs->addJs('plugins/datatables/dataTables.bootstrap.min.js');
            } else {
                $headerCss->addCss('//cdn.bootcss.com/datatables/1.10.12/css/dataTables.bootstrap.min.css', false);
                $headerJs->addJs('//cdn.bootcss.com/datatables/1.10.12/js/jquery.dataTables.min.js', false);
                $headerJs->addJs('//cdn.bootcss.com/datatables/1.10.12/js/dataTables.bootstrap.min.js', false);
            }
        }
        //Select2
        if (in_array('Select2', $this->assetsList)) {
            if ($isLocal) {
                $headerCss->addCss('plugins/select2/select2.min.css');
                $headerJs->addJs('plugins/select2/select2.full.min.js');
            } else {
                $headerCss->addCss('//cdn.bootcss.com/select2/4.0.3/css/select2.min.css', false);
                $headerJs->addJs('//cdn.bootcss.com/select2/4.0.3/js/select2.full.min.js', false);
            }
        }
        //iCheck for checkboxes and radio inputs
        if (in_array('iCheck', $this->assetsList)) {
            if ($isLocal) {
                $headerCss->addCss('plugins/iCheck/all.css');
                $headerJs->addJs('plugins/iCheck/icheck.min.js');
            } else {
                $headerCss->addCss('//cdn.bootcss.com/iCheck/1.0.2/skins/all.css', false);
                $headerJs->addJs('//cdn.bootcss.com/iCheck/1.0.2/icheck.min.js', false);
            }
        }
        //bootstrapValidator
        if (in_array('bootstrapValidator', $this->assetsList)) {
            if ($isLocal) {
                $headerCss->addCss('plugins/bootstrapvalidator/bootstrapValidator.min.css');
                $headerJs->addJs('plugins/bootstrapvalidator/bootstrapValidator.min.js');
                $headerJs->addJs('plugins/bootstrapvalidator/language/zh_CN.js');
            } else {
                $headerCss->addCss('//cdn.bootcss.com/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css', false);
                $headerJs->addJs('//cdn.bootcss.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js', false);
                $headerJs->addJs('//cdn.bootcss.com/jquery.bootstrapvalidator/0.5.3/js/language/zh_CN.js', false);
            }
        }
        //UEditor,选用本地文件，修复点击上传图片时等待很慢的问题，
        //修复地址：https://github.com/fex-team/ueditor/issues/2983#issuecomment-239741212
        if (in_array('UEditor', $this->assetsList)){
            $headerJs->addJs('plugins/ueditor/ueditor.config.js');
            $headerJs->addJs('plugins/ueditor/ueditor.all.js');
            //公式js
//            $headerJs->addJs('plugins/ueditor/kityformula-plugin/addKityFormulaDialog.js');
//            $headerJs->addJs('plugins/ueditor/kityformula-plugin/getKfContent.js');
//            $headerJs->addJs('plugins/ueditor/kityformula-plugin/defaultFilterFix.js');
        }
        //webuploader
        if (in_array('webuploader', $this->assetsList)){
            $headerCss->addCss('plugins/ueditor/third-party/webuploader/webuploader.css');
            $headerJs->addJs('plugins/ueditor/third-party/webuploader/webuploader.min.js');
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