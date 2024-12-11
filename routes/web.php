<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DepartureController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\MethodPaymentController;
use App\Http\Controllers\TypetourController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [IndexController::class, 'index'])->name('homeweb');
Route::post('/history', [IndexController::class, 'history'])->name('history');
Route::get('/about', [IndexController::class, 'about_us'])->name('about_us');
Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
Route::get('/secure', [IndexController::class, 'secure'])->name('secure');
Route::get('/clause', [IndexController::class, 'clause'])->name('clause');
Route::get('/suport', [IndexController::class, 'suport'])->name('suport');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Admin
Route::get('/users/manage-doanh-nghiep', [AdminController::class, 'business_manage'])->name('admin.business_manage');
Route::get('/users/manage-khach-hang', [AdminController::class, 'customer_manage'])->name('admin.customer_manage');
Route::post('/users/destroy/{id}', [AdminController::class, 'destroy_customer'])->name('admin.destroy_customer');

Route::get('/users/manage-doanh-nghiep/duyet-dn/{id}', [AdminController::class, 'edit_register'])->name('admin.accept_register');
Route::patch('/users/manage-doanh-nghiep/tuchoi-dn/{id}', [AdminController::class, 'refuse_register'])->name('admin.refuse_register');
Route::patch('/users/manage-doanh-nghiep/boduyet-dn/{id}', [AdminController::class, 'boduyet_register'])->name('admin.boduyet_register');
Route::post('/users/manage-doanh-nghiep/tao-account', [AdminController::class, 'create_account_business'])->name('admin.create_account_business');
Route::get('/tours/admin-manage-tour', [ToursController::class, 'admin_index_tour'])->name('tours.admin_index_tour');

//Home page function
Route::get('tim-kiem', [IndexController::class, 'search'])->name('tim-kiem');
// Route::get('loc', [IndexController::class, 'filterTours'])->name('filter');

//Categories
Route::resource('/categories', CategoriesController::class);
//Categories
Route::resource('/types', TypetourController::class);

//Tours
Route::get('/tours/departure', [ToursController::class, 'manage_departure'])->name('tours.departure');
Route::get('/tour/{slug}', [ToursController::class, 'tour'])->name('tour');

Route::get('/chi-tiet-tour/{slug}', [ToursController::class, 'detail_tour'])->name('chi-tiet-tour');
Route::get('/tours/itinerary', [ToursController::class, 'manage_itinerary'])->name('tours.itinerary');
Route::get('/tours/service', [ToursController::class, 'manage_service'])->name('tours.service');
Route::resource('/tours', ToursController::class);
Route::get('/tours/xem/{id}', [ToursController::class, 'xem'])->name('tours.xem');
Route::post('/upload-image', [ImageUploadController::class, 'uploadImage'])->name('upload.image');
Route::patch('/tours/gui-duyet/{id}', [ToursController::class, 'gui_duyet'])->name('tours.guiduyet');
Route::patch('/tours/xoa/{id}', [ToursController::class, 'xoa'])->name('tours.xoa');
Route::patch('/tours/duyet/{id}', [ToursController::class, 'duyet'])->name('tours.duyet');
Route::patch('/tours/tuchoi-duyet/{id}', [ToursController::class, 'tuchoi_duyet'])->name('tours.tuchoi_duyet');
Route::post('/tour/like', [ToursController::class, 'tour_like'])->name('tour.like');

//Departudre
Route::resource('/tours/departures', DepartureController::class);
//Itinerary
Route::resource('/tours/itineraries', ItineraryController::class);
Route::get('/tours/itinerary/add/{day_number}/{tour_id}', [ItineraryController::class, 'add'])->name('itineraries.add');
Route::get('/tours/itinerary/change/{tour_id}/{day_number}', [ItineraryController::class, 'change'])->name('itineraries.change');
Route::post('/tours/itinerary/updated/{tour_id}/{day_number}', [ItineraryController::class, 'update_itinerary'])->name('itineraries.updated');
Route::delete('/tours/itinerary/change/destroy/{itinerarydetail}', [ItineraryController::class, 'destroy_itinerarydetail'])->name('itineraries.destroy_itinerarydetail');
Route::get('/tours/itinerary/edit/{itinerarydetail}', [ItineraryController::class, 'show_itinerayDetail'])->name('itineraries.show_itinerayDetail');
Route::post('/tours/itinerary/edit/{itinerarydetail}', [ItineraryController::class, 'edit_itinerayDetail'])->name('itineraries.edit_itinerayDetail');
Route::post('/upload-image', [ImageUploadController::class, 'uploadImage']);
//Gallery
Route::resource('/galleries', GalleryController::class);

//Customer
Route::resource('/customers', CustomerController::class);
Route::get('dang-nhap-tai-khoan', [IndexController::class, 'login_customer'])->name('login_customer');
Route::get('dang-ky-tai-khoan', [IndexController::class, 'register_customer'])->name('register_customer');
Route::post('dang-nhap', [CustomerController::class, 'login'])->name('customers.login');
Route::post('dang-xuat', [CustomerController::class, 'logout'])->name('customers.logout');
Route::get('thong-tin-khach-hang/{id}', [CustomerController::class, 'infor'])->name('customers.infor');
Route::get('thong-tin-tour-dat/{id}', [CustomerController::class, 'ordered'])->name('customers.ordered');
Route::get('tour-da-thich/{id}', [CustomerController::class, 'liked'])->name('customers.liked');
Route::post('update-departure-date/{id}', [CustomerController::class, 'update_order_date'])->name('customers.update_order_date');
Route::delete('huy-tour/{id}', [OrderController::class, 'destroy_has_paid'])->name('orders.destroy_has_paid');
Route::put('/profile/update', [CustomerController::class, 'update'])->name('profile.update');
Route::get('/profile/change-password/{id}', [CustomerController::class, 'showChangePasswordForm'])->name('customers.changePasswordForm');
Route::put('/profile/change-password/{id}', [CustomerController::class, 'changePassword'])->name('customers.changePassword');

//Contact
Route::resource('/contacts', ContactController::class);

// bussiness
Route::get('dang-ky-doanh-nghiep', [BusinessController::class, 'register_business'])->name('businesses.register_business');
Route::post('dang-ky', [BusinessController::class, 'store_register'])->name('businesses.store_register_business');
Route::get('customer-tour', [BusinessController::class, 'ditour'])->name('businesses.ditour');


//Banner
Route::resource('/banners', BannersController::class);


//Order
Route::resource('/orders', OrderController::class);
Route::get('/orders/business/order', [OrderController::class, 'business_index'])->name('orders.business_index');
Route::post('/confirm-order', [OrderController::class, 'confirm_order'])->name('orders.confirm');
Route::post('/orders/update_quantity', [OrderController::class, 'update_quantity'])->name('orders.update_quantity'); //cạp nhật số lượng người và trạng thái tt
Route::get('/orders-refund/refund', [OrderController::class, 'refund_index'])->name('orders.refund_index');
Route::post('/orders/refund/{id}', [OrderController::class, 'refund'])->name('orders.refund');

//Comment
Route::resource('/comment', CommentController::class);
Route::post('/reply', [CommentController::class, 'reply'])->name('comment.reply');
Route::post('/request', [CommentController::class, 'request_destroy'])->name('comment.request_destroy');
Route::PATCH('/huyyeucau/{id}', [CommentController::class, 'huyyeucau'])->name('comment.huyyeucau');
Route::PATCH('/recycle/{id}', [CommentController::class, 'recycle'])->name('comment.recycle');
Route::get('/comment/bussiness/index', [CommentController::class, 'business_index'])->name('comment.business_index');
Route::get('/comment/bussiness/reply', [CommentController::class, 'business_create'])->name('comment.business_create');

//Voucher
Route::resource('/vouchers', VoucherController::class);
Route::post('/check-voucher', [VoucherController::class, 'check_voucher'])->name('vouchers.check');

//service
Route::resource('/tours/services', ServiceController::class);


///Thanh toan
Route::post('/thanh-toan-vnpay', [MethodPaymentController::class, 'vnpay'])->name('methods.vnpay');
Route::post('/thanh-toan-zalopay', [MethodPaymentController::class, 'zalopay'])->name('methods.zalopay');
Route::post('/thanh-toan-momo', [MethodPaymentController::class, 'momo'])->name('methods.momo');
Route::post('/thanh-toan-viettel', [MethodPaymentController::class, 'viettel'])->name('methods.viettel');
Route::get('/thanh-toan-thanh-cong', [IndexController::class, 'payment_success'])->name('payment-success');
Route::get('/thanh-toan-momo', [IndexController::class, 'payment_success_momo'])->name('payment-success-momo');
Route::get('/thanh-toan-khong-thanh-cong', [IndexController::class, 'payment_error'])->name('payment-error');
Route::get('/checkout-return', [MethodPaymentController::class, 'vnpayReturn'])->name('methods.vnpay_return');

// Dashboard
Route::get('/dashboard/statistic', [DashboardController::class, 'show_dashboard'])->name('dashboard.show_dashboard');
Route::post('/dashboard/statistic-filter', [DashboardController::class, 'filterStatistics'])->name('dashboard.filter_dashboard');
Route::post('/dashboard/statistic-filter-line', [DashboardController::class, 'filter_line_dashboard'])->name('dashboard.filter_line_dashboard');
Route::post('/dashboard/statistic-filter-pie', [DashboardController::class, 'filter_pie_dashboard'])->name('dashboard.filter_pie_dashboard');

//Blog
Route::resource('/blogs', BlogController::class);
Route::post('/admin/blogs/upload-image', [BlogController::class, 'uploadImage']);
Route::get('tin-tuc-du-lich', [BlogController::class, 'tintuc'])->name('tintuc');
Route::get('cam-nang-du-lich', [BlogController::class, 'camnang'])->name('camnang');
Route::get('kinh-nghiem-du-lich', [BlogController::class, 'kinhnghiem'])->name('kinhnghiem');
Route::get('chi-tiet-blog/{id}', [BlogController::class, 'detail_blog'])->name('chitiet');

//Discount
Route::resource('/discounts', DiscountController::class);
Route::get('/tour-giam-gia/{slug}', [DiscountController::class, 'tour_sale'])->name('discounts.tour_sale');

//Staff
Route::resource('/staffs', StaffController::class);
Route::get('/staffs/manage/{id}', [StaffController::class, 'manage_task'])->name('staffs.manage_task');
Route::post('/staffs/store', [StaffController::class, 'store'])->name('staffs.store');
Route::post('/staffs', [StaffController::class, 'add_task'])->name('staffs.add_task');
Route::delete('/staffs/destroy-task/{id}', [StaffController::class, 'destroy_task'])->name('staffs.destroy_task');