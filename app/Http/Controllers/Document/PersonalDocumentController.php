<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Document\PersonalDocumentAddRequest;
use App\Http\Requests\Document\ReplyDocumentRequest;
use App\Models\DepartmentUser;
use App\Models\Document;
use App\Models\DocumentAttachment;
use App\Models\DocumentType;
use App\Models\DocumentUser;
use App\Models\ReplyDocument;
use App\Uploaders\Uploader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonalDocumentController extends Controller
{
//    public function index()
    //    {
    //        Carbon::setLocale('vi');
    //        $documents = DB::table('documents')
    //            ->join('document_user', 'documents.id', '=', 'document_user.document_id')
    //            ->join('departments', 'departments.id', '=', 'documents.department_id')
    //            ->where('document_user.user_id', Auth::user()->id)
    //            ->select('documents.*', 'departments.name', 'document_user.is_seen')
    //            ->orderBy('created_at', 'desc')
    //            ->paginate(5);
    //        $this->setSeenDocument($documents);
    //
    //        return view("document.personal_document.index", compact('documents'));
    //    }
    //
    //    private function setSeenDocument($documents)
    //    {
    //        DocumentUser::whereIn('document_id', $documents->pluck('id'))->update(['is_seen' => config('setting.document_user.is_seen')]);
    //    }
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $departmentID = DepartmentUser::where('user_id', Auth::user()->id)->first()->department_id;
        $documentUser = DocumentUser::where('department_id', $departmentID)->get();
        $arrayDocumentId = array();
        if($documentUser->count()>0){
            foreach($documentUser as $value){
                if(isset($value->array_user_id)){
                    $jsonUserId = json_decode($value->array_user_id);
                    foreach($jsonUserId as $key){
                        if($key == Auth::user()->id){
                            array_push($arrayDocumentId, $value->document_id);
                        }
                    }
                }
            }
            $document = DB::table('documents')
                ->join('document_types', 'documents.document_type_id', '=', 'document_types.id')
                ->join('users', 'users.id', '=', 'documents.user_id')
                ->join('departments', 'departments.id', '=', 'documents.department_id')
                ->join('document_user', 'document_user.document_id', '=', 'documents.id')
                ->whereIn('document_id', $arrayDocumentId)
                ->where('documents.is_approved', config('setting.document.approved'))
                ->select(
                    'document_user.created_at as sent_date',
                    'document_user.*', 'documents.*',
                    'documents.id as documentID',
                    'document_types.name as name_type_document',
                    'users.*', 'departments.name as name_department'
                )
                ->orderBy('document_user.created_at', 'desc')
                ->paginate(5);
        }

        return view("document.personal_document.index", compact('document', 'documentUser'));
    }

    public function create()
    {
        $documentTypes = DocumentType::pluck('name', 'id');

        return view("document.personal_document.create", compact('documentTypes'));
    }

    public function store(PersonalDocumentAddRequest $request)
    {
        DB::beginTransaction();
        try {
            $departmentId = DepartmentUser::where('user_id', Auth::user()->id)->first()['department_id'];
            $documentData = $request->except('departments', 'attachedFiles', 'search', '_token');
            $documentData['user_id'] = Auth::user()->id;
            if(Auth::user()->role == config('setting.roles.admin_department'))
                $documentData['is_approved'] = config('setting.document.approved');
            elseif(Auth::user()->delegacy == config('setting.delegacy.department_admin'))
                $documentData['is_approved'] = config('setting.document.pending');
            $documentData['department_id'] = $departmentId;
            $documentData['publish_date'] = Carbon::parse($documentData['publish_date'])->format('Y-m-d');
            $attachedFiles = $request->only('attachedFiles');
            $documentId = Document::insertGetId($documentData);
            foreach ($attachedFiles["attachedFiles"] as $key => $file) {
                DocumentAttachment::create([
                    'document_id' => $documentId,
                    'name' => $this->uploader->saveDocument($file, public_path('upload/files/document')),
                ]);
            }
            $DepartmentUserData['document_id'] = $documentId;
            $DepartmentUserData['department_id'] = $departmentId;
            $DepartmentUserData['array_user_id'] = json_encode($this->getListUserId($departmentId));
            DocumentUser::create($DepartmentUserData);
            DB::commit();
            return redirect(route('document-sent.index'))->with('messageSuccess', 'Gửi thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('document-personal.create'))->with('messageFail', 'Gửi công văn thất bại, vui lòng kiểm tra lại');
        }
    }

    public function checkUserSeen($id)
    {
        $userIdSeen = DocumentUser::where('document_id', $id)->first();
        $check = true;
        if (isset($userIdSeen['array_user_seen']) && $userIdSeen['array_user_seen'] != "") {
            $jsonSeen = json_decode($userIdSeen['array_user_seen']);
            foreach ($jsonSeen as $value) {
                if (Auth::user()->id == $value) {
                    $check = false;
                    break;
                }
            }
            if ($check == true){
                array_push($jsonSeen, Auth::user()->id);
            }
            return $jsonSeen;

        } else {
            $jsonSeen = array();
            array_push($jsonSeen, Auth::user()->id);

            return $jsonSeen;
        }
    }

    public function getListUserId($id)
    {
        $userId = DepartmentUser::where('department_id', $id)->get();
        $jsonUserId = array();
        $getIdAdminDepartment =  DepartmentUser::where(['department_id' => $id, 'position_id' => config('setting.position.admin_department')])->first()->user_id;
        if (isset($userId)) {
            foreach ($userId as $value) {
                if($value->user_id != $getIdAdminDepartment )
                    array_push($jsonUserId, $value->user_id);
            }
            return $jsonUserId;
        }
    }

    public function show($id)
    {
        //check nguoi xem tin
        $departmentID = DepartmentUser::where('user_id', Auth::user()->id)->first()->department_id;
        $jsonUserId = json_encode($this->checkUserSeen($id));
        DocumentUser::where(['document_id' => $id, 'department_id' => $departmentID])->update(['array_user_seen' => $jsonUserId]);

        $document = DB::table('documents')
            ->join('document_types', 'documents.document_type_id', '=', 'document_types.id')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->join('departments', 'departments.id', '=', 'documents.department_id')
            ->join('document_user', 'document_user.document_id', '=', 'documents.id')
            ->where('documents.id', $id)
            ->select(
                'documents.*',
                'document_user.created_at as sending_date',
                'documents.id as documentID',
                'document_types.name as name_type_document',
                'users.*',
                'departments.name as name_department')
            ->first();
        if(!isset($document))
            return redirect(route('document-personal.index'))->with('messageFail', 'Lỗi khi tải công văn, vui lòng kiểm tra lại');
        $replyDocument = DB::table('reply_document')->join('users', 'reply_document.user_id', '=', 'users.id')
            ->where(['reply_document.document_id' => $id, 'is_reply_personal_document' => config('setting.reply.is_reply_personal_document')])
            ->select('reply_document.*', 'users.avatar', 'users.name')
            ->get();
        //array file attachment
        $arrayFileDecode = DocumentAttachment::where('document_id', $id)->get();

        return view('document.personal_document.detail', compact('document', 'arrayFileDecode', 'replyDocument'));
    }

    public function reply(ReplyDocumentRequest $request, $id)
    {
        $input = $request->all();
        $input['document_id'] = $id;
        $input['user_id'] = Auth::user()->id;
        $input['is_reply_personal_document'] = config('setting.reply.is_reply_personal_document');

        if (!isset($input['file_attachment_reply'])) {
            $input['file_attachment_reply'] = null;
            ReplyDocument::create($input);
        } else {
            $path = 'upload/files/document_reply';
            $arrFiles = $this->uploader->saveFileAttach($input['file_attachment_reply'], $path);
            $input['file_attachment_reply'] = json_encode($arrFiles);
            ReplyDocument::create($input);
        }
        return redirect()->route('document-personal.show', $id);
    }

    public function edit($id){
        $document = DB::table('documents')->join('document_types', 'documents.document_type_id', '=', 'document_types.id')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->join('departments', 'departments.id', '=', 'documents.department_id')
            ->where('documents.id', $id)
            ->select('documents.*', 'documents.id as documentID', 'document_types.name as name_type_document', 'users.*', 'departments.name as name_department')
            ->first();
        if(!isset($document))
            return redirect()->route('document-personal.index')->with('messageFail', 'Không tìm thấy văn bản này, vui lòng kiểm tra lại');
        $documentTypes = DocumentType::pluck('name', 'id');
        return view('document.personal_document.edit', compact('document', 'documentTypes'));
    }

    public function update(Request $request, $id){
        DB::beginTransaction();
        try {
            $departmentId = DepartmentUser::where('user_id', Auth::user()->id)->first()['department_id'];
            $documentData = $request->except('attachedFiles', '_token', '_method');
            $documentData['publish_date'] = Carbon::parse($documentData['publish_date'])->format('Y-m-d');
            $document = Document::where('id', $id);
            if(!isset($document))
                return redirect()->route('document-personal.index')->with('messageFail', 'Không tìm thấy văn bản này, vui lòng kiểm tra lại');
            $document->update($documentData);
            $attachedFiles = $request->only('attachedFiles');
            if(count($attachedFiles) > 0){
                DocumentAttachment::where('document_id', $id)->delete();
                foreach ($attachedFiles["attachedFiles"] as $key => $file) {
                    DocumentAttachment::create([
                        'document_id' => $id,
                        'name' => $this->uploader->saveDocument($file, public_path('upload/files/document')),
                    ]);
                }
            }
            DB::commit();
            return redirect(route('document-sent.index'))->with('messageSuccess', 'Cập nhật thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('document-personal.edit', $id))->with('messageFail', 'Cập nhật công văn thất bại, vui lòng kiểm tra lại');
        }
    }

}
