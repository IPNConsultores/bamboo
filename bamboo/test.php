<?php
/*
$indicesServer = array('PHP_SELF',
'argv',
'argc',
'GATEWAY_INTERFACE',
'SERVER_ADDR',
'SERVER_NAME',
'SERVER_SOFTWARE',
'SERVER_PROTOCOL',
'REQUEST_METHOD',
'REQUEST_TIME',
'REQUEST_TIME_FLOAT',
'QUERY_STRING',
'DOCUMENT_ROOT',
'HTTP_ACCEPT',
'HTTP_ACCEPT_CHARSET',
'HTTP_ACCEPT_ENCODING',
'HTTP_ACCEPT_LANGUAGE',
'HTTP_CONNECTION',
'HTTP_HOST',
'HTTP_REFERER',
'HTTP_USER_AGENT',
'HTTPS',
'REMOTE_ADDR',
'REMOTE_HOST',
'REMOTE_PORT',
'REMOTE_USER',
'REDIRECT_REMOTE_USER',
'SCRIPT_FILENAME',
'SERVER_ADMIN',
'SERVER_PORT',
'SERVER_SIGNATURE',
'PATH_TRANSLATED',
'SCRIPT_NAME',
'REQUEST_URI',
'PHP_AUTH_DIGEST',
'PHP_AUTH_USER',
'PHP_AUTH_PW',
'AUTH_TYPE',
'PATH_INFO',
'ORIG_PATH_INFO') ;

echo '<table cellpadding="10">' ;
foreach ($indicesServer as $arg) {
    if (isset($_SERVER[$arg])) {
        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
    }
    else {
        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
    }
}
echo '</table>' ;
*/

//header('Content-type: text/plain');

require_once "/home/gestio10/backup_mysql/config.php";
$BBDDs = array('gestio10_asesori1_reccius_db','gestio10_asesori1_bamboo','gestio10_asesori1_mercado_publico');
$backup_path= '/home/gestio10/backup_mysql/';

$days = 7;



foreach($BBDDs as $dbname){
    if (!file_exists('/home/gestio10/backup_mysql/'.$dbname)) {
    mkdir('/home/gestio10/backup_mysql/'.$dbname, 0755, true);}
    
    
        $directorio  = scandir('/home/gestio10/backup_mysql/'.$dbname.'/');
       foreach ($directorio as $archivo) {
        if (!is_dir($archivo))//verificamos si es o no un directorio
        {
             if (filemtime('/home/gestio10/backup_mysql/'.$dbname.'/'.$archivo) < ( time() - ( $days * 24 * 60 * 60 ) ) )  
            {  
                //unlink('/home/gestio10/backup_mysql/'.$dbname.'/'.$archivo);  
            } 
        }
   }
    
$backup_file = $dbname. "_" .date("Ymd_His", strtotime('-3 hours')).".sql";
$backup_rutacompleta = $backup_path.$dbname."/".$backup_file;
$connection=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if ($connection){
        
        echo "conectado;<br>";
        $tables = array();
        $result = mysqli_query($connection,"SHOW TABLES");
        while($row = mysqli_fetch_row($result)){
            $tables[] = $row[0];
        }
        
        $return = '';
        foreach($tables as $table){
              $result = mysqli_query($connection,"SELECT * FROM ".$table);
              $num_fields = mysqli_num_fields($result);
              
              $return .= 'DROP TABLE '.$table.';';
              $row2 = mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
              $return .= "\n\n".$row2[1].";\n\n";
              echo "<br> Tabla:".$table.": columnas(".$num_fields.")";
          for($i=0;$i<$num_fields;$i++){
            while($row = mysqli_fetch_row($result)){
              $return .= "INSERT INTO ".$table." VALUES(";
              for($j=0;$j<$num_fields;$j++){
                $row[$j] = addslashes($row[$j]);
                if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
                else{ $return .= '""';}
                if($j<$num_fields-1){ $return .= ',';}
              }
              $return .= ");\n";
            }
          }
          $return .= "\n\n\n";
        }
        
        //save file
        
        echo "<br><br> Respaldo creado en la siguiente ruta: ".$backup_rutacompleta."<br>";
        $handle = fopen($backup_rutacompleta,"w+");
        fwrite($handle,$return);
        fclose($handle);
        echo "<br><br> Respaldo exitoso";
        }
    else{
        
        echo "no conectado;<br>";
                
            $Tokens = array("o.sYQGqK57I6MgCTi8fUDhCGEQdB405nYN", "o.YVXz7PeAD357yTJwHFCiBmk3noXGhf03", "o.DPCT6WDlyv3hBYhKagkBeagCQlTc6z8l", "o.0Jl4p0hnJGrcXmW0KYlFyRBoqDeB4s05");
            foreach ($Tokens as &$authToken) {
                    $curl = curl_init('https://api.pushbullet.com/v2/pushes');
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Bearer $authToken"]);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, [
                    	"type" => "note", 
                    	"title" => "Backup fallido", 
                    	"body" => date("Y/m/d H:i:s", strtotime('-3 hours'))." [".$dbname."] -> Durante backup no se logra conectar con servidor"]
                    	);
                    
                    $response = curl_exec($curl);
            }
        }
}
?>