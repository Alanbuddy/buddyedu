<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $hasEnrolled = $user ? $this->hasEnrolled($schedule, $user) : false;
        if (!$hasEnrolled) {
            $isFull = $this->isFull($schedule);
            $available = $this->available($schedule);
        }
        return view('mobile.course-show', compact('schedule', 'hasEnrolled', 'isFull', 'available', 'user'));
    }

    public function home(Request $request)
    {
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
        return (new Response($content, 200))
            ->header('Content-Type', 'image/png');
    }

}
