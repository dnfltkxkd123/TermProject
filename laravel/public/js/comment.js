    var update_check = new Array();
    var sub_update_check = new Array();
    var reply_check = new Array();
    var reply = new Array();
    //var reply_boxs = new Array();
    var count=0;
    var subCount=0;

    function changeForm(id,check,i){
      //alert(check[i]);
      obj = $('#'+id);
      if(check[i]){
        obj.css('display','none');
        check[i] = false;
      }else{
        obj.css('display','block');
        check[i] = true;
      }
    }

    function changeForm2(id,check,i,id2,check2){
      //alert(check[i]);
      obj = $('#'+id);
      if(check[i]){
        obj.css('display','none');
        check[i] = false;
      }else{
        obj.css('display','block');
        check[i] = true;
      }

      obj2 = $('#'+id);
      obj2.css('display','none');
      check2[i] = false;
    }
     

    function check3(){
      var yn = confirm('정말 삭제하겠습니까?');
      
      if(yn){
        location.href='<?=$del?>?num=<?=$num?>&thema=<?=$thema?>';
      }
    }

    function replyComment(replyClass){
      var reply = $(replyClass);
      //alert( reply[3].style.display );
      var start = 0;
      var view =2;
      for(var i=0 ; i<reply.length ; i++){
        if(reply[i].style.display == 'block'){
          start +=1;
        }
      }
      if(start >= reply.length)
        return;
      var final =0;
      if(start+view >= reply.length){
        final = reply.length;
      }else{
        final = start+view;
      }
      for(var i=start-1 ; i<final ; i++){
        reply[i].style.display = 'block';
      }
      

    }

    function plusReply(count){
     
      
      var formData = new FormData($('#replyInsert'+count)[0]);
      var URL = 'replyCommentAjax?subCount='+subCount;
      URL += '&table=' +formData.get('table');
      URL += '&count=' +formData.get('count');
      URL += '&text=' +formData.get('text');
      URL += '&nickname=' +formData.get('nickname');
      //alert(formData.get('text'));
      $.ajax({
        url : URL,
        type : 'get',
        data : {
        _token: ""/*,
        table: formData.get('table'),
        count:formData.get('count'),
        nickname:formData.get('nickname'),
        text:formData.get('text')*/
        },
        processData : false,
        contentType : false,
        success:function(data){
          $('#subUl'+count).append(data);
          //alert(data);
          //alert(data);
        },
        error:function(request,status,error){
        alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
       }
      });
    }

    function replyUpdate(sub){
      var URL = 'replyUpdateAjax';
      var formData = new FormData($('#replyUpdate'+sub)[0]);
      URL += '?table=' +formData.get('table');
      URL += '&num=' +formData.get('num');
      URL += '&count=' +formData.get('count');
      URL += '&text=' +formData.get('text');
      URL += '&nickname=' +formData.get('nickname');
      URL += '&subCount=' +formData.get('subCount');
      //alert(formData.get('nickname'));
       $.ajax({
        url : URL,
        type : 'get',
        data : {
        _token: ""/*,
        table: formData.get('table'),
        count:formData.get('count'),
        nickname:formData.get('nickname'),
        text:formData.get('text')*/
        },
        processData : false,
        contentType : false,
        success:function(data){
          $('.sub'+sub).html(data);
          //alert(data);
          //alert(data);
        },
        error:function(request,status,error){
        alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
       }
      });
    }

    function replyDelete(sub){
      var URL = 'replyDeleteAjax';
      var formData = new FormData($('#replyUpdate'+sub)[0]);
       URL += '?table=' +formData.get('table');
      URL += '&num=' +formData.get('num');
      $.ajax({
        url:URL,
        type : 'get',
        data : {
        _token: ""/*,
        table: formData.get('table'),
        count:formData.get('count'),
        nickname:formData.get('nickname'),
        text:formData.get('text')*/
        
        },
        processData : false,
        contentType : false,
        success:function(data){
         // alert(data);
          $('.sub'+sub).remove();
        },
        error:function(request,status,error){
        alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
       }
      });

    }