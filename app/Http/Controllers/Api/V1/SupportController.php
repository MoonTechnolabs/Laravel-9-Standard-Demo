<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Models\Support;
use App\Http\Traits\Common;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;
use App\Models\SupportAttachment;
use App\Models\SupportHistory;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    use Common;
    
    /**
     * @OA\Post(
     * path="/support/create",
     * summary="Create Support ",
     * description="Create Support",
     * operationId="createSupport",
     * tags={"Support"},
     * security={ {"passport": {} }},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(
     *                    description="file to upload",
     *                    property="file_name[]",
     *                    type="array",
     *                       @OA\Items(
     *                          type="file",
     *                          format="binary"
     *                      ),
     *               required={"file","name"},
     *           ),
     *          @OA\Property(property="name", type="string", format="text", example="Dummy User"),     
     *          @OA\Property(property="email", type="string", format="email", example="laraveladmin@yopmail.com"),     
     *          @OA\Property(property="phone_number", type="string", format="text", example="123456789"),
     *          @OA\Property(property="message", type="text", format="text", example="This is Test Message"),
     *          @OA\Property(property="status", type="text", format="text", example="1",description="1-Open, 2-ReOpen, 3-Close, 4-OnHold"),
     *       ),    
     *    ),
     * ),          
     *  @OA\Response(
     *     response=202,
     *     description="Server Error",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Sorry, Server Erorr")
     *      )         
     *   ),
     * )
     */
    public function store(Request $request)
    {
        try {

            $rules = [
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'message' => 'required',
                'status' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->fail([], $validator->errors()->first());
            }

            DB::beginTransaction();
            $support = new Support();
            $support->ticket_no = uniqid();
            $support->name = $request->name;
            $support->email = $request->email;
            $support->phone_number = $request->phone_number;
            $support->message = $request->message;
            $support->status = config('const.STATUS_OPEN_INT');
            $support->save();
            if (!empty($support)) {
                $attachement = $request->file('file_name');
                foreach ($attachement as $key => $file) {
                    $SupportAttachmentdata = new SupportAttachment();
                    $attachement_filename =  time() . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(config('const.ATTACHMENTUPLOADPATH'), $attachement_filename);
                    $SupportAttachmentdata->file_name = $attachement_filename;
                    $SupportAttachmentdata->support_id = $support->id;
                    $SupportAttachmentdata->save();
                }
                $attachement = SupportAttachment::where('support_id', $support->id)->get();
                $support->attachment = $attachement;

                $historyData = new SupportHistory();
                $historyData->support_id = $support->id;
                $historyData->from_status = $request->status;
                $historyData->to_status = $request->status;
                $historyData->comment = $request->message;
                $historyData->changed_by = auth()->user()->id;
                $historyData->save();
                // return $support;
            }

            DB::commit();
            return $this->success($support, __('api.supportcreate'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail([], $e->getMessage());
        }
    }
}
