<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function index()
    {
        $idDesa = auth()->user()->id_desa;
        $role = auth()->user()->role;

        $joinedGroups = DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->join('desa', 'groups.id_desa', '=', 'desa.id')
            ->where('group_members.user_id', auth()->id())
            ->get();

        // all groups except joined groups
        $allGroupsNotJoined = DB::table('groups')
            ->select("groups.*", "desa.*", "groups.id as id_group")
            ->join('desa', 'groups.id_desa', '=', 'desa.id')
            // ->where('groups.id_desa', $idDesa)
            ->whereNotIn('groups.id', $joinedGroups->pluck('group_id')->toArray())
            ->get();

        return view('groups.index', [
            'groups' => $joinedGroups,
            'otherGroups' => $allGroupsNotJoined,
        ]);
    }

    public function create()
    {
        // Menampilkan form untuk membuat grup baru
        return view('groups.create');
    }

    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'group_name' => 'required',
            'description' => 'nullable',
        ]);

        // save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $fileName);
        } else {
            $fileName = null;
        }

        // Menyimpan data grup baru
        $groupId = DB::table('groups')->insertGetId([
            'group_name' => $request->get('group_name'),
            'id_desa' => auth()->user()->id_desa,
            'description' => $request->get('description'),
            'image' => $fileName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menambahkan user yang membuat grup sebagai anggota grup
        DB::table('group_members')->insert([
            'group_id' => $groupId,
            'user_id' => auth()->id(),
            'status' => 'Admin', // Status 'Admin' berarti user yang membuat grup adalah admin grup
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('groups.index')->with('success', 'Grup berhasil dibuat');

        // return back()->with('success', 'Grup berhasil dibuat');
    }

    public function edit($id)
    {

        // Menampilkan form untuk mengedit grup
        $group = DB::table('groups')->where('id', $id)->first();
        return view('groups.edit', ['group' => $group]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'group_name' => 'required',
            'description' => 'nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk tipe dan ukuran gambar
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $fileName);
        } else {
            $fileName = DB::table('groups')->where('id', $id)->value('image'); // Jika tidak ada gambar diupload, gunakan gambar yang sudah ada
        }


        // Memperbarui data grup
        DB::table('groups')->where('id', $id)->update([
            'group_name' => $request->group_name,
            'image' => $fileName,
            'description' => $request->description,
            'updated_at' => now(),
        ]);
        return redirect()->route('groups.index')->with('success', 'Grup berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Menghapus data grup
        DB::table('groups')->where('id', $id)->delete();
        return redirect()->route('groups.index')->with('success', 'Grup berhasil dihapus');
    }

    public function chat($id)
    {
        $group = DB::table('groups')->where('id', $id)->first();
        $totalGroupMembers = DB::table('group_members')->where('group_id', $id)->count();

        $messages = DB::table('messages')
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->select('messages.*', 'users.name', DB::raw('messages.user_id = ' . auth()->id() . ' as is_me'), 'users.image as image', 'users.name as name')
            ->where('group_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', auth()->id())
            ->update(['unread_messages_count' => 0]);

        return view('groups.chat', [
            'messages' => $messages,
            'group' => $group,
            'totalGroupMembers' => $totalGroupMembers,
        ]);
    }

    public function download($chatId)
    {

        $message = DB::table('messages')->where('id', $chatId)->first();
        $fileName = $message->attachment;
        $fileContent = Storage::get('public/attachments/' . $fileName);


        return response($fileContent)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function load($id)
    {
        $messages = DB::table('messages')
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->select('messages.*', 'users.name', DB::raw('messages.user_id = ' . auth()->id() . ' as is_me'), 'users.image as image', 'users.name as name')
            ->where('group_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', auth()->id())
            ->update(['unread_messages_count' => 0]);

        return view('groups.load', ['messages' => $messages]);
    }

    public function postChat(Request $request, $id)
    {
        $request->validate([
            'message_content' => 'required',
            'attachment' => 'nullable|file',
        ]);

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $fileName = uniqid() . '.' . $attachment->getClientOriginalExtension();
            $attachment->storeAs('public/attachments', $fileName);
            $attachmentType = $attachment->getClientMimeType();
        } else {
            $fileName = null;
            $attachmentType = null;
        }

        DB::table('messages')->insert([
            'group_id' => $id,
            'user_id' => auth()->id(),
            'message_content' => $request->message_content,
            'attachment' => $fileName,
            'attachment_type' => $attachmentType,
            'timestamp' => now(),
            'is_read' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', '!=', auth()->id())
            ->increment('unread_messages_count');

        return redirect()->back();
    }

    public function chatApi($id)
    {
        $messages = DB::table('messages')
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->select('messages.*', 'users.name', DB::raw('messages.user_id = ' . auth()->id() . ' as is_me'))
            ->where('group_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendChat(Request $request, $id)
    {
        $request->validate([
            'message_content' => 'required',
            'attachment' => 'nullable|file',
        ]);

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $fileName = uniqid() . '.' . $attachment->getClientOriginalExtension();
            $attachment->storeAs('public/attachments', $fileName);
            $attachmentType = $attachment->getClientMimeType();
        } else {
            $fileName = null;
            $attachmentType = null;
        }

        DB::table('messages')->insert([
            'group_id' => $id,
            'user_id' => auth()->id(),
            'message_content' => $request->message_content,
            'attachment' => $fileName,
            'attachment_type' => $attachmentType,
            'timestamp' => now(),
            'is_read' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', '!=', auth()->id())
            ->increment('unread_messages_count');

        return redirect()->route('groups.chat', $id);
    }

    public function join($id)
    {
        DB::table('group_members')->insert([
            'group_id' => $id,
            'user_id' => auth()->id(),
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('groups.index')->with('success', 'Berhasil bergabung dengan grup');
    }

    public function leave($id)
    {
        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->route('groups.index')->with('success', 'Berhasil keluar dari grup');
    }


    public function accept($id)
    {
        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', auth()->id())
            ->update(['status' => 'Member']);

        return back();
    }

    public function reject($id)
    {
        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->route('groups.index')->with('success', 'Berhasil menolak permintaan bergabung');
    }

    public function cancel($id)
    {
        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->route('groups.index')->with('success', 'Berhasil membatalkan permintaan bergabung');
    }

    public function confirm($id, $memberId)
    {
        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', $memberId)
            ->update(['status' => 'Member']);

        return back();
    }

    public function members($id)
    {
        $group = DB::table('groups')->where('id', $id)->first();
        $members = DB::table('group_members')
            ->join('users', 'group_members.user_id', '=', 'users.id')
            ->where('group_id', $id)
            ->get();

        $adminGroup = DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'Admin')
            ->first();

        $isAdminGroup = $adminGroup ? true : false;

        return view('groups.members', [
            'group' => $group,
            'members' => $members,
            'isAdminGroup' => $isAdminGroup,
            'adminGroup' => $adminGroup,
        ]);
    }

    public function delete($id, $memberId)
    {
        DB::table('group_members')
            ->where('group_id', $id)
            ->where('user_id', $memberId)
            ->delete();

        return back();
    }
}
