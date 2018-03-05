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
                <li ><a href="FrmAddCategory.php"> Add Category </a></li>
                <li><a href="FrmAddItem.php"> Add Item </a></li>
                <li><a href="FrmDisplayAllCategoriesItems.php"> Store Items </a></li>
                <li class="selected"><a href="FrmItemsWithDraw.php"> Withdraw Items </a></li>
                <li><a href="FrmItemsFininsh.php">Re-Order Point</a></li>
            </ul>
         </div>



    </head>

           <script type="text/javascript">
                function reload(form)
                      {
                        var indx=form.Categories.options[form.Categories.options.selectedIndex].value;
                        self.location='FrmItemsWithDraw.php?Cat=' + indx ;
                      }
          </script>

<body  style=" color: #B6F1EC ; background: url(bckground.jpg) ; background-position:  inherit ">

<form   method="POST">



    </body>
</html>


 <div id="blockdiv" >
<?php

      @$cat=$_GET['Cat'];

      require 'Connection.php';  // Database connection
      mysql_connect($host,$UserName,$Pwd )  ;
      mysql_select_db($database) or die(mysql_error())  ;

      //Get data for Categories listbox
      $Query1="SELECT * FROM Categories order by CatName";

      //Get data for Items listbox
      if(isset($cat) and strlen($cat) > 0)
        {
            $Query2="SELECT *  FROM Items where CatID=$cat order by ItemName";
        }
      else
        {
            $Query2="SELECT *  FROM Items order by ItemName";
        }

      echo"<table border width=90%  align='center' bgcolor='#5CC3FF'    >";
      echo "<p> <h2 align='center'>  Withdraw Items From Stock to Custumers Destination    </h2>  </p>" ;

      echo "<tr> <td width=200 ><font face='Arial' size='3' color='#180420'> Select category :  </td>  ";
      echo "<td width=800>" ;

      //Fill Category List Box
      if (mysqli_connect_errno())
          {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
      else
          {
             $result = mysql_query($Query1)  or die ("Couldn’t execute query");
             $rows = mysql_num_rows($result);
             $tblName = "Categories" ;
             $label = "Choose Category"  ;

             echo '<select name="' . $tblName .'" onchange = "reload(this.form)" >';
             echo '<option value="">' . $label . '</option>';
             echo '<option value="">----------</option>';

             while ($row = mysql_fetch_array($result))
              {
                if( $row['CatID']==@$cat)
                   {
                      echo '<option  selected value="' .  $row['CatID'] . '">' . $row['CatName'] . '</option>';
                    }
                else
                    {
                       echo '<option value="' .  $row['CatID'] . '">' . $row['CatName'] . '</option>';
                    }
              }
             echo '</select>';
          }
     echo "</td> </tr>";

     // Get Items Drop Down List Box
       echo "<tr> <td width=200><font face='Arial' size='3' color='#180420'> Select Item : </td>  ";
       echo"<td width=800>" ;

     //Fill List Box
      if (mysqli_connect_errno())
          {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
      else
          {
             $result = mysql_query($Query2)  or die ("Couldn’t execute query2");
             $rows = mysql_num_rows($result);
             $tblName = "Items" ;
             $label = "Choose Item"  ;

             echo '<select name="' . $tblName .'"  >';
             echo '<option value="">' . $label . '</option>';
             echo '<option value="">----------</option>';

             while ($row = mysql_fetch_array($result))
              {
                echo '<option value="' .  $row['ItemID'] . '">' . $row['ItemName'] . '</option>';
              }
             echo '</select>';
          }
       echo "</td> </tr> ";

      // input Transaction Date
      echo " <tr> ";
      echo "    <td  width=200 ><font face='Arial' size='3' color='#180420'> Transaction Date : </td> ";
      echo "    <td width=800> <input type='date' name='TransDate'>";
      echo "    <font face='Arial' size='3' color='#180420'>  hint : Use Date Format yyyy-mm-dd  </td> ";
      echo " </tr>";

      // input Amount
      echo " <tr>  ";
      echo "    <td width=200 ><font face='Arial' size='3' color='#180420'> Amount : </td> ";
      echo "    <td width=800> <input type='text' name='Val'> </td> ";
      echo " </tr>";

      // input Destination
      echo " <tr> ";
      echo "    <td width=200 ><font face='Arial' size='3' color='#180420'> Destination : </td> ";
      echo "    <td width=800> <input type='text' name='Dest' size=90 >  </td> ";
      echo "</tr>";

      //   Submit Query
      echo " <tr> ";
      echo "    <td> ----------- </td><td> <input type='submit' name='submit' value='withdraw'> </td> ";
      echo " </tr>";

      echo"</table>";
      echo"</form>";

      // Catch Values from Form Controls
      $submit=@$_GET['submit'];
      $cat=@$_GET['Categories'];
      $item=@$_GET['Items'];
      $dest=@$_GET['Dest'];
      $date=@$_GET['TransDate'];
      $Value =@$_GET['Val'];

      if($submit)
       {
            // Validate Input data Before Saving it
            $validFrmInput = ValidateFormInputs($cat ,$item , $Value , $date , $dest) ;
            if ($validFrmInput==999)
            {
              echo" <p> Please , Insert Valid data ...  No Work Done !!!!  </p> ";
              exit;
            }

            // Insert data Into table StockTransactions after pass Validation test
            $query= " insert  into stocktransaction
                      (TransDate ,CatID , ItemID , OutFlow , InFlow , Notes )
                       values
                      ('$date','$cat','$item','$Value','0','$dest') ";

            mysql_query($query) or die(" Sorry ... No Record Inserted !!! ");

            // Display Inserted Data Information ...
            echo "  <p> CategoryID   :  $cat    ,  ItemID   : $item  ,  Amount:  $Value  , ";
            echo "  Transaction Date :  $date  ,   Destination  : $dest </p> ";
            echo "  <p> (1) Record Inserted  Successfully ... !! </p>";
        }



 function validate_date($TestDate)
  {
        if (strlen($TestDate) != 10  )
            {
               echo" Wrong Date Format !!"   ;
               return 999 ;
               exit ;
            }
        else
            {
                $arr = explode('-', $TestDate);
                if (count($arr) != 3)
                {
                  echo" Use Date Format --->  yyyy-mm-dd  "   ;
                  return 999 ;
                  exit ;
                }
                else
                {
                  if (strlen($arr[0]) != 4  )
                      {
                         echo" Use format date  yyyy-mm-dd  "   ;
                         return 999 ;
                         exit ;
                      }
                   else
                     {
                        return checkdate($arr[0], $arr[1], $arr[2]);
                     }
                }
            }
}


  ?>
  </div>