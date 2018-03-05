<!DOCTYPE html>

<html>

  <head>
        <link rel="stylesheet" href="mycss.css"/>  <meta charset="UTF-8">
        <div id="topdiv">
            <h2 style="font-style: bold; font-family: arial; font-size: 32px ; color: #6BD4DB">
            Storage Management System </h2>

            <ul class="menu">
                <li><a href="FrmMainMenu.php"> Main Menu </a></li>
                <li><a href="FrmNewOrder.php"> Purchase Order </a></li>
                <li><a href="FrmDisplayAllOrders.php"> Orders </a></li>
                <li><a href="#"> Update Order Status </a></li>
                <li><a href="FrmAddCategory.php"> Add Category </a></li>
                <li><a href="FrmAddItem.php"> Add Item </a></li>
                <li ><a href="FrmDisplayAllCategoriesItems.php"> Store Items </a></li>
                <li><a href="FrmItemsWithDraw.php"> Withdraw Items </a></li>
                <li class="selected"><a href="FrmItemsFininsh.php">Re-Order Point</a></li>
            </ul>
         </div>
    </head>
  <body  style=" color: #B6F1EC ; background: url(bckground.jpg)">
   <div id = 'blockdiv' >
   <?php
       require 'Connection.php';  // Database connection
       mysql_connect($host,$UserName,$Pwd )  ;
       mysql_select_db($database) or die(mysql_error())  ;

       $query = "       Select      A.CatName , B.ItemName , B.ItemPrice ,
                                            sum(C.Inflow) -  sum(C.OutFlow) as ItemBalance
                                From        Categories A ,  Items B , stocktransaction C
                                Where       A.CatID = B.CatID
                                And         B.CatID = C.CatID
                                And         B.ItemId = C.ItemId
                                Group By    A.CatName , B.ItemName , B.ItemPrice
                                Having      sum(C.Inflow) -  sum(C.OutFlow)<5
                                Order By    1,2    " ;

                  if (mysqli_connect_errno())
                        {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }

                   else
                        {
                            echo "<br><h2 align= 'center' > Store Items About To Finish - Need To Be Ordered  </h2>    <br>"  ;

                            $result = mysql_query($query)  or die ("Couldn’t execute query");
                            $rows = mysql_num_rows($result);

                            if ($rows < 1)
                                {
                                    echo "<hr><b>  No results Found </b><hr>\n";
                                }
                            else
                                {

                            echo " <table style='WORD-BREAK:BREAK-ALL' width='90%'
                                        align='center' border='1' cellpadding='5' > ";
                            echo " <tr bgcolor='#5CC3FF' align='center' height=55  color='#FF6600'>
                                   <td width=400><font face='Arial' size='3' color='#180420'> Category Name </td>
                                   <td width=1100><font face='Arial' size='3' color='#180420'> Item Name </td>
                                   <td width=500><font face='Arial' size='3' color='#180420'> Item Price </td>
                                   <td width=500><font face='Arial' size='3' color='#180420'> Item Balance </td>
                                   </tr></table>";

                            while ($row = mysql_fetch_array($result))
                                 {
                                    $CatName = $row["CatName"] ;
                                    $ItemName = $row["ItemName"] ;
                                    $ItemPrice = $row["ItemPrice"] ;
                                    $ItemBalance = $row["ItemBalance"] ;

                                        echo "<table style='WORD-BREAK:BREAK-ALL' width='90%'
                                             bgcolor='#5CC3FF' align='center' border='1' cellpadding='5'>";

                                       echo "<tr>
                                              <td width=400 >
                                              <font face='Arial' size='3' color='#180420'>    $CatName   </td>
                                              <td width=1100 >
                                              <font face='Arial' size='3' color='#180420'>   $ItemName   </td>
                                              <td width=500 >
                                              <font face='Arial' size='3' color='#180420'>    $ItemPrice </td>
                                              <td width=500 >
                                              <font face='Arial' size='3' color='#180420'>   $ItemBalance  </td>
                                             </tr></table>" ;
                                        }
                            }
                    }
                ?>

     <div id="bottomdiv"> <center>
        <div style="  font-style: bold; font-family: arial; font-size: 18px ; color: #180420">
            &#169; (2014-2015) Faculty of Computers - Helwan University
        </div></center>
     </div>

  </div>

</body>
</html>