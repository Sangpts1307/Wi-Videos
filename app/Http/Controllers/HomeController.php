<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseApi;
use App\Models\Video;
use App\Repositories\Users\UserRepositoryInterface;
use App\Repositories\Videos\VideoRepositoryInterface;
use App\Services\GoogleDriverService;
use App\Services\GoogleHangoutWebhook;
use App\Services\GoogleSpreadSheetService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $userRepository;
    private $videoRepository;
    private $responseApi;

    public function __construct(
        UserRepositoryInterface $userRepository, 
        VideoRepositoryInterface $videoRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->videoRepository = $videoRepository;
        $this->responseApi = new ResponseApi();
    }
    /**
     * Controller method render home view blade
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory\Iluminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $user = $this->userRepository->getMyInfo(Auth::user()->id);
        return view('home', compact('user'));
    }

    /**
     * Controller method upload video and push to Google Driver
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory\Iluminate\Routing\Redirector
     */
    public function uploadVideo(Request $request) 
    {
        $param = $request->all();
        $now = Carbon::now();
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $fileName = md5(Carbon::now()) . '.mp4';
            $file->move(public_path('videos'), $fileName);
            // $file->move_uploaded_file($fileName, public_path('videos'));
            $googleDriverService = new GoogleDriverService();
            try {
                $fileId = $googleDriverService->synchronize(public_path('videos') . '/' . $fileName, $fileName);
                // Save to database
                $videoData = [
                    'video_url' => 'https://drive.google.com/file/d/'.$fileId.'/preview',
                    'caption' => $param['caption'],
                    'author_id' => Auth::user()->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
                $this->videoRepository->create($videoData);
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
        return redirect('/home');
    }

    public function getVideo(Request $request) 
    {
        $userId = Auth::user()->id;
        $param = $request->all();
        $video = $this->videoRepository->getVideo($param['video_id']);
        // Kiem tra xem da like hay chua
        $isLike = false;
        $myVideo = false;
        $follow = false;
        if (count($video->likes) > 0) {
            foreach ($video->likes as $like) {
                if ($like->user_id == $userId) {
                    $isLike = true;
                }
            }
        }
        if ($video->author_id == $userId) {
            $myVideo = true;
        } else {
            // Kiem tra xem da follow hay chua
            $follow = $this->userRepository->find($userId)->followers->pluck('follow_id')->toArray();
            if (in_array($userId, $follow)) {
                $follow = true;
            }
        }
        $video->is_like = $isLike;
        $video->my_video = $myVideo;
        $video->follow = $follow;
        return $this->responseApi->success($video);
    }

    public function sendReport(Request $request)
    {
        $param = $request->all();
        // $googleHangout = new GoogleHangoutWebhook();
        // $googleHangout->reportForWebHook($param['report_content'], Auth::user()->name);
        $video = Video::find($param['video_id']);
        // Inert into google spreadsheets
        $googleSpreadsheet = new GoogleSpreadSheetService();
        $data = [
            "values" => [
                (string) $video->id,
                $video->caption ?? "",
                Auth::user()->name . " báo cáo " . $param['report_content'],
                $video->video_url,
                Carbon::now()->format('Y-m-d h:i:s')
            ]
        ];
        try {
            $googleSpreadsheet->writeSheet('Sheet1', $data);
        } catch (\Exception $e) {
            Log::error($e);
        }
        return $this->responseApi->success();

    }
}


