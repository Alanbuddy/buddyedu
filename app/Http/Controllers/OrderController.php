<?php

namespace App\Http\Controllers;

use App\Facades\MessageFacade;
use App\Http\Wechat\WxApi;
use App\Models\Course;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPExcel;
use PHPExcel_Writer_Excel2007;
use Wechat\WxPayApi;
use Wechat\WxPayOrderQuery;
use Wechat\WxPayRefund;
use Wechat\WxPayUnifiedOrder;

class OrderController extends Controller
{
    public static function updatePaymentStatus(Request $request, $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        $result = self::queryOrder($request, $order->uuid);
        if ('SUCCESS' == $result['result_code']) {
            $order->status = $result['trade_state'] == 'SUCCESS' ? 'paid' : 'refunded';
            $order->wx_transaction_id = $result['transaction_id'];
            $order->wx_total_fee = $result['total_fee'];
            $order->update();
        }
        Log::info(json_encode($result));
        dd($result, $result['result_code']);
    }

    public static function queryOrder(Request $request, $uuid)
    {
        $payOrderQuery = new WxPayOrderQuery();
        $payOrderQuery->SetOut_trade_no($uuid);
        $result = WxPayApi::orderQuery($payOrderQuery);
        return $result;
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Order::orderBy('id', 'desc')->paginate(10);
        return view('admin.order.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.order.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('admin.order.show', ['item' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function pay(Request $request)
    {
        $course = Schedule::findOrFail($request->get('schedule_id'));
        if ($this->hasEnrolled($course, auth()->user()->id)) {
            Log::debug(__METHOD__ . '已经加入课程');
            return ['success' => false, 'message' => '已经加入课程'];
        }
        if ($course->quota && $course->students()->count() == $course->quota
        ) {
            Log::debug(__METHOD__ . '课程学员已满');
            return ['success' => false, 'message' => '课程学员已满'];
        }

        $order = $this->store($request);
        try {
            //调用统一下单API
            $ret = $this->placeUnifiedOrder($order);
            Log::debug(__FILE__ . __LINE__ . json_encode($ret));
            $appId = $ret['appid'];
            $timeStamp = time();
            $nonceStr = WxApi::getNonceStr();
            $prepayId = $ret['prepay_id'];
            $package = 'prepay_id=' . $prepayId;
            $signType = 'MD5';
            $values = compact(
                'appId', 'timeStamp', 'nonceStr', 'package', 'signType'
            );
            $sign = WxApi::makeSign($values);
            $data = array_merge($values, compact('sign', 'prepayId', 'order'));
            if ($request->ajax()) {
                return ['success' => true, 'data' => $data];
            }
            return view('admin.order.pay', $data);
        } catch (\Exception $e) {
            print($e->getMessage());
            $this->logError('wxpay.unifiedOrder', $e->getMessage(), '', '');
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new Order();
        $course = Schedule::findOrFail($request->get('schedule_id'));
        $order->title = 'buy course ' . $course->name;
        $order->merchant_id = $request->get('merchat_id');
        $order->product_id = $course->id;
        $order->amount = $course->price ?: $course->original_price;
        $order->uuid = $this->uuid();
        auth()->user()->orders()->save($order);
        return $order;
    }

    public function uuid()
    {
        return md5(uniqid(rand(), true));
    }

    public function placeUnifiedOrder($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody('购买' . $order->title);
        $input->SetAttach("test");
        $input->SetOut_trade_no($order->uuid); //$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
        $input->SetTotal_fee($order->amount * 100);
//        $input->SetTotal_fee(1);//dev set to 1 cent
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url(route('wechat.payment.notify'));
        $input->SetTrade_type("JSAPI");//交易类型为公众号支付
        $input->SetProduct_id("32");
        $input->SetOpenid(auth()->user()->openid);
        $result = WxPayApi::unifiedOrder($input);
        Log::debug('统一下单api返回值:' . json_encode($result));
        if ($result['result_code'] == 'FAIL') {
            throw  new \Exception(json_encode($result));
        }
        return $result;
    }

    //退款

    public function refund(Request $request, $uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();

        $input = new WxPayRefund();
        $input->SetOut_trade_no($order->uuid);
        $input->SetOut_refund_no($order->uuid);
        //如果SetRefund_fee(0)，$result会是签名错误
        $input->SetRefund_fee($order->wx_total_fee);//单位为分 //$input->SetRefund_fee(1);
        $input->SetTotal_fee($order->wx_total_fee);//单位为分
        $input->SetOp_user_id(config('wechat.mch.mch_id'));
        $result = WxPayApi::refund($input);
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $order->status = 'refunded';
            $order->save();
            $course = Course::findOrFail($order->product_id);
            $course->students()->detach($order->user_id);//把学员退出课程
            MessageFacade::sendRefundCompletedMessage(User::find($order->user_id), $course);

            if ($_SERVER['SCRIPT_NAME'] != 'artisan') {
                return view('setting.refund', compact('course'));
            }
            return ['success' => true];
        } else {
            return [
                'success' => false,
                'message' => array_key_exists('err_code', $result)
                    ? $result['err_code']
                    : $result['return_msg']
            ];
        }
    }


    public function tmp(Request $request)
    {
        $course = Course::find($request->course_id);
        return view('setting.show', compact('course'));
    }

    public function incomeOfRangeQuery($left, $right)
    {
        return Order::where('status', 'paid')
            ->where('created_at', '>', date('Y-m-d', $left ? strtotime($left) : time()))
            ->where('created_at', '<', date('Y-m-d', strtotime($right)));
    }

    public function incomeOfTodayQuery()
    {
        return $this->incomeOfRangeQuery('', 'today +1 days');
    }

    public function incomeOfThisWeekQuery()
    {
        return $this->incomeOfRangeQuery('-1 week Monday', '0 week Monday');
    }

    public function incomeOfThisMonthQuery()
    {
        return $this->incomeOfRangeQuery('-1 month Monday', '0 month Monday');
    }

    public function incomeOfSelectedRangeQuery($left, $right)
    {
        return $this->incomeOfRangeQuery($left, $right);
    }

    public function incomeQuery()
    {
        return Order::where('status', 'paid');
    }

    public function statistics(Request $request, $merchant = null)
    {
        list($left, $right) = $this->getRange($request);
        $incomeOfToday = $this->incomeOfTodayQuery();
        $incomeOfThisWeek = $this->incomeOfThisWeekQuery();
        $incomeOfThisMonth = $this->incomeOfThisMonthQuery();
        $incomeOfSelectedRange = $this->incomeOfSelectedRangeQuery($left, $right);
        $income = $this->incomeQuery();
        if ($merchant) {
            $incomeOfToday->where('merchant_id', $merchant->id);
            $incomeOfThisWeek->where('merchant_id', $merchant->id);
            $incomeOfThisMonth->where('merchant_id', $merchant->id);
            $incomeOfSelectedRange->where('merchant_id', $merchant->id);
            $income->where('merchant_id', $merchant->id);
        }
        $incomeOfToday = $incomeOfToday->sum('amount');
        $incomeOfThisWeek = $incomeOfThisWeek->sum('amount');
        $incomeOfThisMonth = $incomeOfThisMonth->sum('amount');
        $incomeOfSelectedRange = $incomeOfSelectedRange->sum('amount');
        $income = $income->sum('amount');
        return compact('items', 'incomeOfToday', 'incomeOfThisWeek', 'incomeOfThisMonth', 'incomeOfSelectedRange', 'income');
    }


    public function getRange(Request $request)
    {
//        $left = $request->get('left', date('Y-m-d', strtotime('-1 week Monday')));
        $left = $request->get('left', date('Y-m-d', strtotime('-700 days')));
        $right = $request->get('right', date('Y-m-d'));
        return [$left, $right];
    }

    public function statGroupByMerchant(Request $request)
    {
        list($left, $right) = $this->getRange($request);
        $key = $request->key;
        $query = Merchant::orderBy('id', 'desc')
            ->withCount(['schedules as ongoingSchedules_count' => function ($query) {
                $query->where('end', '>', date('Y-m-d H:i:s'));
            }])
            ->withCount('schedules')
            ->addSelect('merchants.id as mid')
            ->addSelect(DB::raw('(select count(*) from schedules join schedule_user on schedules.id=schedule_user.schedule_id join merchants on merchants.id=schedules.merchant_id where schedule_user.type=\'student\' and schedules.end > date_format(now(),\'%Y-%m-%d %H:%i:%s\') and merchants.id=mid ) as ongoingStudentCount'))
            ->addSelect(DB::raw('(select count(*) from schedules join schedule_user on schedules.id=schedule_user.schedule_id join merchants on merchants.id=schedules.merchant_id where schedule_user.type=\'student\' and merchants.id=mid ) as studentCount'))
            ->addSelect(DB::raw('(select sum(round(amount/100,2)) from orders join schedules on schedules.id=product_id join merchants on merchants.id=schedules.merchant_id where merchants.id=mid and orders.status=\'paid\') as income'))
            ->addSelect(DB::raw('(select sum(round(amount/100,2)) from orders join schedules on schedules.id=product_id join merchants on merchants.id=schedules.merchant_id where merchants.id=mid and orders.status=\'paid\' and orders.created_at > \'' . $left . '\' and orders.created_at <\'' . $right . '\') as incomeOfSelectedRange'));
        if ($key) {
            $query->where('merchants.name', 'like', "%$key%");
        }
        $items = $query->paginate(10);
        $queryParameter = compact('left', 'right');
        if ($key)
            $queryParameter['key'] = $key;
        $items->withPath(route('orders.stat-group-by-merchant') . '?' . http_build_query($queryParameter));
        return view('admin.amount.index', array_merge($this->statistics($request), compact('items')));

    }

    public function statGroupByCourse(Request $request)
    {
        list($left, $right) = $this->getRange($request);
        $key = $request->key;
        $query = Course::orderBy('id', 'desc')
            ->withCount(['schedules as ongoingSchedules_count' => function ($query) {
                $query->where('end', '>', date('Y-m-d H:i:s'));
            }])
            ->withCount('schedules')
            ->addSelect('courses.id as cid')
            ->addSelect(DB::raw('(select count(*) from schedules join schedule_user on schedules.id=schedule_user.schedule_id join courses on courses.id=schedules.course_id where schedule_user.type=\'student\' and schedules.end > date_format(now(),\'%Y-%m-%d %H:%i:%s\') and courses.id=cid ) as ongoingStudentCount'))
            ->addSelect(DB::raw('(select count(*) from schedules join schedule_user on schedules.id=schedule_user.schedule_id join courses on courses.id=schedules.course_id where schedule_user.type=\'student\' and courses.id=cid ) as studentCount'))
            ->addSelect(DB::raw('(select sum(round(amount/100,2)) from orders join schedules on schedules.id=product_id join courses on courses.id=schedules.course_id where courses.id=cid ) as income'))
            ->addSelect(DB::raw('(select sum(round(amount/100,2)) from orders join schedules on schedules.id=product_id join courses on courses.id=schedules.course_id where courses.id=cid and orders.created_at > \'' . $left . '\' and orders.created_at <\'' . $right . '\') as incomeOfSelectedRange'));

        if ($key) {
            $query->where('courses.name', 'like', "%$key%");
        }
        $items = $query->paginate(10);
        $queryParameter = compact('left', 'right');
        if ($key)
            $queryParameter['key'] = $key;
        $items->withPath(route('orders.stat-group-by-course') . '?' . http_build_query($queryParameter));
        return view('admin.amount.course-amount', array_merge($this->statistics($request), compact('items')));
    }

    public function merchantTransactionsQuery(Request $request, $merchant)
    {
        $items = $this->ordersOfMerchant($merchant);
        if ($request->left || $request->right) {
            list($left, $right) = $this->getRange($request);
            $items->where('orders.created_at', '>', date('Y-m-d H:i:s', strtotime($left)))
                ->where('orders.created_at', '<', date('Y-m-d H:i:s', strtotime($right)));
        }
        return $items;
    }

    public function merchantTransactions(Request $request)
    {
        $merchant = auth()->user()->ownMerchant;
        $items = $this->merchantTransactionsQuery($request, $merchant)
            ->paginate(10);
        return view('agent.amount.index', array_merge($this->statistics($request, $merchant), compact('items')));
    }

    public function exportCsv(Request $request)
    {
        $fp = fopen('php://memory', 'w');
        fputcsv($fp, array('课程名称', '开课日期', '教学点', '手机号', '学生姓名', '收支金额'), ',');
        $merchant = auth()->user()->ownMerchant;
        $items = $this->merchantTransactionsQuery($request, $merchant)->get();
        foreach ($items as $item) {
            fputcsv($fp, array($item->schedule->course->name, $item->schedule->begin, $item->schedule->point->name,
                $item->user->phone, $item->user->name, $item->amount), ',');
        }
        rewind($fp);
        $content = "";
        while (!feof($fp)) {
            $content .= fread($fp, 1024);
        }
        fclose($fp);
//        $content = iconv('utf-8','gbk',$content);//转成gbk，否则excel打开乱码
        return (new Response($content, 200))//->header('Content-Type', "text/csv")
        ->header('Content-Type', "application/vnd.ms-excel")
            ->header('Content-Disposition', 'attachment;filename="breakdown.csv"');
    }

    public function exportExcel()
    {
        $PHPExcel = new PHPExcel();
        $currentSheet = $PHPExcel->getActiveSheet();

        $currentSheet->setCellValue('A1', "A");
        $objWriter = new PHPExcel_Writer_Excel2007($PHPExcel); // 用于 2007 格式
        $objWriter->save("output.xls");
    }

    private function ordersOfMerchant(Merchant $merchant)
    {
        return $merchant->orders()
            ->orderByDesc('id')
            ->where('orders.status', 'paid')
            ->with('schedule.course')
            ->with('schedule.point')
            ->with('user');

    }

    public function merchantIncomeGroupByCourse(Request $request, Merchant $merchant)
    {
        $query = $merchant->courses()
            ->get();
        dd($query);

    }

}
