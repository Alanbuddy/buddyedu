<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\File;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    use CourseEnrollTrait;

    public function index(Request $request, $schedule)
    {
        dd(session()->all());
        $schedule = Schedule::where('id', $schedule)
            ->with('course', 'course.teachers')
            ->with('point')
            ->withCount('teachers')
            ->withCount('students')
            ->first();
        $user = auth()->user();
        $hasEnrolled = $user ? $this->hasEnrolled($schedule, $user) : false;
        if (!$hasEnrolled) {
            $available = $this->available($schedule);
        }
        $hasCommented = auth()->check() ? Comment::where('user_id', $user->id)->where('schedule_id', $schedule->id)->count() : false;
        return view('mobile.course-show', compact('schedule', 'hasEnrolled', 'isFull', 'available', 'user', 'hasCommented'));
    }

    public function share(Request $request, $share)
    {
        $drawing= File::where('uuid', $share)->where('extension', 'png')->where('uuid',$share)->first();
        $video = File::where('uuid', $share)->where('extension', 'mp4')->find($share);
//        dd($drawing,$video);

        return view('mobile.student-product', compact('drawing', 'video'));
    }

    public function home(Request $request)
    {
        dd(2);
        $items = auth()->user()->enrolledShedules()
            ->with('point', 'course')
            ->paginate();
        dd($items);
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
