<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProfileHistory;

use Carbon\Carbon;

class ProfileController extends Controller
{
    //プロフィールを編集する
    public function edit(Request $request)
    {
        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        \Debugbar::info($profile);
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }


    //プロフィールの新規作成
    public function create(Request $request)
    {
        // Varidationを行う
        $this->validate($request, Profile::$rules);

        $profile = new Profile;
        $form = $request->all();

        unset($form['_token']);

        // データベースに保存する
        $profile->fill($form);
        $profile->save();

        return redirect('admin/profile/edit');
    }

    //
    public function add()
    {
        return view('admin.profile.create');
    }


    //プロフィールを更新する
    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Profile::$rules);
        \Debugbar::info($request);

        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        \Debugbar::info($profile);

        // 送信されてきたフォームデータを格納する
        $profile_form = $request->all();
        unset($profile_form['_token']);

        // 該当するデータを上書きして保存する
        $profile->fill($profile_form);
        $profile->save();

        //ProfileModelの保存とProfileHistoryModelに編集履歴の追加
        $profilehistory = new ProfileHistory;
        $profilehistory->profile_id = $profile->id;
        $profilehistory->edited_at = Carbon::now();
        $profilehistory->save();

        return redirect('admin/profile/edit?id='.$request->id);
    }


    //プロフィールを削除する
    public function delete(Request $request)
    {
        // 該当するProfile Modelを取得
        $profile = Profile::find($request->id);
        // 削除する
        $profile->delete();
        return redirect('admin/profile/');
    }
}
