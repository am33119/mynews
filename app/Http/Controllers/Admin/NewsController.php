<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Modelが扱えるようになる
use App\News;
// History モデルの使用を宣言する
use App\History;
// 日付操作ライブラリ
use Carbon\Carbon;


class NewsController extends Controller
{
    // ニュース新規作成画面を表示する
    public function add()
    {
        return view('admin.news.create');
    }
    // ニュースを作成する
    // Request..ブラウザを通してユーザーから送られる情報をすべて含んでいるオブジェクトを取得する,
    // 情報を$requestに代入して使用する
    public function create(Request $request)
    {
        // Varidationを行う
        // メソッドの中でクラスに定義された変数を使用したいときにこの$thisを使用
        //validate()の第１引数にリクエストのオブジェクトを渡し、$request->all()を判定して、
        //問題があるなら、エラーメッセージと入力値とともに直前のページに戻る機能
        $this->validate($request, News::$rules);

        //newはモデルからインスタンス（レコード）を生成するメソッド
        $news = new News;
        //$request->all();はformで入力された値を取得する
        //$request->all()でユーザーが入力したデータを取得できる
        $form = $request->all();

        // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
        //issetメソッドが使われています。このメソッドは引数の中にデータがあるかないかを判断するメソッド
        //$news->image_path = null;はNewsテーブルのimage_pathカラムにnullを代入する
        //fileメソッドについてですが、Illuminate\Http\UploadedFileクラスのインスタンスを返す
        //storeメソッドは、どこのフォルダにファイルを保存するか、パスを指定する
        //$pathの中は「public/image/ハッシュ化されたファイル名」
        if (isset($form['image'])) {
          $path = $request->file('image')->store('public/image');
          $news->image_path = basename($path);
        } else {
          $news->image_path = null;
        }

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $news->fill($form);
        //保存はsaveメソッド,ユーザーが入力したデータをデータベースに保存する
        $news->save();

        // admin/news/createにリダイレクトする
        return redirect('admin/news/create');
    }

    // ニュースを表示する
    public function index(Request $request)
    {
        //$requestの中のcond_titleの値を$cond_titleに代入
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = News::where('title', $cond_title)->get();
        } else {
          // それ以外はすべてのニュースを取得する
          // Newsモデルを使って、データベースに保存されている、newsテーブルのレコードを全て取得し、変数$postsに代入している
          $posts = News::all();
        }

        // return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);がRequestにcond_titleを送っている
        // 投稿したニュースを検索するための機能として活用
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }

    // ニュースの編集画面を表示する
    public function edit(Request $request)
    {
        // News Modelからデータを取得する
        $news = News::find($request->id);

        return view('admin.news.edit', ['news_form' => $news]);
    }

    // ニュースを更新する
    public function update(Request $request)
    {
        // Validationをかける
        // News::$rulesは、News.phpファイルの$rules変数を呼び出す
        $this->validate($request, News::$rules);
        // News Modelからデータを取得する
        $news = News::find($request->id);
        // 送信されてきたフォームデータを格納する
        $news_form = $request->all();
        /*if (isset($news_form['image'])) {
          $path = $request->file('image')->store('public/image');
          $news->image_path = basename($path);
        } else {
            $news->image_path = null;
        }*/

        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }

        // \Debugbar::info(isset($news_form['image']));
        unset($news_form['_token']);
        unset($news_form['image']);
        unset($news_form['remove']);
        // 該当するデータを上書きして保存する
        $news->fill($news_form)->save();

        //Carbon を使って取得した現在時刻を、History モデルの edited_at として記録
        $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/news/');
    }
    // ニュースを削除する
    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $news = News::find($request->id);
        // 削除する
        $news->delete();
        return redirect('admin/news/');
    }


}
