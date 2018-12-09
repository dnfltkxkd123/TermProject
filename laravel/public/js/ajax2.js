function check(id,URL){
      $.ajax({
        url:URL,
        type:'post',
        //dataType:'php',
        data:$('form').serialize(),
        success:function(data){
            alert(data);
          //$(id).html(data);
        }
      });
      
}

function fileCheck(id,URL){
    /*
  var formData = new FormData($("#form")[0]);
  //alert('test');
  
  URL +='?name='+formData.get('name');
  URL +='&id='+formData.get('id');
  URL +='&nickname='+formData.get('nickname');
  URL +='&email='+formData.get('email');
  URL +='&pw='+formData.get('pw');
  URL +='&pw_confirm='+formData.get('pw_confirm');
  
  
  
        $.ajax({
            type : 'get',
            url : URL,
            data : {formData},
            processData : false,
            contentType : false,
            success : function(data) {
                //alert(data);
                $(id).html(data);
                //$('#submit').attr('onclick','false');
            },
            error:function(request,status,error){
                alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
    });
        //return false;    
        */
    var form = $('#form'); 
    //var url = form.attr("action"); 
    var data = new FormData(form[0]); 
    //alert(data.get('thema'));
    $.ajax({ 
     url: URL, 
     type: 'post', 
     data: data,
     cache: false, 
     processData: false, 
     contentType : false, 
     success: function (data) { 
      console.log('success',data.test); 
      $(id).html(data);
     }, 
     error: function (jqXHR, textStatus, errorThrown) { 
      console.log(jqXHR,textStatus.errorThrown); 
      alert('error');
     } 
    }); 
}

function check(){
    
}