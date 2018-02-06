<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\File;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;

class HomeController extends Controller
{
    use CourseEnrollTrait;

    public function index(Request $request, $schedule)
    {
        $schedule = Schedule::where('id', $schedule)
            ->with('course', 'course.teachers')
            ->with('point')
            ->withCount('teachers')
            ->withCount('students')
            ->first();
        $user = auth()->user();
        $isBatch = $this->isBatch($schedule->merchant, $schedule->course->id);
        $hasEnrolled = $user ? $this->hasEnrolled($schedule, $user) : false;
        if (!$hasEnrolled) {
            $available = $this->available($schedule);
        }
        $hasCommented = auth()->check() ? Comment::where('user_id', $user->id)->where('schedule_id', $schedule->id)->count() : false;
        return view('mobile.course-show', compact('schedule', 'hasEnrolled', 'isFull', 'available', 'user', 'hasCommented', 'isBatch'));
    }

    public function share(Request $request, $share)
    {
        $drawing = File::where('uuid', $share)->where('extension', 'png')->first();
        $video = File::where('uuid', $share)->where('extension', 'mp4')->first();
        return view('mobile.student-product', compact('drawing', 'video'));
    }

    public function home(Request $request)
    {
	    $items = Schedule::where('status','approved')
		    ->with('course', 'course.teachers')
		    ->with('point')
		    ->withCount('teachers')
		    ->withCount('students')
		    ->orderByDesc('id');
	    if($user=auth()->user()){
		    $items ->addSelect(DB::Raw("(select count(*) from schedule_user where schedule_user.schedule_id=schedules.id and type='student' and schedule_user.user_id=$user->id) as attended"));
	    }
		    
	    $items=$items->paginate();
	    //return redirect(route('schedules.index'));
	return view('mobile.course-list',compact('items'));
    }

    public function qr(Request $request)
    {
        $size = $request->get('size', 100);
//        QrCode::format('png')->size(100)->generate('Hello,LaravelAcademy!',public_path('qrcodes/qrcode.png'));
//        return QrCode::size($size)->generate('Hello,LaravelAcademy!');
        $content = QrCode::format('png')->size($size)->generate($request->data);
        return $request->has('download') ? $this->downloadImage($content, $request->data) : $this->showImage($content);
    }

    public function showImage($content)
    {
        return response($content, 200)
            ->header('Content-Type', 'image/png');
    }

    public function downloadImage($content, $data)
    {
        $filename = md5($data);
        return response($content, 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment;filename=' . $filename . '.png');
    }

}
