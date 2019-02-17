<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

//追記
use App\News;
use App\Profile;

class NewsController extends Controller
{
    //
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        // $cond_title が空白でない場合は、記事を検索して取得する
        // News::all()はEloquentを使った、全てのnewsテーブルを取得するというメソッド
        // sortByDesc() カッコの中の値（キー）でソート(並び替えること)するためのメソッド
        //News::all()->sortByDesc('updated_at')は、「投稿日時順に新しい方から並べる」
        if ($cond_title !='') {
            $posts = News::where('title', $cond_title).orderBy('updated_at', 'desc')->get();
        } else {
            $posts = News::all()->sortByDesc('updated_at');
        }

        // shift()メソッドは、配列の最初のデータを削除し、その値を返すメソッド
        // $headline = $posts->shift();では、一番最新の記事を変数$headlineに代入し、
        // $postsは代入された最新の記事以外の記事が格納されている
        if (count($posts) > 0) {
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline, posts, cond_title という変数を渡している
        return view('news.index', ['headline' => $headline, 'posts' => $posts, 'cond_title' => $cond_title]);
    }

    // news/profile.blade.php ファイルを渡している
    public function profile(Request $request)
    {

      //すべてのプロフィールデータを得る
      $profiles = Profile::all();

      // また View テンプレートに という変数を渡している
      return view('news.profile', ['profiles'=>$profiles]);
    }


}
