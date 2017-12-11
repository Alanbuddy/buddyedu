<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use CourseEnrollTrait;

    function __construct()
    {
        $this->middleware(['auth', 'role:admin|operator|merchant'])
            ->only(['index', 'create', 'store', 'destroy', 'update']);
    }

    public function isAdmin()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $isAdmin = $this->isAdmin();

        if ($isAdmin) {
            $items = Course::orderBy('id', 'desc')->withCount('merchants');
        } else {
            $merchant = auth()->user()->ownMerchant;
            $items = $merchant ? $merchant->courses()->orderBy('id', 'desc')
                : collect([]);
        }
        if ($request->key) {
            $items->where('name', 'like', '%' . $request->get('key') . '%');
        }
        $items = $items->paginate(10);
        if ($request->key) {
            $items->withPath(route('courses.index') . '?' . http_build_query(['key' => $request->key,]));
        }
        return view($isAdmin ? 'admin.auth-course.index' : 'agent.course.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules());
        $course = new Course();
        $course = $course->fill($request->only([
            'name', 'price', 'proportion', 'icon', 'url', 'description', 'detail', 'lessons_count'
        ]));
        $course->status = 'draft';
        $course->save();
        return ['success' => true, 'data' => $course];
    }

    /**
     * course store and update validation rules
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'lessons_count' => 'required|numeric',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $course = $course->fill($request->only([
            'name', 'price', 'discount'
        ]));
        $course->status = 'draft';
        $course->update();
        return ['success' => true, 'data' => $course];
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['success' => true]);
    }

    public function enrollIn(Course $course)
    {
        $user = auth()->user();
        $order = $this->getEnrollOrder($course);
        return $order
            ? $this->enroll($course, $user->id)
            : ['success' => false, 'message' => 'no finished order found'];
    }

    public function toggle(Course $course)
    {
        $course->update([
            'status' => $course->status == 'draft' ? 'publish' : 'draft'
        ]);
        return $course;
    }

    /**
     * 授权机构
     */
    public function merchants(Course $course)
    {
        return $course->merchants()->get();
    }
}
