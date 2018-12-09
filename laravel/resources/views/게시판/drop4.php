<?php
if (isset($_FILES['upload']) && $_FILES['upload']['error'] == 0) {
    if (move_uploaded_file($_FILES['upload']['tmp_name'], 
        "업로드 서버경로/{$_FILES['upload']['name']}")) {
        echo "upload 성공!!";
        var_dump($_FILES);
    }else{
        echo "upload fail##1";
        var_dump($_FILES);
    }
}else{
    echo "upload fail##2";
    var_dump($_FILES);
}
?>