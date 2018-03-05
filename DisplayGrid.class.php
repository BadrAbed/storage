<?php
 class DisplayGrid
 {
        private  $WhereClause ;

function      DisplayItems($WhereClause)
 {


   $Query=" SELECT       CatID , ItemID , ItemName , ItemPrice , Notes
            FROM         Items
            $WhereClause
            Order By    CatID , ItemID";

     $result = mysql_query($Query)  or die ("Couldn’t execute query");
     $rows = mysql_num_rows($result);
     if ($rows < 1)
         {
           echo "<hr>  <b>  No results Found </b>  <hr>\n";
         }
    else
        {
           echo " <table style='WORD-BREAK:BREAK-ALL' width='88%'
                    bgcolor='silver' align='center' border='1' cellpadding='5'>";
           echo " <tr  bgcolor='silver' align='center' height=35>
                      <td width=250  >   Category ID  :       </td>
                      <td width=250 >    Item ID  :     </td>
                      <td width=800 >    Item Name  :     </td>
                      <td width=250 >    Item Price   :     </td>
                      <td width=800 >    Description  :     </td>
                 </tr></table>";

          while ($row = mysql_fetch_array($result))
               {
                  $CatID = $row["CatID"] ;
                  $ItemID = $row["ItemID"] ;
                  $ItemName = $row["ItemName"] ;
                  $Price = $row["ItemPrice"] ;
                  $Notes = $row["Notes"] ;

                 echo "<table style='WORD-BREAK:BREAK-ALL' width='88%'
                        bgcolor='silver' align='center' border='1' cellpadding='5'>";
                 echo "<tr>
                          <td width=250 >    $CatID   </td>
                          <td width=250 >   $ItemID   </td>
                          <td width=800 >   $ItemName   </td>
                          <td width=250 >   $Price   </td>
                          <td width=800 >   $Notes   </td>
                       </tr></table>" ;
              }
          }
  }


 }


?>