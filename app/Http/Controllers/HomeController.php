<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseApi;
use App\Models\Video;
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
    private $responseApi;
    public function __construct(UserRepositoryInterface $userRepository, VideoRepositoryInterface $videoRepository)
    {
        $this->userRepository = $userRepository;
        $this->videoRepository = $videoRepository;
        $this->responseApi = new ResponseApi();
    }
    /**
     * Controller method render home view blade
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $user = $this->userRepository->getMyInfo(Auth::id());
        //   dd($user->total_followers, $user->total_following, $user->total_video);
        return view('home', compact('user'));
    }

    /**
     * 
     * Controller method upload video and pussh to Google Driver
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function uploadVideo(Request $request)
    {
        $param = $request->all();
        $now = Carbon::now();
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $fileName = md5($now) . '.mp4';

            $file->move(public_path('videos'), $fileName);
            // Push file to Google Driver
            $googleDriverService = new GoogleDriverService();
            try {
                $fileId = $googleDriverService->synchronize(public_path('videos/' . $fileName), $fileName);

                $videoData = [
                    'video_url' => 'https://drive.google.com/file/d/' . $fileId . '/preview',
                    'caption' => $param['caption'],
                    'author_id' => Auth::id(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                $this->videoRepository->create($videoData);
            } catch (\Exception $e) {
                // dd($e);
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
}
