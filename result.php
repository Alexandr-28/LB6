<?php
    require_once __DIR__ . "/vendor/autoload.php";
    $con=new MongoClient();
    $collection= $con-> test-> lit;
    $list = $collection->find();
    $year1=$_POST['yr'];
    $year2=$_POST['yr2'];
    $auth=$_POST['auth'];
    $publ=$_POST['publ'];
    $arr1=array();
    $arr2=array();
    $arr3=array();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 24px;
        }
        th,td{
            border: 1px solid black;
        }
        th{
            background:#007dff;
            color:white;
        }
    </style>
</head>
<body>
    <?php
        $filter1=array("publisher"=>$publ);
        $res1=$collection->find($filter1);
        $filter2=array("author"=>$auth);
        $res2=$collection->find($filter2);

        $js="function(){ return this.year>=".$year1." && this.year<=".$year2."}";
        $filter3=array('$where'=>$js);
        $res3=$collection->find($filter3);

        // print_r($res1);
    ?>
    <p>
        <span>Поиск по издатльству <?php echo $publ;?>:</span>
        <table>
            <tr>
                <th>Name</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>Pages</th>
                <th>Type</th>
                <th>Author</th>
                <th>Publisher</th>
            </tr>
            <?php
                while($document=$res1->getNext()){
                    echo "<tr>";
                    echo "<td>".$document["name"]."</td>";
                    echo "<td>".$document["year"]."</td>";
                    echo "<td>".$document["ISBN"]."</td>";
                    echo "<td>".$document["pages"]."</td>";
                    echo "<td>".$document["type"]."</td>";
                    array_push($arr1,$document["name"]);
                    array_push($arr1,$document["year"]);
                    array_push($arr1,$document["ISBN"]);
                    array_push($arr1,$document["pages"]);
                    array_push($arr1,$document["type"]);
                    if(isset($document["author"])){
                        if(is_array($document["author"])){
                            $tmp="";
                            for($i=0;$i<count($document["author"]);$i++){
                                $tmp=$tmp.$document["author"][$i].", ";
                            }
                            $tmp=substr($tmp,0,-2);
                            echo "<td>".$tmp."</td>";
                            array_push($arr1,$tmp);
                        }
                        else{
                            echo "<td>".$document["author"]."</td>";
                            array_push($arr1,$document["author"]);
                        }
                    }
                    else{
                        echo "<td>unknown</td>";
                        array_push($arr1,"unknown");
                    }
                    echo "<td>".$document["publisher"]."</td>";
                    array_push($arr1,$document["publisher"]);
                    echo "</tr>";
                }
            ?>
        </table>
    </p>
    <p>
        <span>Поиск по автору <?php echo $auth;?>:</span>
        <table>
            <tr>
                <th>Name</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>Pages</th>
                <th>Type</th>
                <th>Author</th>
                <th>Publisher</th>
            </tr>
            <?php
                while($document=$res2->getNext()){
                    echo "<tr>";
                    echo "<td>".$document["name"]."</td>";
                    echo "<td>".$document["year"]."</td>";
                    echo "<td>".$document["ISBN"]."</td>";
                    echo "<td>".$document["pages"]."</td>";
                    echo "<td>".$document["type"]."</td>";
                    array_push($arr2,$document["name"]);
                    array_push($arr2,$document["year"]);
                    array_push($arr2,$document["ISBN"]);
                    array_push($arr2,$document["pages"]);
                    array_push($arr2,$document["type"]);
                    if(isset($document["author"])){
                        if(is_array($document["author"])){
                            $tmp="";
                            for($i=0;$i<count($document["author"]);$i++){
                                $tmp=$tmp.$document["author"][$i].", ";
                            }
                            $tmp=substr($tmp,0,-2);
                            echo "<td>".$tmp."</td>";
                            array_push($arr2,$tmp);
                        }
                        else{
                            echo "<td>".$document["author"]."</td>";
                            array_push($arr2,$document["author"]);
                        }
                    }
                    else{
                        echo "<td>unknown</td>";
                        array_push($arr2,"unknown");
                    }
                    echo "<td>".$document["publisher"]."</td>";
                    array_push($arr2,$document["publisher"]);
                    echo "</tr>";
                }
            ?>
        </table>
    </p>
    <p>
        <span>Поиск по периоду <?php echo $year1."-".$year2;?>:</span>
        <table>
            <tr>
                <th>Name</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>Pages</th>
                <th>Type</th>
                <th>Author</th>
                <th>Publisher</th>
            </tr>
            <?php
                while($document=$res3->getNext()){
                    echo "<tr>";
                    echo "<td>".$document["name"]."</td>";
                    echo "<td>".$document["year"]."</td>";
                    echo "<td>".$document["ISBN"]."</td>";
                    echo "<td>".$document["pages"]."</td>";
                    echo "<td>".$document["type"]."</td>";
                    array_push($arr3,$document["name"]);
                    array_push($arr3,$document["year"]);
                    array_push($arr3,$document["ISBN"]);
                    array_push($arr3,$document["pages"]);
                    array_push($arr3,$document["type"]);
                    if(isset($document["author"])){
                        if(is_array($document["author"])){
                            $tmp="";
                            for($i=0;$i<count($document["author"]);$i++){
                                $tmp=$tmp.$document["author"][$i].", ";
                            }
                            $tmp=substr($tmp,0,-2);
                            echo "<td>".$tmp."</td>";
                            array_push($arr3,$tmp);
                        }
                        else{
                            echo "<td>".$document["author"]."</td>";
                            array_push($arr3,$document["author"]);
                        }
                    }
                    else{
                        echo "<td>unknown</td>";
                        array_push($arr3,"unknown");
                    }
                    echo "<td>".$document["publisher"]."</td>";
                    array_push($arr3,$document["publisher"]);
                    echo "</tr>";
                }
            ?>
        </table>
    </p>

    <?php
         $json = json_encode($arr1);
         $json2=json_encode($arr2);
         $json3=json_encode($arr3);
    ?>
    <script>
       var arr = JSON.parse('<?php echo $json; ?>');
       var arr2=JSON.parse('<?php echo $json2; ?>');
       var arr3=JSON.parse('<?php echo $json3; ?>');
       

       localStorage.setItem('<?php echo $publ;?>',JSON.stringify(arr));
       localStorage.setItem('<?php echo $auth;?>',JSON.stringify(arr2));
       localStorage.setItem('<?php echo $year1."-".$year2;?>',JSON.stringify(arr3));


    //    for(var i=0;i<localStorage.length;i++){
    //        let key=localStorage.key(i);
    //        if(localStorage.getItem('1980-2018')){
    //            var temparr=new Array();
    //            temparr=localStorage.getItem('1980-2018');
    //            console.log(temparr.length/7);
    //        }
    //        document.write(`${key} : ${localStorage.getItem(key)}<br>`);
    //    }
    </script>
</body>
</html>