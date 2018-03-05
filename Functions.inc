<?php

 function displayDropDown($tblName, $label ,$idName ,$descName , $whereClause)
  {
        $query = "  Select      *
                    From        $tblName
                                $whereClause   " ;

      if (mysqli_connect_errno())
          {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
      else
          {
             $result = mysql_query($query)  or die ("Couldn’t execute query");
             $rows = mysql_num_rows($result);
             echo '<select name="' . $tblName .'" onchange = "reload(this.form)">';
             echo '<option value="">' . $label . '</option>';
             echo '<option value="">----------</option>';

             while ($row = mysql_fetch_array($result))
                 {
                    $id =  $row[$idName]  ;
                    $desc = $row[$descName]  ;
                    echo '<option value="' . $id . '">' . $desc . '</option>';
                 }
             echo '</select>';
          }
  }


?>