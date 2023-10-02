<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner; // Eloquent
use Illuminate\Support\Facades\DB; // QueryBuilder
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class OwnersController extends Controller
{
    /**
     * 新しいUserControllerインスタンスの生成
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carbonの練習
        // $data_now = Carbon::now();
        // $date_parse = Carbon::parse('now');
        // echo $data_now->year;
        // echo $date_parse;

        // データを扱う方法の比較
        // $e_all = Owner::all();
        // $q_get = DB::table('owners')->select('id', 'name', 'created_at')->get();
        // $q_first = DB::table('owners')->select('name')->first();
        // $c_test = collect([
        //     'name' => 'テスト'
        // ]);

        // 出力確認
        // var_dump($q_first);
        // dd($e_all, $q_get, $q_first, $c_test);
        // dd($e_all, $q_get);
        // return Inertia::render('Admin/Owners/Index', [
        //     'test' => 'テストです'
        // ]);
        // return Inertia::render('Admin/Owners/Index', [
        //     'e_all' => $e_all,
        //     'q_get' => $q_get
        // ]);

        $owners = Owner::select('id', 'name', 'email', 'created_at')->paginate(3);
        return Inertia::render('Admin/Owners/Index', [
            'owners' => $owners
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Owners/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.Owner::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return to_route('admin.owners.index')->with([
            'message' => '登録しました',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $owner = Owner::findOrFail($id);
        // dd($owner);
        return Inertia::render('Admin/Owners/Edit', [
            'owner' => $owner
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();

        return to_route('admin.owners.index')->with([
            'message' => '更新しました',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd('削除処理');
        Owner::findOrFail($id)->delete();

        return to_route('admin.owners.index')->with([
            'message' => '削除しました',
            'status' => 'alert'
        ]);
    }

    public function expiredOwnerIndex() {
        $expiredOwners = Owner::onlyTrashed()->get();
        return Inertia::render('Admin/ExpiredOwners', [
            'expiredOwners' => $expiredOwners
        ]);
    }

    public function expiredOwnerDestroy($id) {
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return to_route('admin.expired-owners.index')->with([
            'message' => '削除しました',
            'status' => 'alert'
        ]);
    }
}
