<?php

namespace App\Http\Controllers;

use App\Repositories\Users\UserRepositoryInterface;
use App\Repositories\Videos\VideoRepositoryInterface;
use App\Services\GoogleDriverService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $userRepository;
    private $videoRepository;

    public function __construct(
        UserRepositoryInterface $userRepository, 
        VideoRepositoryInterface $videoRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->videoRepository = $videoRepository;
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
}


