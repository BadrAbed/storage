<html>
     <head>
            <title> Faculty of Computers - Helwan University </title>
           <link href="mycss.css" rel="stylesheet">

       <div id="topdiv">
            <h2 style="font-style: bold; font-family: arial; font-size: 32px ; color: #6BD4DB">
            Storage Management System </h2>

            <ul class="menu">
                <li><a href="FrmMainMenu.php"> Main Menu </a></li>
                <li><a href="FrmNewOrder.php"> Purchase Order </a></li>
                <li><a href="FrmDisplayAllOrders.php"> Orders </a></li>
                <li><a href="#"> Update Order Status </a></li>
                <li><a href="FrmAddCategory.php"> Add Category </a></li>
                <li class="selected"><a href="FrmAddItem.php"> Add Item </a></li>
                <li><a href="FrmDisplayAllCategoriesItems.php"> Store Items </a></li>
                <li><a href="FrmItemsWithDraw.php"> Withdraw Items </a></li>
                <li><a href="FrmItemsFininsh.php">Re-Order Point</a></li>
            </ul>
         </div>
     </head>


<body  style=" color: #B6F1EC ; background: url(bckground.jpg) ; background-position:  inherit ">

<form   method="POST">

<div id = 'blockdiv' >

<?php

      require 'Connection.php';  // Database connection
      require 'Functions.inc';

      mysql_connect($host,$UserName,$Pwd )  ;
      mysql_select_db($database) or die(mysql_error())  ;

      // Get Categories Drop Down List Box
     echo"<table border width=90% align='center' bgcolor='#5CC3FF'   border='1' cellpadding='5'>";
     echo "<br>";
     echo "<tr> <td width=150><font face='Arial' size='3' color='#180420'> Select category : </td>  ";
     echo "<td width=750 >" ;
     echo   displayDropDown("Categories", "Choose Category" , "CatID" ,"CatName" ,'order by CatName' ) ;
     echo " <input type='submit' name='Filter' value='Show Items'>   " ;
     echo "</td>";
     echo" </tr>";
     echo"</br></table>";

      $Filter=@$_POST['Filter'];

      if ($Filter)

      {
           $catID=@$_POST['Categories'];
           $GLOBALS['CurrCatID'] = $catID;

           if ($catID>0)
              {
                DisplayItems(" where CatID = $CurrCatID ") ;
              }
           echo"  <td> <input type='hidden' name ='SelCatID' id='SelCatID' value = $CurrCatID > ";
      }

      // input ItemID
      echo"<table border width=90% align='center' bgcolor='#5CC3FF' border='1' cellpadding='5'>";
      echo " <tr>  ";
      echo "    <td width=150><font face='Arial' size='3' color='#180420'> Item ID : </td> ";
      echo "    <td width=750><input type='text' name='txtItemID'> </td> ";
      echo " </tr>";

      // input Date
      echo " <tr> ";
      echo "    <td width=150><font face='Arial' size='3' color='#180420'> Item Name : </td> ";
      echo "    <td width=750> <input type='text' name='txtItemName' size=120 > </td> ";
      echo " </tr>";

     // input Date
      echo " <tr> ";
      echo "    <td width=150><font face='Arial' size='3' color='#180420'> Item Price : </td> ";
      echo "    <td width=750> <input type='text' name='txtItemPrice'> </td> ";
      echo " </tr>";

      // input Notes
      echo " <tr> ";
      echo "    <td width=150><font face='Arial' size='3' color='#180420'> Description : </td> ";
      echo "    <td width=750> <input type='text' name='txtNotes' size=120 >  </td> ";
      echo "</tr>";

      //   Submit Query
      echo " <tr> ";
      echo "    <td width=150> ----------  </td>   ";
      echo "    <td width=750> <input type='submit' name='submit' value='Add New Item'> </td> ";
      echo " </tr>";

      echo"</table>";
      echo"</form>";

      // Catch Values from Form Controls
      $submit=@$_POST['submit'];
      $ItemID=@$_POST['txtItemID'];
      $ItemName=@$_POST['txtItemName'];
      $ItemPrice=@$_POST['txtItemPrice'];
      $Notes=@$_POST['txtNotes'];
      $CurrCatID  =@$_POST['SelCatID'];

      if($submit)
       {

       // Validate Input data Before Saving it
            $validFrmInput = ValidateFormInputs($CurrCatID , $ItemID , $ItemName , $ItemPrice  ) ;
            if ($validFrmInput==999)
            {
              echo" <p> Please , Insert Valid data ...  No Work Done !!!!  </p> ";
              exit;
            }

            // Insert data Into table StockTransactions after pass Validation test
            $query= " insert  into Items
                      ( CatID , ItemID , ItemName , ItemPrice , Notes )
                       values
                      ('$CurrCatID','$ItemID' , '$ItemName','$ItemPrice','$Notes' ) ";

            mysql_query($query) or die(" Sorry ... No Record Inserted !!! ");

            // Display Inserted Data Information ...
            echo "  <p> CategoryID   :  $CurrCatID    ,  ItemID   : $ItemID , Item Name :  $ItemName  ";
            echo "  <p> (1) Record Inserted  Successfully ... !! </p>";

       }


       

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
           echo " <table style='WORD-BREAK:BREAK-ALL' width='90%'
                    bgcolor='#5CC3FF' align='center' border='1' cellpadding='5'>";
           echo " <tr  bgcolor='#5CC3FF' align='center' height=35>
                      <td width=250 ><font face='Arial' size='3' color='#180420'>   Category ID  :       </td>
                      <td width=250 ><font face='Arial' size='3' color='#180420'>    Item ID  :     </td>
                      <td width=800 ><font face='Arial' size='3' color='#180420'>    Item Name  :     </td>
                      <td width=250 ><font face='Arial' size='3' color='#180420'>    Item Price   :     </td>
                      <td width=800 ><font face='Arial' size='3' color='#180420'>    Description  :     </td>
                 </tr></table>";

          while ($row = mysql_fetch_array($result))
               {
                  $CatID = $row["CatID"] ;
                  $ItemID = $row["ItemID"] ;
                  $ItemName = $row["ItemName"] ;
                  $Price = $row["ItemPrice"] ;
                  $Notes = $row["Notes"] ;

                 echo "<table style='WORD-BREAK:BREAK-ALL' width='90%'
                        bgcolor='#5CC3FF' align='center' border='1' cellpadding='5'>";
                 echo "<tr>
                          <td width=250 ><font face='Arial' size='3' color='#180420'>    $CatID   </td>
                          <td width=250 ><font face='Arial' size='3' color='#180420'>   $ItemID   </td>
                          <td width=800 ><font face='Arial' size='3' color='#180420'>   $ItemName   </td>
                          <td width=250 ><font face='Arial' size='3' color='#180420'>   $Price   </td>
                          <td width=800 ><font face='Arial' size='3' color='#180420'>   $Notes   </td>
                       </tr></table>" ;
              }
          }
  }

function ValidateFormInputs($CurrCatID , $ItemID , $ItemName , $ItemPrice  )
  {

                   echo" Curr cat ID : $CurrCatID ";

  if(strlen($CurrCatID) < 1 or !is_numeric($CurrCatID))
          {
            echo "Enter Valid Number as Category ID !!";
            return 999 ;
            exit;
          }

        if(strlen($ItemID) < 1 or !is_numeric($ItemID))
          {
            echo "Enter Valid Number as Item ID !!";
            return 999 ;
            exit;
          }

         if(strlen($ItemName) < 1 )
          {
            echo "Enter Valid Item Name !! ";
            return 999 ;
            exit;
          }

        if(strlen($ItemPrice) < 1 or !is_numeric($ItemPrice))
          {
            echo "Enter Valid Number as Item ID !!";
            return 999 ;
            exit;
          }


  }

  ?>

    </div>
    </body>
    <div id="bottomdiv"> <center>
        <div style="  font-style: bold; font-family: arial; font-size: 18px ; color: #180420">
            &#169; (2014-2015) Faculty of Computers - Helwan University
        </div></center>
     </div>

</html>
