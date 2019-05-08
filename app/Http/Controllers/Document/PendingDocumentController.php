<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DepartmentUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PendingDocumentController extends Controller
{
    public function index()
    {
        Carbon::setLocale('vi');
        $currentDepartmentId = DepartmentUser::where([
                'position_id' => 1,
                'user_id' => Auth::user()->id,
                'is_active' => config('setting.department_user.active')])
            ->first()->department_id;
        $documents = DB::table('documents')
            ->join('document_department', 'documents.id', '=', 'document_department.document_id')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->where(['documents.department_id' => $currentDepartmentId, 'document_department.is_approved' => config('setting.department_user.no_approved')])
            ->select('documents.*', 'users.name', 'document_department.sending_date', 'document_department.id as document_department_id')
            ->orderBy('documents.created_at', 'desc')
            ->paginate(5);

        return view("document.pending_document.index",compact('documents'));
    }

    public function show($id)
    {
        $document = DB::table('documents')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->join('document_department', 'documents.id', '=', 'document_department.document_id')
            ->select('documents.*', 'users.name', 'users.avatar', 'document_department.sending_date', 'document_department.id as document_department_id')
            ->where('document_department.id', $id)
            ->first();
        $attachedFiles = DB::table('document_attachments')
            ->where('document_id', $document->id)
            ->get();
        return view("document.pending_document.show",compact('document', 'attachedFiles', 'documentReplies'));
    }

    public function update(Request $request, $id)
    {
        try {
            $result = DB::table('document_department')->whereId($id)->update(["is_approved" => 1]);

            if ($result) {

                return redirect(route('document-sent.index'))->with('alert', 'Duyệt thành công');
            } else {

                return redirect(route('document-pending.index'))->with('alert', 'Duyệt thất bại');
            }

        } catch (Exception $e) {

            return redirect(route('document-pending.index'))->with('alert', 'Duyệt thất bại');
        }
    }
}
