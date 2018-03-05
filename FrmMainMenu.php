<html>
    <head>
        <link rel="stylesheet" href="mycss.css"/>  <meta charset="UTF-8">
        <div id="topdiv">
            <h2 style="font-style: bold; font-family: arial; font-size: 32px ; color: #6BD4DB">
            Storage Management System </h2>

            <ul class="menu">
                <li class="selected"><a href="FrmMainMenu.php"> Main Menu </a></li>
                <li><a href="FrmNewOrder.php"> Purchase Order </a></li>
                <li><a href="FrmDisplayAllOrders.php"> Orders </a></li>
                <li><a href="#"> Update Order Status </a></li>
                <li><a href="FrmAddCategory.php"> Add Category </a></li>
                <li><a href="FrmAddItem.php"> Add Item </a></li>
                <li><a href="FrmDisplayAllCategoriesItems.php"> Store Items </a></li>
                <li><a href="FrmItemsWithDraw.php"> Withdraw Items </a></li>
                <li><a href="FrmItemsWithDraw.php">Re-Order Point</a></li>
            </ul>
         </div>
    </head>
    <body  style=" color: #B6F1EC ; background: url(bckground.jpg)">

     <form   method="POST">
                <table border='0px' style="margin-left:15px " >
        <?php


          $UserName = $_GET["User"];
          $Pwd = $_GET["Pass"];
          $host = "localhost" ;
          $database="storagepurchase" ;

          // make database connection variables global for all forms
          $GLOBALS['CurrUserName'] = $UserName;
          $GLOBALS['CurrUserPwd'] = $Pwd;
          $GLOBALS['host'] = $host;
          $GLOBALS['da
          tabase'] = $database;

        ?>


      </form>


  </body>
</html>


  