<?php

$phpFileUploadErrors = array(
    0 => 'Публикация успешная: ',
    1 => 'Привышен максимальный объём файла - 3 мегабайта.',
    2 => '!',
    3 => 'Вы пытались опубликовать файл, но он оказался близднецом!',
    4 => 'Вы пытались привезти пустоту? Спасибо, не надо.',
    6 => 'Время так быстро летит, что даже пропала временая папка...',
    7 => 'Ой-ой! Произошла ошибка при записи на жёсткий диск.',
    8 => '!!!!!!!!!!!',
);
if(isset($_FILES['userfile'])){
    $file_array = reArrayFiles($_FILES['userfile']);
    pre_r($file_array);
    for ($i=0;$i<count($file_array);$i++) {
        if($file_array[$i]['error']) {
                ?> 
                <div class="container padding">
                    <div class="row padding">
                        <div class="col-md-12">
                            <br><br><br><br><br><div class="alert alert-danger"> 
                                <?php echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']]; ?> 
                            </div>
                        </div>
                    </div>
                </div>   
                <?php      
            }
        else {
            $extensions = array('jpg','png','gif','jpeg','ico','svg');
            $flle_ext = explode('.',$file_array[$i]['name']);
            $file_ext = end($file_ext);
            
            if(!in_array($file_ext, $extensions)) {
                ?> 
                <div class="container padding">
                    <div class="row padding">
                        <div class="col-md-12">
                            <br><br><br><br><br><div class="alert alert-danger"> 
                                <?php echo "{$file_array[$i]['name']} - расширение файла неверное!"; 
                                ?> </div>
                            </div>
                        </div>
                    </div>
                </div> <?php  
            }
            else {
                if ($file_array[$i]['size']>3000000) { ?>
                    <div class="container padding">
                    <div class="row padding">
                        <div class="col-md-12">
                            <br><br><br><br><br><div class="alert alert-danger"> 
                                <?php echo "{$file_array[$i]['name']} -  файл больще 3 мегабайт!"; 
                                ?> </div>
                            </div>
                        </div>
                    </div>
                </div> <?php
                }
                else {
                    function generateRandomString($length = 7) {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < $length; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                        return $randomString;
                    }
                    $rename = generateRandomString();
                    $file_array = $rename . '.' . $file_ext;
                    move_uploaded_file($file_array[$i]['tmp_name'], "/i/".$file_array[$i]['name']);
                    ?>
                    <div class="container padding">
                    <div class="row padding">
                        <div class="col-md-12">
                            <br><br><br><br><br><div class="alert alert-danger"> 
                                <?php echo "$file_array[$i]['name'].' - '.$phpFileUploadErrors $file_array[$i]['error']]"; 
                                ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                
            }
        }
    }
}

function reArrayFiles($file_post) {
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function pre_r($array) {
    echo '<pre>';
    print_r($array);
    echo '<pre>';
}