<?php
$n = 0;
echo '<?php' . PHP_EOL;
echo 'return array(' . PHP_EOL;
if(isset($models))
    foreach ($models as $model){
        echo '\''.get_class($model).'_'. ++$n . '\' => array(' . PHP_EOL ;
        foreach ($model->attributes as $attr => $value){
            echo "\t'" . str_replace("'", "\'", $attr) . "' =>";
            if(isset($value)){
                echo "'" . str_replace("'", "\'", $value) . "',\n";
            }else{
                echo "NULL,\n";
            }
        }
        echo '),'.PHP_EOL;
    }

echo ');';
