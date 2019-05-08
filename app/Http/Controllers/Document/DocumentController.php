<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\DocumentAddRequest;
use App\Http\Requests\Document\ReplyDocumentRequest;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Document;
use App\Models\Message;
use App\Models\DocumentAttachment;
use App\Models\DocumentDepartment;
use App\Models\DocumentType;
use App\Models\DocumentUser;
use App\Models\ReplyDocument;
use App\Uploaders\Uploader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
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
            ->where('documents.department_id', $departmentID['department_id'])
            ->select('documents.*', 'documents.id as documentID', 'document_types.name as name_type_document', 'users.*', 'departments.name as name_department')
            ->get();
        return view('document.index', compact('document'));
    }

    public function create()
    {
        $departments = DB::table('users')
            ->select('departments.id', 'departments.name')
            ->join('department_users', 'users.id', '=', 'department_users.user_id')
            ->join('departments', 'department_users.department_id', '=', 'departments.id')
            ->where('users.id', Auth::user()->id)
            ->pluck('name', 'id');
        $documentTypes = DocumentType::pluck('name', 'id');
        $first_key = key($departments->toArray());
        $receivedDepartments = Department::where('id', '!=', $first_key)->pluck('name', 'id');
        return view('document.create', compact('departments', 'documentTypes', 'receivedDepartments'));
    }

    public function checkUserSeen($id)
    {
        $userIdSeen = DocumentUser::where('document_id', $id)->first();
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
        //check nguoi xem tin
        $jsonUserId = json_encode($this->checkUserSeen($id));
        DocumentUser::where('document_id', $id)->update(['array_user_seen' => $jsonUserId]);

        $document = DB::table('documents')->join('document_types', 'documents.document_type_id', '=', 'document_types.id')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->join('departments', 'departments.id', '=', 'documents.department_id')
            ->where('documents.id', $id)
            ->select('documents.*', 'documents.id as documentID', 'document_types.name as name_type_document', 'users.*', 'departments.name as name_department')
            ->first();
        $replyDocument = DB::table('reply_document')->join('users', 'reply_document.user_id', '=', 'users.id')
            ->where('reply_document.document_id', $id)
            ->get();

        //array file attachment
        $fileString = Document::where('id', $id)->first();
        $arrayFileDecode = array();
        if (isset($fileString['file_attachment'])) {
            $arrayFileDecode = json_decode($fileString['file_attachment']);
        }

        return view('document.show', compact('document', 'arrayFileDecode', 'replyDocument', 'arrayFileReplyDecode'));
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

        return redirect()->route('document.show', $id);

    }

    public function store(DocumentAddRequest $request)
    {
        DB::beginTransaction();
        try {
            $documentData = $request->except('departments', 'attachedFiles', 'search', '_token', 'is_emergency');
            $documentData['user_id'] = Auth::user()->id;
            $departments = $request->only('departments');
            $attachedFiles = $request->only('attachedFiles');
            $documentId = Document::insertGetId($documentData);
            foreach ($departments as $department) {
                DocumentDepartment::create([
                    'document_id' => $documentId,
                    'department_id' => $department,
                    'sending_date' => Carbon::now(),
                    'is_approved' => config('setting.document.pending'),
                    'is_emergency' => $request->only('is_emergency'),
                ]);
            }
            foreach ($attachedFiles["attachedFiles"] as $key => $file) {
                DocumentAttachment::create([
                    'document_id' => $documentId,
                    'name' => $this->uploader->saveDocument($file,public_path('upload/files/document')),
                ]);
            }
            DB::commit();

            return redirect(route('document-sent.index'))->with('alert', 'Công văn đã được đưa vào danh sách phê duyệt');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect(route('document.create'))->with('alert', 'Gửi công văn thất bại, vui lòng kiểm tra lại');
        }
    }

    //ajax function
    public function handleSelectDepartment($id)
    {
        $receivedDepartments = Department::where('id', '!=', $id)->pluck('name', 'id');
        foreach ($receivedDepartments as $key => $value) {
            echo "<option value='$key'>$value</option>";
        }
    }
}
