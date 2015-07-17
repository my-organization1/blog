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
    public function upload()
    {
        $upload = new UploadFile();

        $upload->maxSize = 3145728;
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');
        $savePath = './Uploads/'.date('Ymd');
        if (!file_exists($savePath)) {
            mkdir($savePath,0777,true);
        }
        $upload->savePath =  $savePath;

        if (!$upload->upload()) {
            $this->error($upload->getErrorMsg());
        }
        $info = $upload->getUploadFileInfo();
        $filepath = $info[0]['savepath'].$info[0]['savename'];
        $this->success($filepath);
    }
}
