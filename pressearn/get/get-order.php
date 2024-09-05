<?php

// get order //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //



// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //



$tlvid = "";

$uid = "";

$sql = "";

$res = "";

$odate = "";

$otime = "";

$ono = "";

$amount = "";

$tc = "";

$pc = "";

$ec = "";

$nod = "";

$thisono = "";

$thisnod = "";

$thisodate = "";

$thisotime = "";

$thisodatetime = "";

$timestamp = "";

$orderdate = "";

$timestamp = time();

$orderdate = date("Y-m-d", $timestamp);

$thisdate = "";

$thisamount = "";

$thistc = "";

$thispc = "";

$thisec = "";

$orderdiv = "";

$x = 0;

$pid  = [];

$pname  = [];

$pimg = [];

$thispid = "";

$thispname = "";

$thispimg = "";

$target = "";

$thisimg = "";

$thisplabel = "";

// end of variables //

if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];

    $oid = $_POST["oid"];



  $sql = "SELECT * from product_images WHERE iscancel = 0 AND isclose = 0 AND product_images.oid = '".$oid."'";

  $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res)){

    while($row = mysqli_fetch_array($res))

    {

        $pid[$x] = $row['pid'];

        $pname[$x] = $row['pname'];

        $pimg[$x] = $row['pimg'];

        $x++;

    }

   }

   for ($i=0; $i < count($pid) ; $i++) { 

       $thispid =  $pid[$i];

       $thispname =  $pname[$i];

       $thispimg = $pimg[$i];

       $target = 'images/product-images/'.$thispimg;

       empty($thispimg) ?     $thisimg = ''     :  $thisimg = ' <img src="'.$target.'" alt="">';

       file_exists($target) ? $thisimg = ''     :  $thisimg = '<img src="'.$target.'" alt="">';

       empty($thispname) ?    $thisplabel = ''  :  $thisplabel = '<label>'.$thispname.'</label>'; 

   }



    $sql =

        "SELECT * FROM commission_history WHERE CAST(createdate as date) = '".$orderdate."' AND uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "' AND oid = '" .

        $oid .

        "' AND iscancel = 0";

    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res)) {

        while ($row = mysqli_fetch_array($res)) {

            $ono = $row["ono"];

            $nod = $row["nod"];

            $odate = $row["createdate"];

            $otime = $row["createtime"];

            $amount = $row["amount"];

            $tc = $row["tc"];

            $pc = $row["pc"];

            $ec = $row["ec"];

            $thisono = $ono;

            $thisnod = (int) $nod;

            $thisodate = $odate;

            $thisotime = $otime;

            $thisdate = date_create($thisodate);

            $thisdate = date_format($thisdate, "d-m-Y");

            $thisodatetime = $thisdate . " " . $thisotime;

            $thisamount = $amount;

            $thistc = $tc;

            $thispc = $pc;

            $thisec = $ec;

            $orderdiv .=

                '



     <h5 class="ebay">Order</h5>

    <p>Order Time: ' .

                $thisodatetime .

                ' </p>

    <p>Order Number: ' .

                $thisono .

                ' </p>

    '.$thisimg.'

    '.$thisplabel.'

    <div class="totalamount">

        <h5>Commission Amount</h5>

        <p class="camount">' .

                $thistc .

                '</p>

    </div>

    <div class="totalamount">

        <h5>Total Commission</h5>

        <p class="tcom">' .

                abs(number_format($thisec, 2)) .

                '</p>

    </div>

    <div class="sub-btns">

        <button type="button" class="btn cancel btn-cancel" onclick="hidediv()">Cancel</button>

        <button type="button" class="btn submit btn-confirm-order" onclick="hidediv()">Submit</button>

    </div>

            ';

        }

    } else {

        $orderdiv = "There is no orders found!";

    }

    echo $orderdiv;

}

?>

