<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Statistical;
use App\Models\Statisticalbusinesses;
use App\Models\Voucher;
use App\Models\Departure;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MethodPaymentController extends Controller
{
    public function vnpay(Request $request)
    {
        //Xử lý phần cdsl---------------------------------------------------------------------------------------
        $data = $request->all();
        // Lưu dữ liệu đơn hàng vào cơ sở dữ liệu
        $txnRef = substr(md5(microtime()), rand(0, 26), 5);

        // Giả sử bạn có một mô hình Order và muốn lưu thông tin đơn hàng
        // Lưu thông tin đơn hàng
        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->order_status = 1;
        $order->order_code = $txnRef;

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->order_date = $order_date;
        $order->payment_method = $data['payment_method'];
        $order->save();
        // Lưu chi tiết đơn hàng
        $order_details = new Orderdetail();

        $order_details->order_code = $txnRef;
        $order_details->note = $data['note'];
        $order_details->tour_id = $data['tour_id'];
        $order_details->voucher = $data['voucher'];
        $order_details->nguoi_lon = $data['nguoi_lon'];
        $order_details->tre_em = $data['tre_em'];
        $order_details->tre_nho = $data['tre_nho'];
        $order_details->so_sinh = $data['so_sinh'];
        $order_details->sale = $data['sale'];
        $order_details->departure_date = $data['departure_date'];
        $order_details->save();

        Session::forget('voucher');
        $order_id = $order->order_id;

        Session::put('order_id', $order_id);
        Session::put('order_code', $txnRef);
        Session::put('tour_id', $data['tour_id']);
        $sales = 0;
        $tour = Tour::where('id', $data['tour_id'])->first();
        $price_adult = $tour->price;
        $price_child = $tour->price_treem;
        $price_infant = $tour->price_trenho;
        $price_newborn = $tour->price_sosinh;
        $voucher = null;
        if ($data['voucher']) {
            $voucher = Voucher::where('voucher_code', $data['voucher'])->first();
        }

        $revenue_adult = $data['nguoi_lon'] * $price_adult;
        $revenue_child = $data['tre_em'] * $price_child;
        $revenue_infant = $data['tre_nho'] * $price_infant;
        $revenue_newborn = $data['so_sinh'] * $price_newborn;
        $sales = $revenue_adult + $revenue_child + $revenue_infant + $revenue_newborn;
        if ($data['sale']!=0) {
            $sales = $sales*(100-$data['sale'])/100;
        }
        if ($voucher) {
            if ($voucher->voucher_condition == 1) {
                $sales = $sales - $voucher->voucher_number;
            } else {
                $sales = $sales - ($sales * $voucher->voucher_number / 100);
            }
        }


        //Kết thúc xủ lý csdl------------------------------------------------------------------------

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('methods.vnpay_return');
        $vnp_TmnCode = "CTIIG4ES"; //Mã website tại VNPAY 
        $vnp_HashSecret = "8Q4FMVE2LFEJPH8PBFFLBLZ1ZK6FAG3L"; //Chuỗi bí mật

        $vnp_TxnRef = $txnRef; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $sales * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        // $vnp_Bill_Email = $_POST['txt_billing_email'];
        // $fullName = trim($_POST['txt_billing_fullname']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }
        // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
        // $vnp_Bill_City=$_POST['txt_bill_city'];
        // $vnp_Bill_Country=$_POST['txt_bill_country'];
        // $vnp_Bill_State=$_POST['txt_bill_state'];
        // Invoice
        // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
        // $vnp_Inv_Email=$_POST['txt_inv_email'];
        // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
        // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
        // $vnp_Inv_Company=$_POST['txt_inv_company'];
        // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
        // $vnp_Inv_Type=$_POST['cbo_inv_type'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
            // "vnp_ExpireDate"=>$vnp_ExpireDate
            // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
            // "vnp_Bill_Email"=>$vnp_Bill_Email,
            // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
            // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
            // "vnp_Bill_Address"=>$vnp_Bill_Address,
            // "vnp_Bill_City"=>$vnp_Bill_City,
            // "vnp_Bill_Country"=>$vnp_Bill_Country,
            // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
            // "vnp_Inv_Email"=>$vnp_Inv_Email,
            // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
            // "vnp_Inv_Address"=>$vnp_Inv_Address,
            // "vnp_Inv_Company"=>$vnp_Inv_Company,
            // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
            // "vnp_Inv_Type"=>$vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }


        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        // if (isset($_POST['payment'])) {
        //     header('Location: ' . $vnp_Url);
        //     die();
        // } else {
        //     echo json_encode($returnData);
        // }
        if ($request->input('payment') === 'VNPAY') {
            return redirect()->away($vnp_Url);
        } else {
            $returnData = array('code' => '00', 'message' => 'success', 'data' => $vnp_Url);
            return response()->json($returnData);
        }
    }
    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = "8Q4FMVE2LFEJPH8PBFFLBLZ1ZK6FAG3L"; // Chuỗi bí mật
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $errorMessages = [
            '00' => 'Giao dịch thành công',
            '01' => 'Giao dịch chưa hoàn tất',
            '02' => 'Giao dịch bị lỗi',
            '04' => 'Giao dịch đảo (Khách hàng đã bị trừ tiền tại Ngân hàng nhưng giao dịch chưa thành công ở VNPAY)',
            '05' => 'VNPAY đang xử lý giao dịch này (Giao dịch hoàn tiền)',
            '06' => 'VNPAY đã gửi yêu cầu hoàn tiền sang Ngân hàng (Giao dịch hoàn tiền)',
            '07' => 'Giao dịch bị nghi ngờ gian lận',
            '09' => 'Giao dịch hoàn trả bị từ chối',
            '10' => 'Giao dịch không thành công do khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '11' => 'Giao dịch không thành công do đã hết hạn chờ thanh toán. Vui lòng thực hiện lại giao dịch.',
            '12' => 'Giao dịch không thành công do thẻ/tài khoản của khách hàng bị khóa.',
            '13' => 'Giao dịch không thành công do nhập sai mật khẩu xác thực giao dịch (OTP). Vui lòng thực hiện lại giao dịch.',
            '24' => 'Giao dịch không thành công do khách hàng hủy giao dịch',
            '51' => 'Giao dịch không thành công do tài khoản không đủ số dư để thực hiện giao dịch.',
            '65' => 'Giao dịch không thành công do tài khoản đã vượt quá hạn mức giao dịch trong ngày.',
            '75' => 'Ngân hàng thanh toán đang bảo trì.',
            '79' => 'Giao dịch không thành công do nhập sai mật khẩu thanh toán quá số lần quy định. Vui lòng thực hiện lại giao dịch.',
            '99' => 'Giao dịch không thành công do lỗi chưa xác định. Vui lòng liên hệ hỗ trợ.',
        ];

        $order_id = Session::get('order_id');
        $order_code = Session::get('order_code');
        $order = Order::where('order_id', $order_id)->first();
        $orderdetail = Orderdetail::where('order_code', $order_code)->first();

        if ($secureHash == $vnp_SecureHash) {
            $vnp_ResponseCode = $request->input('vnp_ResponseCode');
            if ($vnp_ResponseCode == '00') {
                $order->order_status=2;
                $order->save();
                $departure = Departure::where('tour_id', $orderdetail->tour_id)->where('departure_date', $orderdetail->departure_date)->first();
                $tour = Tour::where('id', $orderdetail->tour_id)->first();
                // Lưu lợi nhuận
                $statistic = Statistical::where('order_date', $order->order_date)->get();
                if ($statistic) {
                    $statistic_count = $statistic->count();
                } else {
                    $statistic_count = 0;
                }
                //tìm lợi nhuận của doanh nghiệm
                $statistic_business = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id', $tour->business_id)->get();
                if ($statistic_business) {
                    $statistic_businessc_count = $statistic_business->count();
                } else {
                    $statistic_businessc_count = 0;
                }
                $price_adult = $tour->price;
                $price_child = $tour->price_treem;
                $price_infant = $tour->price_trenho;
                $price_newborn = $tour->price_sosinh;
                $voucher = null;
                if($orderdetail->voucher !== null){
                    $voucher=Voucher::where('voucher_code',$orderdetail->voucher)->first();
                }

                $total_order = 0;
                $sales = 0;
                $profit = 0;
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                //cập nhật số lượng người trong bảng Lịch trình
                $update_quantity= $orderdetail->nguoi_lon + $orderdetail->tre_em + $orderdetail->tre_nho + $orderdetail->so_sinh;
                $departure->quantity= $departure->quantity-$update_quantity;
                $departure->save();
                //tính toán lợi nhuận
                $total_order += 1;
                // Tính doanh thu từ từng loại khách hàng
                $revenue_adult = $orderdetail->nguoi_lon * $price_adult;
                $revenue_child = $orderdetail->tre_em * $price_child;
                $revenue_infant = $orderdetail->tre_nho * $price_infant;
                $revenue_newborn = $orderdetail->so_sinh * $price_newborn;
                $sales= $revenue_adult + $revenue_child + $revenue_infant + $revenue_newborn;
                if ($voucher) {
                    if ($voucher->voucher_condition == 1) {
                        $sales = $sales - $voucher->voucher_number;
                    } else {
                        $sales = $sales - ($sales * $voucher->voucher_number / 100);
                    }
                }
                //Tính chi phí
                $desired_profit_margin = 0.30; // 30% lợi nhuận
                $total_cost = $sales - ($sales * $desired_profit_margin);
                //Tính lợi nhuận
                $profit = $sales - $total_cost;

                //Lưu statistical
                if ($statistic_count > 0) {
                    $statistic_update = Statistical::where('order_date', $order->order_date)->first();
                    $statistic_update->sales = $statistic_update->sales + $sales;
                    $statistic_update->profit = $statistic_update->profit + $profit;
                    $statistic_update->quantity = $statistic_update->quantity + $update_quantity;
                    $statistic_update->total_order = $statistic_update->total_order + $total_order;
                    $statistic_update->save();
                } else {
                    $statistic_new = new Statistical();
                    $statistic_new->order_date = $order->order_date;
                    $statistic_new->sales = $sales;
                    $statistic_new->profit = $profit;
                    $statistic_new->quantity = $update_quantity;
                    $statistic_new->total_order = $total_order;
                    $statistic_new->save();
                }

                //Lưu statistical cho từng doanh nghiệp
                if ($statistic_businessc_count > 0) {
                    $statistic_business_update = Statisticalbusinesses::where('order_date', $order->order_date)->where('business_id', $tour->business_id)->first();
                    $statistic_business_update->sales = $statistic_business_update->sales + $sales;
                    $statistic_business_update->profit = $statistic_business_update->profit + $profit;
                    $statistic_business_update->quantity = $statistic_business_update->quantity + $update_quantity;
                    $statistic_business_update->total_order = $statistic_business_update->total_order + $total_order;
                    $statistic_business_update->save();
                } else {
                    $statistic_business_new = new Statisticalbusinesses();
                    $statistic_business_new->order_date = $order->order_date;
                    $statistic_business_new->sales = $sales;
                    $statistic_business_new->profit = $profit;
                    $statistic_business_new->quantity = $update_quantity;
                    $statistic_business_new->total_order = $total_order;
                    $statistic_business_new->business_id = $tour->business_id;
                    $statistic_business_new->save();
                }

                // Chuyển hướng đến trang thành công
                return  redirect()->route('payment-success');
            } else {
                $order->delete();
                $orderdetail->delete();
                // Xử lý khi giao dịch không thành công
                $message = $errorMessages[$vnp_ResponseCode] ?? "Mã lỗi không xác định";
                return redirect()->route('payment-error')->with('error_message', $message);
            }
        } else {
            $order->delete();
            $orderdetail->delete();
            return redirect()->route('payment-error')->with('error_message', "Chữ ký không hợp lệ");
        }
        Session::forget('order_id');
        Session::forget('order_code');
        Session::forget('tour_id');
    }

    public function zalopay() {}

    //thanh toans momo start
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
       
        return $result;
    }
    public function momo(Request $request) {
     
        $data = $request->all();
      
        $txnRef = substr(md5(microtime()), rand(0, 26), 5);

         // Lưu thông tin đơn hàng
         $order = new Order();
         $order->customer_id = Session::get('customer_id');
         $order->order_status = 1;
         $order->order_code = $txnRef;
 
         date_default_timezone_set('Asia/Ho_Chi_Minh');
         $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
         $order->order_date = $order_date;
         $order->payment_method = $data['payment_method'];
         $order->save();
         // Lưu chi tiết đơn hàng
         $order_details = new Orderdetail();
 
         $order_details->order_code = $txnRef;
         $order_details->note = $data['note'];
         $order_details->tour_id = $data['tour_id'];
         $order_details->voucher = $data['voucher'];
         $order_details->nguoi_lon = $data['nguoi_lon'];
         $order_details->tre_em = $data['tre_em'];
         $order_details->tre_nho = $data['tre_nho'];
         $order_details->so_sinh = $data['so_sinh'];
         $order_details->sale = $data['sale'];
         $order_details->departure_date = $data['departure_date'];
         $order_details->save();
 
         Session::forget('voucher');
         $order_id = $order->order_id;
 
         Session::put('order_id', $order_id);
         Session::put('order_code', $txnRef);
         Session::put('tour_id', $data['tour_id']);
         $sales = 0;
         $tour = Tour::where('id', $data['tour_id'])->first();
         $price_adult = $tour->price;
         $price_child = $tour->price_treem;
         $price_infant = $tour->price_trenho;
         $price_newborn = $tour->price_sosinh;
         $voucher = null;
         if ($data['voucher']) {
             $voucher = Voucher::where('voucher_code', $data['voucher'])->first();
         }
 
         $revenue_adult = $data['nguoi_lon'] * $price_adult;
         $revenue_child = $data['tre_em'] * $price_child;
         $revenue_infant = $data['tre_nho'] * $price_infant;
         $revenue_newborn = $data['so_sinh'] * $price_newborn;
         $sales = $revenue_adult + $revenue_child + $revenue_infant + $revenue_newborn;
         if ($data['sale']!=0) {
            $sales = $sales*(100-$data['sale'])/100;
        }
         if ($voucher) {
             if ($voucher->voucher_condition == 1) {
                 $sales = $sales - $voucher->voucher_number;
             } else {
                 $sales = $sales - ($sales * $voucher->voucher_number / 100);
             }
         }
 
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $sales;
        $orderId = substr(md5(microtime()), rand(0, 26), 5);
        $redirectUrl = route('payment-success-momo');
        $ipnUrl = route('payment-success-momo');
        $extraData = "";
        
        
      
            $partnerCode = $partnerCode;
            $accessKey = $accessKey;
            $secretKey = $secretKey;
            $orderId = $txnRef; // Mã đơn hàng
            $orderInfo = $orderInfo;
            $amount = $amount;
            $ipnUrl = $ipnUrl;
            $redirectUrl = $redirectUrl;
            $extraData = $extraData;
        
            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array('partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature);
            $result = $this->execPostRequest($endpoint, json_encode($data));
         
            $jsonResult = json_decode($result, true);  // decode json
            //Just a example, please check more in there

            if (isset($jsonResult['resultCode'])) {
                if ($jsonResult['resultCode'] == 0) {
                    // Nếu thành công, trả về URL thanh toán
                    return response()->json(['data' => $jsonResult['payUrl']]);
                } else {
                    // Nếu có lỗi, trả về URL trang lỗi
                    return redirect()->route('payment-error')->with('error_message', $jsonResult['message']);
                }
            } else {
                // Nếu có lỗi, chuyển hướng đến trang báo lỗi
                return redirect()->route('payment-error')->with('error_message', 'Có lỗi xảy ra khi tạo đơn hàng.');
            }
        
        
    }
    public function viettel() {}
}
