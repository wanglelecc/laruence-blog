<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class WelcomeController extends Controller
{

    public function index()
    {
        $uri = '/';

        $data = [
            'nav_id' => 'home',
        ];

        return $this->lists($uri, $data, '首页');
    }

    public function phpInternal()
    {
        $uri = 'php-internal';

        $data = [
            'nav_id' => $uri,
        ];
        return $this->lists($uri, $data, 'PHP源码');
    }

    public function php()
    {
        $uri = 'php';

        $data = [
            'nav_id' => $uri,
        ];

        return $this->lists($uri, $data, 'PHP应用');
    }

    public function jscss()
    {
        $uri = 'jscss';

        $data = [
            'nav_id' => $uri,
        ];

        return $this->lists($uri, $data, 'JS/CSS');
    }

    public function notes()
    {
        $uri = 'notes';

        $data = [
            'nav_id' => $uri,
        ];

        return $this->lists($uri, $data, '随笔');
    }

    public function licence()
    {
        $data = [
            'nav_id' => 'licence',
            'source' => 'http://www.laruence.com/licence',
            'content' => '<p>本博客属个人所有，不涉及商业目的。遵守中华人民共和国法律法规、中华民族基本道德和基本网络道德规范，尊重有节制的言论自由和意识形态自由，反对激进、破坏、低俗、广告、投机等不负责任的言行。所有转载的文撰写页面章、图片仅用于说明性目的，被要求或认为适当时，将标注署名与来源。避免转载有明确“不予转载”声明的作品。若不愿某一作品被转用，请及时通知本人。对于无版权或自由版权作品，本博客有权进行修改和传播，一旦涉及实质性修改，本博客将对修改后的作品享有相当的版权。二次转载者请再次确认原作者所给予的权力范围。<br />
本博客所有原创作品，包括文字、资料、图片、网页格式，转载时请标注作者与来源。非经允许，不得用于赢利目的。本博客受中国知识产权、互联网法规和知识共享条例保护和保障，任何人不得进行旨在破坏或牟取私利的行为。本博客声明以简体中文版为准，不对其他语言版本负责。</p>
<br /><p class="text-center"><img src="http://creativecommons.org/images/public/somerights20.png" border="0" alt="Creative Commons License" /> <br /> 本博客的所有原创作品采用<a rel="license" href="http://cn.creativecommons.org/">“知识共享”</a><a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/">署名-非商业性使用-相同方式共享2.5协议</a>进行许可</p><br />
<p>Boke statement<br />
The Boke is own by person, without commercial purposes. It compliances with the PRC laws and regulations, the Chinese nation and the basic networks basic moral ethics. It respects for freedom of expression and ideological freedom restraint, but against the radical opposition, destruction, entertainment, advertising or irresponsible speculation words and deeds. All reproduced articles and pictures are for illustrative purposes only. if it’s required or deemed appropriate, the source will be identified and signed. Avoid reproduced clearly “not reproduced” statement works. If not a diversion works, please timely notification me. For copyright-free or free of copyright works, the right to revise and dissemination Boke, once involving substantive changes to the revised Boke will enjoy considerable copyright works. Second reproduced please reconfirmed either the original authors for their power. The Boke of all original works, including text, data, pictures, web page format, reproduced with the author, please indicate the source. ECA permit may not be used for profitable purposes. The Boke of Chinese intellectual property, the laws and regulations to protect and safeguard knowledge-sharing, aimed at the destruction of any person shall conduct or seek personal gain. Boke to Simplified Chinese version of this statement is that no other language versions.</p>',
        ];
        $title = '博客申明';

        return view('show', compact(['data','title']) );
    }

    public function lists($uri, $data, $title = '')
    {
        $lists = crawl_lists($uri);
        $data = array_merge($data, $lists);

        $paginator = new LengthAwarePaginator(array_pad([0],$data['maxPage'],0), $data['maxPage'],1, null, [ 'path' => Paginator::resolveCurrentPath()] );
        $uri = $uri == '/' ? 'home' : $uri;

        return view('lists', compact(['uri', 'data','title','paginator']));
    }

    public function show($path){

        $uri = laruence_url_decode($path);

        $data = crawl_show($uri);

        $data['nav_id'] = \request('nav','home');
        $data['source'] = 'http://www.laruence.com/'.$uri;
        $title = $data['title'];

        return view('show',  compact(['data','title']));
    }

}
