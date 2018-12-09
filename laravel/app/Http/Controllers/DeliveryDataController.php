<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryData;
use App\Donate;

class DeliveryDataController extends Controller
{
    //

    public function insertData(Request $request){
    	$name = $request -> input('name');
    	$post = $request -> input('post');
    	$addr = ($request -> input('addr1')).' '.($request -> input('addr2'));
    	$phone = ($request -> input('phone1')).'-'.($request -> input('phone2')).'-'.($request -> input('phone3'));
    	$tel = ($request -> input('tel1')).'-'.($request -> input('tel2')).'-'.($request -> input('tel3'));
    	$num = $request -> input('num');
        $buyer = $request -> input('buyer');
        $seller = $request -> input('seller');
        $title = $request -> input('title');
        $img = $request -> input('img');
        /*
        $data = [
            'name' => $name,
            'post' => $post,
            'addr' => $addr,
            'phone' => $phone,
            'tel' => $tel,
            'num' => $num,
            'buyer' => $buyer,
            'seller' => $seller
        ];
        */
        if($name &&($request -> input('addr1')) && ($request -> input('addr2')) && ($request -> input('phone1')) && ($request -> input('phone2')) && ($request -> input('phone3'))&& ($request -> input('tel1')) && ($request -> input('tel2')) && ($request -> input('tel3'))){
            $data=[
                'sale_status'=>'sold_out',
                'buyer' => $buyer
                ];
            Donate::where('num','=',$num)->update($data);
            DeliveryData::insertData($name,$post,$addr,$phone,$tel,$num,$buyer,$seller,$title,$img);
            ?>
                <script type="text/javascript">
                    location.href='donateBook';
                </script>
            <?php
        }else{
            ?>
                <script type="text/javascript">
                    alert('빈칸을 모두 입력하세요!');
                    history.back();
                </script>
            <?php
        }
    	
    }

    public function getProductNum(Request $request){
        $product_num = $request -> input('num');
        $datas =DeliveryData::getProductNum($product_num);
        return $datas;
    }

    public function getInsertInvoice(Request $request){
        $datas= $this->getProductNum($request);
        $product_datas = Donate::getData($request -> input('num'));
        return view('기말과제.insertInvoiceForm')->with('datas',$datas)->with('product_datas',$product_datas);
    }

    public function insertInvoice(Request $request){
        $product_num = $request -> input('product_num');
        $code = $request -> input('code');
        $invoice_number = $request -> input('invoice_number');
        
        DeliveryData::insertInvoiceNumber($product_num,$invoice_number,$code);
    }

    public function getDeliveryData(Request $request){
        $datas= $this->getProductNum($request);
        return view('기말과제.delivery_data')->with('datas',$datas);
    }

    public function getInvoice(Request $request){
        $product_num = $request -> input('num');
        $data =DeliveryData::getProductNum($product_num);
        $invoice_number = $data[0]->invoice_number;
        $code = $data[0]->code;
        return view('기말과제.TestApi') ->with('invoice_number',$invoice_number)->with('code',$code);
    }

    public function soldOutPagenation(Request $request){
        
        define('ONE_PAGE_LIST',10);
        define('PAGE_LINK',5);
        $seller = $request -> seller;
        $count = DeliveryData::checkCount($seller);
        $page = $request->page;
        if($count>=0){
            $pageCount = ceil($count/ONE_PAGE_LIST);
            
            if($page>$pageCount){
                $page = $pageCount;
            }
            if($page<1){
                $page = 1;
            }

            $start = ($page-1)*ONE_PAGE_LIST;
            $getOnePageList = DeliveryData::where('seller','=',$seller)->orderBy('order_num','desc')->skip($start)->take(ONE_PAGE_LIST)->get();
            //$getOnePageList2 = Donate::where('id','=',$seller)->orderBy('product_num','desc')->skip($start)->take(ONE_PAGE_LIST)->get();
            $firstLink = floor(($page-1)/PAGE_LINK)*PAGE_LINK+1;
            $lastLink = $firstLink+PAGE_LINK-1;
            if($lastLink>$pageCount){
                $lastLink = $pageCount;
            }
        }
        return view('기말과제.sold_out_book')->with('getOnePageList',$getOnePageList)
                                            ->with('page',$page)
                                            ->with('firstLink',$firstLink)
                                            ->with('lastLink',$lastLink)
                                            ->with('page',$page)
                                            ->with('pageCount',$pageCount);
    }

        public function buyedPagenation(Request $request){
        
        define('ONE_PAGE_LIST',10);
        define('PAGE_LINK',5);
        $buyer = $request -> buyer;
        $count = DeliveryData::checkCount2($buyer);
        $page = $request->page;
        if($count>=0){
            $pageCount = ceil($count/ONE_PAGE_LIST);
            
            if($page>$pageCount){
                $page = $pageCount;
            }
            if($page<1){
                $page = 1;
            }

            $start = ($page-1)*ONE_PAGE_LIST;
            $getOnePageList = DeliveryData::where('buyer','=',$buyer)->orderBy('order_num','desc')->skip($start)->take(ONE_PAGE_LIST)->get();
            //$getOnePageList2 = Donate::where('id','=',$seller)->orderBy('product_num','desc')->skip($start)->take(ONE_PAGE_LIST)->get();
            $firstLink = floor(($page-1)/PAGE_LINK)*PAGE_LINK+1;
            $lastLink = $firstLink+PAGE_LINK-1;
            if($lastLink>$pageCount){
                $lastLink = $pageCount;
            }
        }
        return view('기말과제.buyed_book')->with('getOnePageList',$getOnePageList)
                                            ->with('page',$page)
                                            ->with('firstLink',$firstLink)
                                            ->with('lastLink',$lastLink)
                                            ->with('page',$page)
                                            ->with('pageCount',$pageCount);
    }

    public function goApi(Request $request){
        $code = $request -> input('code');
        $invoice_number = $request -> input('invoice_number');
        return view('기말과제.TestApi')->with('code',$code)->with('invoice_number',$invoice_number);
    }
}
