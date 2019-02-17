@extends('layouts.admin')
@section('title', 'プロフィールの変更一覧')

@section('content')
    <div class="container">
        <div class="row">
          <div class="col-md-8 mx-auto">
            <h2>プロフィール変更</h2>
            <form action="{{ action('Admin\ProfileController@index') }}" method="post" enctype="multipart/form-data">
        </div>

        <div class="form-group row">
            <label class="col-md-2" for="title">氏名</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2" for="title">性別</label>
            <div class="col-md-10">
                <ul>
                  <li>男性<input type="radio" class="form-control" name="gender" value="男"></li>
                  <li>女性<input type="radio" class="form-control" name="gender" value="女"></li>
                </ul>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2" for="body">趣味</label>
            <div class="col-md-10">
                <textarea class="form-control" name="hobby" rows="5">{{ old('body') }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2" for="body">自己紹介</label>
            <div class="col-md-10">
                <textarea class="form-control" name="introduction" rows="10">{{ old('body') }}</textarea>
            </div>
        </div>

        {{ csrf_field() }}
        <input type="submit" class="btn btn-primary" value="更新">
    </form>
</div>
</div>
</div>
@endsection

        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\ProfileController@add') }}" role="button" class="btn btn-primary">新規登録</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\ProfileController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value={{ $cond_title }}>
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="admin-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="20%">氏名</th>
                                <th width="10%">性別</th>
                                <th width="30%">趣味</th>
                                <th width="30%">自己紹介</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $news)
                                <tr>
                                    <th>{{ $news->id }}</th>
                                    <td>{{ str_limit($news->title, 100) }}</td>
                                    <td>{{ str_limit($news->body, 250) }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\NewsController@edit', ['id' => $news->id]) }}">編集</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection





                    <div class="form-group row">
                        <label class="col-md-2" for="title">氏名</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="title">性別</label>
                        <div class="col-md-10">
                            <ul>
                              <li>男性<input type="radio" class="form-control" name="gender" value="男"></li>
                              <li>女性<input type="radio" class="form-control" name="gender" value="女"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="body">趣味</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="hobby" rows="5">{{ old('body') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="body">自己紹介</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="introduction" rows="10">{{ old('body') }}</textarea>
                        </div>
                    </div>

                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
            </div>
        </div>
    </div>
@endsection

<tbody>
                            @foreach($posts as $profile)
                                <tr>
                                    <th>{{ $profile->id }}</th>
                                    <td>{{ str_limit($profile->title, 100) }}</td>
                                    <td>{{ str_limit($profile->body, 250) }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\ProfileController@edit', ['id' => $profile->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ action('Admin\ProfileController@delete', ['id' => $profile->id]) }}">削除</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
