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
                <li class="selected"><a href="FrmDisplayAllOrders.php"> Orders </a></li>
                <li><a href="#"> Update Order Status </a></li>
                <li><a href="FrmAddCategory.php"> Add Category </a></li>
                <li><a href="FrmAddItem.php"> Add Item </a></li>
                <li ><a href="FrmDisplayAllCategoriesItems.php"> Store Items </a></li>
                <li><a href="FrmItemsWithDraw.php"> Withdraw Items </a></li>
                <li><a href="FrmItemsFininsh.php">Re-Order Point</a></li>
            </ul>
         </div>
    </head>

<body  style=" color: #B6F1EC ; background: url(bckground.jpg)">
<div id = 'blockdiv' >

<?php
       require 'Connection.php';  // Database connection
       mysql_connect($host,$UserName,$Pwd )  ;
       mysql_select_db($database) or die(mysql_error())  ;

       $query = "       Select      C.OrderID , C.OrderDate , A.CatName , B.ItemName ,
                                    D.StatusName , C.Quantity
                        From        Categories A ,  Items B , orders C  , OrderStatus D
                        Where       A.CatID = B.CatID
                        And         B.CatID = C.CatID
                        And         B.ItemId = C.ItemId
                        and         C.StatusID =  D.StatusID
                        Order By    1,2    " ;

                  if (mysqli_connect_errno())
                        {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        }

                   else
                        {
                            echo "<br><h2 align= 'center' > All Purchase Order Information   </h2>    <br>"  ;

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
                                   <td width=200><font face='Arial' size='3' color='#180420'> Order ID  </td>
                                   <td width=300><font face='Arial' size='3' color='#180420'> Order Date  </td>
                                   <td width=400><font face='Arial' size='3' color='#180420'> Category Name </td>
                                   <td width=900><font face='Arial' size='3' color='#180420'> Item Name </td>
                                   <td width=300><font face='Arial' size='3' color='#180420'> Quantity </td>
                                   <td width=300><font face='Arial' size='3' color='#180420'> Order Status </td>
                                   </tr></table>";

                            while ($row = mysql_fetch_array($result))
                                 {
                                    $OrderID = $row["OrderID"] ;
                                    $OrderDate = $row["OrderDate"] ;
                                    $CatName = $row["CatName"] ;
                                    $ItemName = $row["ItemName"] ;
                                    $StatusName = $row["StatusName"] ;
                                    $Quantity = $row["Quantity"] ;

                                        echo "<table style='WORD-BREAK:BREAK-ALL' width='90%'
                                             bgcolor='#5CC3FF' align='center' border='1' cellpadding='5'>";

                                       echo "<tr>
                                              <td width=200 >
                                              <font face='Arial' size='3' color='#180420'>    $OrderID   </td>
                                              <td width=300 >
                                              <font face='Arial' size='3' color='#180420'>   $OrderDate   </td>
                                              <td width=400 >
                                              <font face='Arial' size='3' color='#180420'>    $CatName   </td>
                                              <td width=900 >
                                              <font face='Arial' size='3' color='#180420'>   $ItemName   </td>
                                              <td width=300 >
                                              <font face='Arial' size='3' color='#180420'>    $StatusName   </td>
                                              <td width=300 >
                                              <font face='Arial' size='3' color='#180420'>   $Quantity   </td>

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