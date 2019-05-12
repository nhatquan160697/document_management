<?php

namespace App\Http\Controllers\Document;

use App\Http\Requests\Document\ReplyDocumentRequest;
use App\Models\DepartmentUser;
use App\Models\DocumentAttachment;
use App\Models\DocumentDepartment;
use App\Models\DocumentUser;
use App\Models\ReplyDocument;
use App\Uploaders\Uploader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocumentDepartmentController extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $departmentID = DepartmentUser::where('user_id', Auth::user()->id)->first();
        $document = DB::table('documents')->join('document_types', 'documents.document_type_id', '=', 'document_types.id')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->join('departments', 'departments.id', '=', 'documents.department_id')
            ->join('document_department', 'document_department.document_id', '=', 'documents.id')
            ->where(['document_department.department_id' => $departmentID['department_id'], 'documents.is_approved' => config('setting.document.approved')])
            ->select('documents.*', 'documents.id as documentID', 'document_types.name as name_type_document', 'users.*', 'departments.name as name_department', 'document_department.*')
            ->orderBy('documents.id', 'desc')
            ->get();

        return view("document.document_department.index", compact('document'));
    }

    public function checkUserSeen($id)
    {
        $userIdSeen = DocumentDepartment::where('document_id', $id)->first();
        if (isset($userIdSeen['array_user_seen']) && $userIdSeen['array_user_seen'] != "") {
            $jsonSeen = json_decode($userIdSeen['array_user_seen']);
            foreach ($jsonSeen as $value) {
                if (Auth::user()->id != $value) {
                    array_push($jsonSeen, Auth::user()->id);
                }
            }

            return $jsonSeen;

        } else {
            $jsonSeen = array();
                array_push($jsonSeen, Auth::user()->id);

            return $jsonSeen;
        }
    }

    public function show($id)
    {
//        check nguoi xem tin
        $jsonUserId = json_encode($this->checkUserSeen($id));
        DocumentDepartment::where('document_id', $id)->update(['array_user_seen' => $jsonUserId]);

        $document = DB::table('documents')->join('document_types', 'documents.document_type_id', '=', 'document_types.id')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->join('departments', 'departments.id', '=', 'documents.department_id')
            ->join('document_department', 'document_department.document_id', '=', 'documents.id')
            ->where(['documents.id' => $id , 'documents.is_approved' => config('setting.document.approved')])
            ->select('documents.*', 'document_department.*', 'documents.id as documentID', 'document_types.name as name_type_document', 'users.*', 'departments.name as name_department')
            ->first();
        $replyDocument = DB::table('reply_document')->join('users', 'reply_document.user_id', '=', 'users.id')
            ->where(['reply_document.document_id' => $id, 'is_reply_personal_document' => config('setting.reply.no_reply_personal_document')])
            ->select('reply_document.*', 'users.avatar', 'users.name')
            ->get();
        //array file attachment

        $arrayFileDecode = DocumentAttachment::where('document_id', $id)->get();

        return view('document.document_department.detail', compact('document', 'arrayFileDecode', 'replyDocument', 'arrayFileReplyDecode'));
    }

    public function reply(ReplyDocumentRequest $request, $id)
    {
        $input = $request->all();
        $input['document_id'] = $id;
        $input['user_id'] = Auth::user()->id;
        if (!isset($input['file_attachment_reply'])) {
            $input['file_attachment_reply'] = null;
            ReplyDocument::create($input);
        } else {
            $path = 'upload/files/document_reply';
            $arrFiles = $this->uploader->saveFileAttach($input['file_attachment_reply'],$path);
            $input['file_attachment_reply'] = json_encode($arrFiles);
            ReplyDocument::create($input);
        }
        return redirect()->route('document-department.show', $id);
    }

    public function share($id)
    {
        $countDocumentExists = DocumentUser::where(['document_id' => $id, 'user_id' => null])->get()->count();
        if ($countDocumentExists < 1) {
            try {
                $departmentID = DepartmentUser::where('user_id',
                    Auth::user()->id)->first();
                $input['document_id'] = $id;
                $input['department_id'] = $departmentID->department_id;
                DocumentUser::create($input);

                return redirect()->route('document-department.show', $id)
                    ->with('messageSuccess', 'Chia sẽ thành công');
            } catch (Exception $e) {
                return redirect()->route('document-department.show', $id)
                    ->with('messageFail',
                        'Chia sẽ thất bại, vui lòng kiểm tra lại');
            }
        }
        else{
            return redirect()->route('document-department.show', $id)
                ->with('messageFail',
                    'Bạn đã chia sẻ văn bản này rồi , vui lòng kiểm tra lại');
        }
    }
}
