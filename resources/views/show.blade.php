@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">PHP语言, PHP扩展, Zend引擎相关的研究,技术,新闻分享 – 左手代码 右手诗</div>
                    <div class="panel-body">
                        <div class="article">
                            <h2>PHP的性能演进(从PHP5.0到PHP7.1的性能全评测)</h2>
                            <div class="tags">
                                <span class="label label-info">PHP7</span>
                                <span class="label label-info">PHP源码分析</span>
                            </div>
                            <hr />

                            <div class="bs-callout bs-callout-warning">
                                <ul>
                                    <li>作者：<strong>Laruence</strong></li>
                                    <li>原文地址： <a href="http://www.laruence.com/2016/07/19/3101.html">http://www.laruence.com/2016/07/19/3101.html</a></li>
                                    <li>转载请注明出处。</li>
                                </ul>
                            </div>

                            <div class="content">

                                <p>
                                    好久没写文章了， 博客都长草了， 早上起来本来想去上班， 一看这么大雨， 这要上路了不得堵死啊.  </p>
                                <p>   再加上有同学对我昨天转发的微博HTTPOXY漏洞表示不理解， 问会不会影响普通应用， 于是就写篇文章介绍下， 等早高峰过了吧；）&#8230;..</p>
                                <p>   不过要注意的是， 这里我只是介绍PHP这个角度， 关于Go和Python等其他角度的，因为我也不是&#8221;很&#8221;懂，你们还是看原文吧 <img src='http://www.laruence.com/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley' />
                                </p>
                                <p>
                                    漏洞原文在这里， <a href="https://httpoxy.org/">https://httpoxy.org/</a>, 没看懂的一定都是英语没过6级的 <img src='http://www.laruence.com/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley' /> </p>
                                <p>    这里有一个核心的背景是， 长久一来我们习惯了使用一个名为&#8221;http_proxy&#8221;的环境变量来设置我们的请求代理， 比如在命令行我们经常这么用:</p>
                                <pre name="code" class="sh_bash" linenum="off">
http_proxy=127.0.0.1:9999 wget http://www.laruence.com/
</pre>
                                <p>    通过设置一个http_proxy的环境变量， 让wget使用代理请求http://www.laruence.com/</p>
                                <p>    有据可考的是, 这样的设定最初来自1994年的<a href="https://dev.w3.org/libwww/Library/User/History.html#z13">CERN libwww 2.15</a>, 我猜测大概是当时很多工具是基于这个类库做的, 于是就慢慢成了一个既定标准吧. 只不过这些应用都要求http_proxy是全部小写的, 还不足以造成今天这个漏洞.</p>
                                <p>    但估计是因为环境变量习惯都是大写的原因吧, 后来有的类库开始支持大写的HTTP_PROXY, 比如yum: <a href="https://www.centos.org/docs/5/html/yum/sn-yum-proxy-server.html">https://www.centos.org/docs/5/html/yum/sn-yum-proxy-server.html</a></p>
                                <p>    再后来很多的类库, 各种语言的, 都开始支持这种配置, 有的支持大写的, 有的支持小写的, 还有的都支持.</p>
                                <ul>
                                    <li> Guzzle(支持大写):<a href="https://github.com/guzzle/guzzle/blob/10a49d5e1b8729c5e05cbdbf475b38b7099eb35e/src/Client.php#L167">https://github.com/guzzle/guzzle/blob/10a49d5e1b8729c5e05cbdbf475b38b7099eb35e/src/Client.php#L167</a> </li>
                                    <li> Artax(大写, 小写都支持): <a href="https://github.com/amphp/artax/blob/3e3eedafcecc82c3c86c3a00ca602b5efa9c2cfa/lib/HttpSocketPool.php#L26">https://github.com/amphp/artax/blob/3e3eedafcecc82c3c86c3a00ca602b5efa9c2cfa/lib/HttpSocketPool.php#L26</a> </li>
                                </ul>
                                <p>    包括我们自己, 也很有可能在日常的工作中写出如下的代码(我就曾经在写爬虫的时候写过):</p>
                                <pre name="code" class="sh_php" linenum="off">
&lt;?php
$http_proxy = getenv(&quot;HTTP_PROXY&quot;);
if ($http_proxy) {
    $context = array(
        'http' =&gt; array(
            'proxy' =&gt; $http_proxy,
            'request_fulluri' =&gt; true,
        ),

    );
    $s_context = stream_context_create($context);
} else {
    $s_context = NULL;
}
$ret = file_get_contents(&quot;http://www.laruence.com/&quot;, false, $s_context);
</pre>
                                <p>     那么问题来了， 在CGI(RFC 3875)的模式的时候， 会把请求中的Header， 加上HTTP_ 前缀， 注册为环境变量,  所以如果你在Header中发送一个Proxy:xxxxxx, 那么PHP就会把他注册为HTTP_PROXY环境变量， 于是getenv(&#8220;HTTP_PROXY&#8221;)就变成可被控制的了.  那么如果你的所有类似的请求， 都会被代理到攻击者想要的地址，之后攻击者就可以伪造，监听，篡改你的请求了&#8230; </p>
                                <p>    比如：</p>
                                <pre name="code" class="sh_bash" linenum="off">
 curl -H &quot;Proxy:127.0.0.1:8000&quot; http://host.com/httpoxy.php
</pre>
                                <p>     所以， 这个漏洞要影响你， 有几个核心前提是:</p>
                                <ul>
                                    <li> 你的服务会对外请求资源</li>
                                    <li> 你的服务使用了HTTP_PROXY(大写的)环境变量来代理你的请求（可能是你自己写，或是使用一些有缺陷的类库） </li>
                                    <li> 你的服务跑在PHP的CGI模式下(cgi, php-fpm)</li>
                                </ul>
                                <p>     如果你没有满足上面的条件， 那么恭喜你，你不受此次漏洞影响 <img src='http://www.laruence.com/wp-includes/images/smilies/icon_smile.gif' alt=':)' class='wp-smiley' /> .</p>
                                <blockquote><p>
                                        后记:  在微博上有同学提醒,  我可能把这个问题的影响潜意识的让大家觉得危害不大, 但实际上, 延伸一下: 所有HTTP_开头的环境变量在CGI下都是不可信的, 千万不要用于敏感操作, 另外一点就是, 我深刻的体会过, 做安全的同学想象力非常丰富, 虽然看似很小的一个点, 但到了安全的同学手里, 配合他们丰富的想象力, 强大的社工能力, 也是能做出巨大攻击效果的&#8230;.
                                    </p></blockquote>
                                <p>     那知道了原理修复起来也很简单了, 以Nginx为例, 在配置中加入:</p>
                                <pre name="code" class="sh_bash" linenum="off">
   fastcgi_param HTTP_PROXY &quot;&quot;;
</pre>
                                <p>     所以建议, 即使你不受此次漏洞影响, 也应该加入这个配置.</p>
                                <p>     而如果你是一个类库的作者，或者你因为什么原因没有办法修改服务配置, 那么你就需要在代码中加入对sapi的判断， 除非是cli模式， 否则永远不要相信http_proxy环境变量，</p>
                                <pre name="code" class="sh_php" linenum="off">
&lt;?php
if (php_sapi_name() == 'cli' &amp;&amp; getenv('HTTP_PROXY')) {
   //只有CLI模式下, HTTP_PROXY环境变量才是可控的
}
</pre>
                                <p> 就好比Guzzle的这个修复：<a href="https://github.com/guzzle/guzzle/commit/9d521b23146cb6cedd772770a2617fd6cbdb1596#diff-ff73e042e738204c6da009e2ed19f783L166">Addressing HTTP_PROXY security vulnerability</a></p>
                                <p>   补充: 从PHP5.5.38开始, getenv增加了第二个参数, local_only = false, 如果这个参数为true, 则只会从系统本地的环境变量表中获取, 从而修复这个问题, 并且默认的PHP将拦截HTTP_PROXY: <a href="https://github.com/php/php-src/commit/98b9dfaec95e6f910f125ed172cdbd25abd006ec">fix</a></p>
                                <p>    thanks
                                </p>


                            </div>

                        </div>

                    </div>
                </div>

            </div>


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">博主介绍</div>
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left media-middle">
                                <a href="#">
                                    <img class="media-object" src="http://www.laruence.com/images/gavatar.png?orig=http://tp2.sinaimg.cn/1170999921/50/5606703689/1" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Laruence</h4>
                                PHP开发组核心成员, Zend顾问, PHP7主要开发者, Yaf, Yar, Yac等开源项目作者.
                            </div>
                        </div>
                        <br />
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">申明</h3>
                    </div>
                    <div class="panel-body">
                        本站非 <a target="_blank" href="http://www.laruence.com/"><strong>Laruence</strong></a> 原网站。所有内容均来自于 <a target="_blank" href="http://www.laruence.com/"> www.laruence.com </a>。 <br /><br /> 本站只是将内容做优化排版，未对任何内容做修改。 <br /><br /> 所有内容版权均属于 <a target="_blank" href="http://www.laruence.com/"><strong>Laruence</strong>.</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
