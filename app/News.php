<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $guarded = array('id');

    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );

    //Newモデルに関連付けを行う,Newsテーブルが更新されるタイミングでHistoryテーブルが作成される
    public function histories()
    {
        //newsテーブルに関連づいているhistoriesテーブルを全て取得するというメソッド
        return $this->hasMany('App\History');
    }
}
