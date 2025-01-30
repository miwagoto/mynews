<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;

// 以下の2行を追記することで、ProfileHistory Model, Carbonクラスが扱えるようになる
use App\Models\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        $this->validate($request, Profile::$rules);

        $profile = new Profile;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }

    public function edit(Request $request)
    {
        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update()
    {
        $this->validate($request, Profile::$rules);
        // News Modelからデータを取得する
        $news = Profile::find($request->id);
        // 送信されてきたフォームデータを格納する
        $profile_form = $request->all();

        unset($profile_form['_token']);

        $profile->fill($profile_form)->save();

        $history = new ProfileHistory();
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/profile/edit');
    }
    //
}
