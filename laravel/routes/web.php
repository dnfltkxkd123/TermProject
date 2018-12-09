<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use llluminate\Http\Response;

Route::group(array('domain'=>'chanmin.xyz'),function(){
	Route::get('/', function () {
    	return View('welcome');
    });
});

Route::get('/', function () {
    return View('welcome');
});

Route::get('t','OrmController@getAll');

Route::get('task/list2',function(){
	$task = [
		['name' => 'Response 클래스 분석','due_date' => '2015-06-01 11:22:33'],
		['name' => '블레이드 예제 작성', 'due_date' => '2015-06-03 15::21::13']	
	];
	return view('test.list3')->with('tasks',$task);
});

Route::get('test/task',function(){
	$task = ['name' => '최찬민','comment'=>'메롱~~'];
	return view('test.task') -> with('task',$task);
});

Route::get('clac/{num}',function($num){
	return view('clac2') -> with('num',$num);
});

Route::get('test/{name?}', function ($name='홍길동') {
    return View($name.' hello');
});

Route::get('json',function(){
	$data = ['name'=>'Iron Man' , 'gender' => 'Man'];
	return reponse()->json($data);
});

Route::get('hello',function(){

	return View::make('hello.html');
});


Route::get('게시판',function(){
	return View('게시판.board');
});

Route::get('view',function(){
	return View('게시판.write_form');
});

Route::get('등록',function(){
	return View('게시판.write');
});

Route::get('delete',function(){
	return view('bbs.delete');
});


Route::get('te',function(){
	$tasks = [
		['name' => '최찬민','due_data'=>'메롱~~'],
		['name' => '최찬민','due_data'=>'메롱~~']
	];
	return view('test.te') -> with('tasks',$tasks);
});




Route::get('bookCommunityMain',function(){
	return view('기말과제.main_page');
});


Route::get('recommendBoard',function(){
	return view('기말과제.recommend_board');
});
Route::get('recommendBook',function(){
	return view('기말과제.recommend_bookSample2');
});
Route::get('recommend_form',function(){
	return view('기말과제.recommend_form');
});


Route::post('recommend_insert','RecommendBoardController@insertData');
Route::post('recommend_update','RecommendBoardController@updateData');
Route::get('recommend_delete','RecommendBoardController@deleteData');
Route::get('searchRecommand','RecommendBoardController@pagenation');
Route::get('recommend_comment','RecommendCommentController@insertComment');

Route::get('openBoard',function(){
	return view('기말과제.openBoard');
});
Route::get('openBoard_page',function(){
	return view('기말과제.openBoard_page');
});
Route::get('openBoard_register_form',function(){
	return view('기말과제.openBoard_register_form');
});

/*
Route::get('openBaord_delete',function(){
	return view('기말과제.openBaord_delete');
});
*/
Route::get('search','OpenBoardController@pagenation');
Route::get('openBaord_delete','OpenBoardController@deleteData');
Route::get('openBoard_update','OpenBoardController@updateData');
Route::get('openBoard_register_form',function(){
	return view('기말과제.openBoard_register_form');
});
/*Route::get('openBoard_register',function(){
	return view('기말과제.openBoard_register');
});*/
Route::get('openBoard_register','OpenBoardController@insertData');





Route::get('replyCommentAjax',function(){
	return view('기말과제.replyCommentAjax');
});
Route::get('replyUpdateAjax',function(){
	return view('기말과제.replyUpdateAjax');
});
Route::get('replyDeleteAjax',function(){
	return view('기말과제.replyDeleteAjax');
});

Route::get('comment','OpenBoardCommentController@insertComment');
Route::get('comment_update','OpenBoardCommentController@updateComment');
Route::get('deleteComment','OpenBoardCommentController@deleteComment');

/*
Route::get('donateBook',function(){
	return view('기말과제.donate_book');
});

Route::get('donate_book_info',function(){
	return view('기말과제.donate_book_info');
});
*/
Route::get('orderSample',function(){
	return view('기말과제.orderSample');
});
Route::get('donate_delete','DonateController@deleteData');

Route::get('donateBook','DonateController@donatePagenation');
Route::get('donate_book_info','DonateController@donateInfo');
Route::post('donate_update','DonateController@updateData');
Route::post('donateInsert','DonateController@insertData');
Route::get('my_sale_book','DonateController@salePagenation');
/*
Route::get('login',function(){
	return view('기말과제.login');
});*/

Route::post('login2','MemberController@insert');

Route::get('logout',function(){
	return view('기말과제.logout');
});
Route::get('member_update_form',function(){
	return view('기말과제.member_update_form');
});
Route::get('login_form',function(){
	return view('기말과제.login_form');
});
Route::get('register_form',function(){
	return view('기말과제.register_form');
});
/*
Route::any('register',function(){
	return view('기말과제.register');
});
*/
Route::get('recommend_bookSample2',function(){
	return view('기말과제.recommend_bookSample2');
});

Route::post('register2','MemberController@register');

Route::post('memberUpdate','MemberController@memberUpdate');

Route::get('buyedBook','DeliveryDataController@buyedPagenation');
Route::get('soldBook','DeliveryDataController@soldOutPagenation');


Route::get('api','DeliveryDataController@goApi');


Route::get('order','DeliveryDataController@insertData');
Route::get('insertInvoiceForm','DeliveryDataController@getInsertInvoice');
Route::get('delivery_data','DeliveryDataController@getDeliveryData');
Route::get('apiTest','DeliveryDataController@getInvoice');
Route::post('insert_invoice_num','DeliveryDataController@insertInvoice');

Route::post('donate_insert','DonateController@insertData');
Route::get('donate_delete','DonateController@deleteData');
Route::get('donate_comment','DonateCommentController@insertComment');
/*
View?
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
