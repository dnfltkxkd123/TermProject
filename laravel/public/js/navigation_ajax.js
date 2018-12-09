
function request(){
        var httpRequest;
        var res = document.getElementById('navi')
        if(window.XMLHttpRequest){
            httpRequest = new XMLHttpRequest();
        }else if(window.ActiveXObject){
            try{
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
            }catch(e){
                try{
                    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                }catch(e){
                    
                }
            }
        }
        if(!httpRequest){
            throw new Error("This brower can not support AJAX");
        }
        //응답을 위한 콜백함수 설정
        httpRequest.onreadystatechange = function(){
           //응답코드 작성 
            if(httpRequest.readyState == 4 && httpRequest.status ==200){
                //alert(httpRequest.responseText);
                //해당 태그를 찾고
                //해당 태그에 innerHTML을 받아온 데이터로 설정
                res.innerHTML = httpRequest.responseText;
            }
        }
        //open();
        httpRequest.open("GET","navigationbar.html");
        //send();
        httpRequest.send(null);//get방식은 전할 데이터가 필요없음
    }