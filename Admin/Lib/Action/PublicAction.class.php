<?php
/**
 * 公共Action
 *
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */

class PublicAction extends BaseAction
{
    /**
     * 单图上传
     */
    public function uploadImg()
    {
        $upload = new UploadFile();

        $upload->maxSize = 3145728;
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');
        $savePath = './Uploads/'.date('Ymd').'/';
        if (!file_exists($savePath)) {
            mkdir($savePath, 0777, true);
        }
        $upload->savePath =  $savePath;

        if (!$upload->upload()) {
            $info['status'] = 0;
            $info['info'] = $upload->getErrorMsg();
            die(json_encode($info));
        }

        $fileinfo = $upload->getUploadFileInfo();
        $filepath = __ROOT__.ltrim($fileinfo[0]['savepath'].$fileinfo[0]['savename'], '.');

        $info['status'] = 1;
        $info['info'] = $filepath;
        die(json_encode($info));
    }
}
