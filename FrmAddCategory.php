
4html>
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
                <li class="selected"><a href="FrmAddCategory.php"> Add Category </a></li>
                <li><a href="FrmAddItem.php"> Add Item </a></li>
                <li><a href="FrmDisplayAllCategoriesItems.php"> Store Items </a></li>
                <li><a href="FrmItemsWithDraw.php"> Withdraw Items </a></li>
                <li><a href="FrmItemsFininsh.php">Re-Order Point</a></li>
            </ul>
         </div>



   <div id="bottomdiv"> <center>
        <div style="  font-style: bold; font-family: arial; font-size: 18px ; color: #180420">
            &#169; (2014-2015) Faculty of Computers - Helwan University
        </div></center>
     </div>

   </head>

<body  style=" color: #B6F1EC ; background: url(bckground.jpg) ; background-position:  inherit ">

<form   method="POST">

<div id="blockdiv" >
 <?php

      require 'Connection.php';  // Database connection
      mysql_connect($host,$UserName,$Pwd )  ;
      mysql_select_db($database) or die(mysql_error())  ;

      //Get data for Categories listbox
      $Query="  SELECT      CatID , CatName
                FROM        Categories
                Order By    CatID";


      echo"<p  align='center' > <font face='Arial' size='5' color='#180420'> Current Store Categories </p>";

      DisplayCategories($Query) ;

      //
      echo"<p  align='center' > <font face='Arial' size='5' color='#180420'> Insert New Category </p>";

      // input CatID
      echo"<table border width=90%  align='center' bgcolor='#5CC3FF'  >";
      echo " <tr>  ";
      echo "    <td width=300 ><font face='Arial' size='3' color='#180420'> CategoryID : </td> ";
      echo "    <td width=700 > <input type='text' name='txtCatID'> </td> ";
      echo " </tr>";

      // input Date
      echo " <tr> ";
      echo "    <td width=300 ><font face='Arial' size='3' color='#180420'> Category Name : </td> ";
      echo "    <td width=700> <input type='text' name='txtCatName'> </td> ";
      echo " </tr>";

       //   Submit Query
      echo " <tr> ";
      echo "    <td><font face='Arial' size='3' color='#180420'> </td>  ";
      echo "    <td><font face='Arial' size='3' color='#180420'>";
      echo "  <input type='submit' name='submit' value='Add New Category'> </td> ";
      echo " </tr>";

      echo"<p>  </p>";

      echo"</table>";
      echo"</form>";

      // Catch Values from Form Controls
      $submit=@$_POST['submit'];
      $catID=@$_POST['txtCatID'];
      $CatName=@$_POST['txtCatName'];

      if($submit)
       {
            // Validate Input data Before Saving it
            $validFrmInput = ValidateFormInputs($catID ,$CatName) ;
            if ($validFrmInput==999)
            {
              echo" <p> Please , Insert Valid data ...  No Work Done !!!!  </p> ";
              exit;
            }

            // Insert data Into table StockTransactions after pass Validation test
            $query= " insert  into Categories
                      ( CatID , CatName )
                       values
                      ('$catID','$CatName') ";

            mysql_query($query) or die(" Sorry ... No Record Inserted !!! ");

            // Display Inserted Data Information ...
            echo "  <p> CategoryID   :  $catID    ,  CategoryName   : $CatName   ";
            echo "  <p> (1) Record Inserted  Successfully ... !! </p>";
            DisplayCategories($Query) ;
       }

function      DisplayCategories($Query)
 {
     $result = mysql_query($Query)  or die ("Couldn’t execute query");
     $rows = mysql_num_rows($result);
     if ($rows < 1)
         {
           echo "<hr>  <b>  No results Found </b>  <hr>\n";
         }
    else
        {
          echo " <table style='WORD-BREAK:BREAK-ALL' width='90%'
                   align='center' border='1' cellpadding='5'>";
           echo " <tr bgcolor='#5CC3FF' align='center' height=55>
                      <td  width=300 ><font face='Arial' size='3' color='#180420'> Category ID  </td>
                      <td  width=800 ><font face='Arial' size='3' color='#180420'> Category Name </td>
                 </tr></table>";

          while ($row = mysql_fetch_array($result))
               {
                  $CatID = $row["CatID"] ;
                  $CatName = $row["CatName"] ;

                 echo "<table style='WORD-BREAK:BREAK-ALL' width='90%'
                        bgcolor='#5CC3FF' align='center' border='1' cellpadding='5'>";
                 echo "<tr>
                          <td width=300 ><font face='Arial' size='3' color='#180420'>    $CatID   </td>
                          <td width=800 ><font face='Arial' size='3' color='#180420'>   $CatName   </td>
                       </tr></table>" ;
              }
          }
  }

function ValidateFormInputs($catID , $CatName )
  {
        if(strlen($catID) < 1 or !is_numeric($catID))
          {
            echo "Enter Valid Number as Category ID !!";
            return 999 ;
            exit;
          }

         if(strlen($CatName) < 1 )
          {
            echo "Enter Valid category Name !! ";
            return 999 ;
            exit;
          }
  }

  ?>

   </div>


</html>
