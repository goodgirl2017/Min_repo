<?php   
     
     if($dumpResults){  
        ob_start();     //打开输出缓冲区
        var_dump($result);
        $debug = ob_get_clean();    //得到当前缓冲区的内容并删除当前缓冲区
        array_push($query_msg, $debug . NEWLINE);       //向数组尾部插入新元素
      }
    
    if($showQueries){
        if(is_bool($result)) {
            array_push($query_msg,  $query . ';' . NEWLINE);
            
            if( mysqli_errno($db) > 0 ) {       //返回上一个SQL query中的错误代码
                array_push($error_msg,  'Error# '. mysqli_errno($db) . ": " . mysqli_error($db));
            }
        } else {
            
                 if($showCounts){
                    array_push($query_msg,  $query . ';');
                    array_push($query_msg,  "Result Set Count: ". mysqli_num_rows($result). NEWLINE);
                 } else {
                     array_push($query_msg,  $query . ';'. NEWLINE);
                 }
            } 
        }
?>