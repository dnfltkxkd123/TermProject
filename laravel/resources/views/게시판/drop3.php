<!DOCTYPE html>
<html lang="en">
<head>
<meta charset=utf-8>
<meta name="viewport" content="width=620">
<title>HTML5 Demo: Drag and drop, automatic upload</title>
<body>
 
<style>
#holder { border: 10px dashed #ccc; width: 300px; min-height: 300px; margin: 20px auto;}
#holder.hover { border: 10px dashed #0c0; }
#holder img { display: block; margin: 10px auto; }
 
 
#container { width: 300px; margin: 0px auto;}
progress { width: 300px; margin: 0px auto; }
</style>
<div id="holder">
</div> 
   
<div id="container">
    <progress id="uploadprogress" min="0" max="100" value="0"/>
</div> 
 
 
<script>
    var holder = document.getElementById('holder');
    var progress = document.getElementById('uploadprogress');
         
    holder.ondragover = function () { this.className = 'hover'; return false; };
    holder.ondragend = function () { this.className = ''; return false; };
    holder.ondrop = function (e) {
        this.className = '';
        e.preventDefault();
        readfiles(e.dataTransfer.files);
    }
 
     
    function readfiles(files) {
        // 파일 미리보기
        previewfile(files[0]);
         
        var formData = new FormData();
        formData.append('upload', files[0]);
     
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './drop4.php');
        xhr.onload = function() {
            progress.value = 100;
        };
 
        xhr.upload.onprogress = function (event) {
            if (event.lengthComputable) {
                var complete = (event.loaded / event.total * 100 | 0);
                progress.value = progress.innerHTML = complete;
            }
        }
 
        xhr.send(formData);
    }
     
    function previewfile(file) {
        var reader = new FileReader();
        reader.onload = function (event) {
            var image = new Image();
            image.src = event.target.result;
            image.width = 250; // a fake resize
            holder.appendChild(image);
        };
 
        reader.readAsDataURL(file);
    }
</script>
</body>
</html>