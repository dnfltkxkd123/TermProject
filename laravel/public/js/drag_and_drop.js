$(function(){
	fileDropDown();
});

function fileDropDown(){
	var dropZone = $('#dropZone');

	dropZone.css('border','solid 1px #c5c5c5');
	dropZone.css('padding','5px');

	dropZone.on('dragover',function(e){
		e.stopPropagation();
		e.preventDefault();

		dropZone.css('background-color','#E3F2FC');
	});

	dropZone.on('dragenter',function(e){
		e.stopPropagation();
		e.preventDefault();

		dropZone.css('background-color','#E3F2FC');
	});

	dropZone.on('dragleave',function(e){
		e.stopPropagation();
		e.preventDefault();

		dropZone.css('background-color','#FFFFFF');
	});

	dropZone.on('drop',function(e){
		e.preventDefault();
		var files = e.originalEvent.dataTransfer.files;
		dropZone.css('background-color','#FFFFFF');
		if(files.length > 1){
			alert('1개만 업로드 가능 합니다.');
			return;
		}else if(files.length < 1){
			alert('파일이 없습니다.');
			return;
		}
		;
		if(fileUpload(files)){
			$('#file').prop('files',files).submit();
			loadFile(e);
		}
	});
}

function fileUpload(files){
	if(files != null){
		var file = files[0];
		var fileName = files[0].name;
        var fileNameArr = fileName.split("\.");
        // 확장자
        var ext = fileNameArr[fileNameArr.length - 1];
        if(ext=='jpg' || ext=='png' || ext=='gif' || ext=='bmp' || ext=='rle' || ext=='dib'){
        	return true;
        }else{
        	alert('이미지 파일만 가능 합니다!!');
        	return false;
        }
	}
}



function loadFile(event) {
	/*
	var file = event.target.files[0];
	if(file != null){
		var file = file;
		var fileName = file.name;
        var fileNameArr = fileName.split("\.");
        // 확장자
        var ext = fileNameArr[fileNameArr.length - 1];
        if(ext=='jpg' || ext=='png' || ext=='gif' || ext=='bmp' || ext=='rle' || ext=='dib'){
        	var img = $('#book');
    		var src = URL.createObjectURL(file);
    		img.attr('src' , src);
    		return true;
        }else{
        	alert('이미지 파일만 가능 합니다!!');
        	return false;
        }
	}*/
	var files = event.target.files;

	//fileUpload(files);
    var img = $('#book');
    var src = URL.createObjectURL(files[0]);
    img.attr('src' , src);
   
  };