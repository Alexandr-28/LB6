 <?php
    require_once __DIR__ . "/vendor/autoload.php";
    $con=new MongoClient();
    $collection= $con-> test-> lit;
    $list = $collection->find();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Document</title>

    <style>
    #tbl,th,td{
        border: 1px solid black;
    }
    </style>
</head>
<body>
    <?php
        $authors=array();
        $publ=array();
        $years=array();

        while($document=$list->getNext()){
            array_push($publ, $document["publisher"]);
            array_push($years, $document["year"]);
            if(isset($document["author"])){
                if(is_array($document["author"])){
                    for($i=0;$i<count($document["author"]);$i++){
                        array_push($authors,$document["author"][$i]);
                    }
                }
                else{
                    array_push($authors,$document["author"]);
                }
            }
        }
        $authors=array_unique($authors);
        $publ=array_unique($publ);
        $years=array_unique($years);
        sort($years);
    ?>

    <form action="result.php" method="POST">
        <p>
            <label for="publ">Выберите название: </label>
            <select name="publ" id="publ">
                <?php
                    for($i=0;$i<count($publ);$i++){
                        if($publ[$i]==""){continue;}
                        echo "<option value='".$publ[$i]."'>".$publ[$i]."</option>";
                    }
                ?>
            </select>
        </p>
        <p>
            <label for="yr">Введите времменой период: </label>
            <span>С</span>
            <select name="yr" id="yr">
            <?php
                for($i=0;$i<count($years);$i++){
                    echo "<option value='".$years[$i]."'>".$years[$i]."</option>";
                }
            ?>
            </select>
            <span>&nbsp;По</span>
            <select name="yr2" id="yr2">
            <?php
                rsort($years);
                for($i=0;$i<count($years);$i++){
                    echo "<option value='".$years[$i]."'>".$years[$i]."</option>";
                }
            ?>
            </select>
        </p>
        <p>
            <label for="auth">Выберите автора: </label>
            <select name="auth" id="auth">
            <?php
                for($i=0;$i<count($authors);$i++){
                    if($authors[$i]==""){continue;}
                    echo "<option value='".$authors[$i]."'>".$authors[$i]."</option>";
                }
            ?>
            </select>
        </p>

        <p>
            <input type="submit" value="Показать результаты">
        </p>
    </form>


    <script>
            var resArr=new Array();
            for(var i=0;i<localStorage.length;i++){
                resArr[resArr.length]=localStorage.key(i);
            }
            console.log(resArr);
    </script>



    <br><br><br><br><br><br>

    <select name="hst" id="hst">
            
    </select>

       
       <script>
             $(function(){ 
               for(var i=0;i<resArr.length;i++){
                   var op = new Option(resArr[i], resArr[i]);
                   $(op).html(resArr[i]);
                   $("#hst").append(op);
               }
           });
        </script>

        
        <br>
        <button class="loc">Поиск</button>

        <table id="tbl">
            <tr>
                <th>Name</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>Pages</th>
                <th>Type</th>
                <th>Author</th>
                <th>Publisher</th>
            </tr>
        </table>


        <script>
            $(function(){
                $('.loc').click(function(){
                    var i=0;
                    $('#tbl').find("tr:gt(0)").remove();
                    var key=$('#hst').val();
                    //alert(key);

                    var str=localStorage.getItem(key);
                    
                    var tempArr=JSON.parse(str);

                    if(tempArr.length==7){
                        $('#tbl').append('<tr><td>'+tempArr[0]+'</td><td>'+tempArr[1]+'</td><td>'+tempArr[2]+'</td><td>'+tempArr[3]+'</td><td>'+tempArr[4]+'</td><td>'+tempArr[5]+'</td><td>'+tempArr[6]+"</td></tr>");
                    }
                    else{
                        while(true){
                            $('#tbl').append('<tr><td>'+tempArr[i++]+'</td><td>'+tempArr[i++]+'</td><td>'+tempArr[i++]+'</td><td>'+tempArr[i++]+'</td><td>'+tempArr[i++]+'</td><td>'+tempArr[i++]+'</td><td>'+tempArr[i++]+"</td></tr>");
                            if(tempArr.length%7==0 && i<tempArr.length){
                                continue;
                            }
                            else{
                                break;
                            }
                        }
                    }
                });
            });
        </script>
</body>
</html>