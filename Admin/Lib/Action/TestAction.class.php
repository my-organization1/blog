<?php

class TestAction extends Action
{
    function index()
    {
        $a = '<p style="white-space: normal;"><span style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);">一个类和hhc.exe还有hha.dll</span><br style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);"/><span style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);">用于生成包含html目录的chm项目文件 ，然后通过hhp项目文件和内容文件生成 .chm手册。</span></p><pre class="brush:php;toolbar:false;">$b)?&nbsp;1:-1;
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;class&nbsp;chmBuilder{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;const&nbsp;version&nbsp;=&nbsp;0.1;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_name;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_path;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_hhp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_hhc;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_hhk;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_uninclude_dirs;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_uninclude_files;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_image_type;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_first_open;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$chm_title;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;__construct($chm_name=&#39;your_chm&#39;,$chm_path=&#39;&#39;,$chm_uninclude_dirs,$chm_uninclude_files){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;chm_name&nbsp;=&nbsp;$chm_name;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;chm_path&nbsp;=&nbsp;$chm_path;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;chm_uninclude_dirs&nbsp;=&nbsp;$chm_uninclude_dirs;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;chm_uninclude_files&nbsp;=&nbsp;$chm_uninclude_files;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;chm_image_type&nbsp;=&nbsp;&#39;Folder&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;build(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;buildHhp();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;buildHhc();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;buildHhk();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;buildHhp(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$manual_files&nbsp;=&nbsp;listDir($this-&gt;chm_path);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$files&nbsp;=&nbsp;implode(PHP_EOL,&nbsp;$manual_files);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;chm_first_open&nbsp;=&nbsp;iconv(&#39;UTF-8&#39;,&nbsp;&#39;GB2312&#39;,&nbsp;$this-&gt;chm_first_open);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;chm_title&nbsp;=&nbsp;iconv(&#39;UTF-8&#39;,&nbsp;&#39;GB2312&#39;,&nbsp;$this-&gt;chm_title);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$tpl&nbsp;=&nbsp;chm_hhc}.hhc
COPYRIGHT=www.thinkphp.cn
Display&nbsp;compile&nbsp;progress=No
Default&nbsp;topic={$this-&gt;chm_first_open}
Error&nbsp;log&nbsp;file=chm_builder.Log
Full-text&nbsp;search=Yes
Index&nbsp;file={$this-&gt;chm_hhk}.hhk
ImageType={$this-&gt;chm_image_type}
Language=0x804
Title={$this-&gt;chm_title}
[FILES]
{$files}
eof;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;file_put_contents(&quot;{$this-&gt;chm_path}/{$this-&gt;chm_hhp}.hhp&quot;,&nbsp;$tpl);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;buildHhc(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$list&nbsp;=&nbsp;array();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$file_tree&nbsp;=&nbsp;listDirTree($this-&gt;chm_path,&quot;{$this-&gt;chm_hhp}&nbsp;{$this-&gt;chm_uninclude_dirs}{$this-&gt;chm_uninclude_files}&quot;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;uksort($file_tree,&nbsp;&#39;cmp&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;foreach&nbsp;($file_tree&nbsp;as&nbsp;$key&nbsp;=&gt;&nbsp;$value)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if(is_string($value)){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;explode(DIRECTORY_SEPARATOR,&nbsp;$value);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;array_pop($title);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;rtrim($title,&#39;.html&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$list[]&nbsp;=&nbsp;&lt;&lt;&nbsp;$val)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;explode(DIRECTORY_SEPARATOR,&nbsp;$val);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;array_pop($title);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;rtrim($title,&#39;.html&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$child[]&nbsp;=&nbsp;&lt;&lt;&lt;eof
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;eof;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$child&nbsp;=&nbsp;implode(PHP_EOL,&nbsp;$child);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$list[]&nbsp;=&nbsp;&lt;&lt;&lt;eof
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
eof;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$list&nbsp;=&nbsp;implode(PHP_EOL,&nbsp;$list);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$tpl&nbsp;=&nbsp;&lt;&nbsp;$value)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if(is_string($value)){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if(stripos($value,&nbsp;&#39;.html&#39;)){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;explode(DIRECTORY_SEPARATOR,&nbsp;$value);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;array_pop($title);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$title&nbsp;=&nbsp;rtrim($title,&#39;.html&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$list[]&nbsp;=&nbsp;&lt;&lt;&lt;eof
&nbsp;&nbsp;&nbsp;&nbsp;{$list}&nbsp;&nbsp;
{$child}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;eof;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$list&nbsp;=&nbsp;implode(PHP_EOL,&nbsp;$list);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$tpl&nbsp;=&nbsp;&lt;&lt;{$list}</pre><p style="white-space: normal;"><span style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);"></span><span style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);">使用方法，放到要生成目录的外面 定义好路径，手册名，不包含目录，不包含文件 字符串（空格分割），设置好一些属性后， 将hhc.exe的位置加入环境变量path中，cmd 里调用 执行的index.php 可以看到生成的信息，或者错误</span><br style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);"/><span style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);">index.php</span></p><p style="white-space: normal;"><span style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);"></span></p><p><br/></p><p style="white-space: normal;"><span style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);"></span><span style="color: rgb(50, 50, 50); font-family: &#39;century gothic&#39;, &#39;microsoft yahei&#39;; line-height: 28px; background-color: rgb(255, 255, 255);">这个可以配合ThinkPHP Sublime 插件来生成手册，目前排序方面有点问题，故没集成到插件里去。目前只支持二级分类，多级的大家递归时tab缩进好个是就行了，用手册里第一层目录和单文件名作为章节，里面的文件作为子章节</span></p><p><br/></p>';

        echo strip_tags($a);
    }
}