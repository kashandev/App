<?php
   // include session //
   include_once('../../session/session.php'); // this is used for include session //
   // end of include session // ?> 
<?php
   // include date //
   include_once('../date/date.php'); // this is used for include date //
   // end of include date // ?> 

<?php
   // include view links //
   include_once('../view-links.php'); // this is used for include view links //
   // end of include view links // ?> 
  <title>Document</title>
  <?php
     // include conn //
   include_once('../../conn/conn.php'); // this is used for include conn //
    // end of include conn //
$msg           = '';
$btn           = '';
$timestamp     = '';
$createdate    = '';
$paymentmethod = '';
$refno         = '';
$fname         = '';
$fathername    = '';
$cnic          = '';
$address       = '';
$province      = '';
$offaddress    = '';
$email         = '';
$phone         = '';
$whatsapp      = '';
$kin           = '';
$thisdate      = '';
if (isset($_GET['id']) == '') {
    $_GET['id']   = '';
    $thisregno    = '';
    $thisname     = '';
    $thisfname    = '';
    $thiscnic     = '';
    $thisprovince = '';
    $thisresadd   = '';
    $thisoffadd   = '';
    $thisemail    = '';
    $thisphone    = '';
    $thiswhats    = '';
    $thiskin      = '';
    $thisnom      = '';
    $thisnomcnic  = '';
    $thisrelation = '';
    $thisdate     = '';
}

if (isset($_GET['id'])) {
    $thisregno    = '';
    $sql          = '';
    $thisname     = '';
    $thisfname    = '';
    $thiscnic     = '';
    $thisprovince = '';
    $thisresadd   = '';
    $thisoffadd   = '';
    $thisemail    = '';
    $thisphone    = '';
    $thiswhats    = '';
    $thiskin      = '';
    $thisnom      = '';
    $thisnomcnic  = '';
    $thisrelation = '';
    $id           = $_GET['id'];
    $sql          = "SELECT * from forms_master where fmid = '" . $id . "' ";
    $res          = mysqli_query($conn, $sql);
    $sql          = $res;
    $total        = mysqli_num_rows($sql);
    if (mysqli_num_rows($sql)) {
        foreach ($sql as $key => $row) {
            $regno      = $row['regno'];
            $fullname   = $row['fullname'];
            $fname      = $row['fathersname'];
            $cnic       = $row['cnic'];
            $resaddress = $row['resaddress'];
            $province   = $row['province'];
            $offaddress = $row['offaddress'];
            $email      = $row['email'];
            $phone      = $row['phone'];
            $whatsappno = $row['whatsappno'];
            $nom        = $row['nom'];
            $nomcnic    = $row['nomcnic'];
            $relation   = $row['relation'];
            $createdate = $row['createdate'];
            
            $thisregno    = $regno;
            $thisname     = $fullname;
            $thisfname    = $fname;
            $thiscnic     = $cnic;
            $thisprovince = $province;
            $thisphone    = $phone;
            empty($resaddress) ? $thisresadd = '' : $thisresadd = $resaddress;
            empty($offaddress) ? $thisoffadd = '' : $thisoffadd = $offaddress;
            empty($email) ? $thisoffadd = '' : $thisemail = $email;
            empty($whatsappno) ? $thiswhats = '' : $thiswhats = $whatsappno;
            empty($nom) ? $thisnom = '' : $thisnom = $nom;
            empty($nomcnic) ? $thisnomcnic = '' : $thisnomcnic = $nomcnic;
            empty($relation) ? $thisrelation = '' : $thisrelation = $relation;
            $thisdate = date_create($createdate);
            $thisdate = date_format($thisdate, 'd-m-Y');
            
        }
    }
}
// if (isset($_SESSION['paymentmethod'])) {
//     $paymentmethod = $_SESSION['paymentmethod'];

//     if ($paymentmethod == 'bank') {
//         $createdate    = $_SESSION['date'];
//         $refno      = $_SESSION['bnkregno'];
//         $fname      = $_SESSION['bnkfname'];
//         $fathername = $_SESSION['bnkfathername'];
//         $cnic       = $_SESSION['bnkcnic'];
//         $address    = $_SESSION['bnkaddress'];
//         $province   = $_SESSION['bnkprovince'];
//         $offaddress = $_SESSION['bnkoffaddress'];
//         $email      = $_SESSION['bnkemail'];
//         $phone      = $_SESSION['bnkphone'];
//         $whatsapp   = $_SESSION['bnkwhatsapp'];
//         $kin        = $_SESSION['bnkkin'];
//     }

//     if ($paymentmethod == 'easy') {
//         $createdate    = $_SESSION['date'];
//         $refno      = $_SESSION['easyregno'];
//         $fname      = $_SESSION['easyfname'];
//         $fathername = $_SESSION['easyfathername'];
//         $cnic       = $_SESSION['easycnic'];
//         $address    = $_SESSION['easyaddress'];
//         $province   = $_SESSION['easyprovince'];
//         $offaddress = $_SESSION['easyoffaddress'];
//         $email      = $_SESSION['easyemail'];
//         $phone      = $_SESSION['easyphone'];
//         $whatsapp   = $_SESSION['easywhatsapp'];
//         $kin        = $_SESSION['easykin'];

//     }
//     if ($paymentmethod == 'jazz') {
//         $createdate    = $_SESSION['date']; 
//         $refno      = $_SESSION['jazzregno'];
//         $fname      = $_SESSION['jazzfname'];
//         $fathername = $_SESSION['jazzfathername'];
//         $cnic       = $_SESSION['jazzcnic'];
//         $address    = $_SESSION['jazzaddress'];
//         $province   = $_SESSION['jazzprovince'];
//         $offaddress = $_SESSION['jazzoffaddress'];
//         $email      = $_SESSION['jazzemail'];
//         $phone      = $_SESSION['jazzphone'];
//         $whatsapp   = $_SESSION['jazzwhatsapp'];
//         $kin        = $_SESSION['jazzkin'];

// }
// }
   ?>
<body id="printarea">
<page size="A4" layout="landscape">
   <div class="page" id="content" >
      <!-- First PDF Column -->
      <div class="grid-item">
         <h4 class="pdf-head poppins">BANK COPY</h4>
         <div class="main-images">
            <div class="row">
               <div class="col-md-6">
                  <img src="../../images/img-3.jpg" alt="" class="logo">
               </div>
               <div class="col-md-6">
                  <h5>گھر سب کے لیے</h5>
               </div>
            </div>
                <?php
                  // include heading //
                  include_once('../heading/view-heading.php'); // this is used for include heading //
                  // end of include heading // ?> 
            <div class="row">
               <div class="col-md-8">
               </div>
               <div class="col-md-4">
                  <div class="ref readfield">
                     <label for="country" style="margin-left: 17px;">REF#:</label>  
                     <input type="text" id="refno" name="refno" readonly class="nonreadable refno"><br><br>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-8">
               </div>
               <div class="col-md-4">
                  <div class="ref readfield">
                     <label for="country" style="margin-left: 17px;">Date:</label>  
                     <input type="text" id="date" name="date" readonly class="nonreadable date"><br><br>
                  </div>
               </div>
            </div>
            <!-- Main form fields -->
            <div class="mainforms">
               <!-- fields1 -->
               <table>
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess name"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;CNIC/NICOP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess cnic"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row 2 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Father's Name:</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess fname"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Mobile &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess mobile"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row3 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Email ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess email"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Whatsapp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess wapp"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row 4 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Nominee &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" value="" readonly class="nonreadablemess nom"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;CNIC(Nominee) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess nomcnic"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row5 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Relation &nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" value="" readonly class="nonreadablemess rel"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess mobile"><br><br>
                        </div>
                     </td>
                  </tr>
               </table>
               <!-- Row5 -->
               <div class="ref readfield">
                  <label for="country">Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                  <input type="text" id="address" name="address" readonly class="add"><br><br>
               </div>
               <!-- Urdu headlines Starts-->
               <div class="urdu-content">
                  <h3>ضروری ہدایات</h3>
                  <li>قرعه اندازی میں دیا جانے والا ہلات بالکل مفت ہے </li>
                  <li>تعمیراتی کام، کاغزی کاروای، اور دیگر اخراجات کی قیمت خود ادا کرنی ہوگی</li>
                  <li>قرعه اندازی میں رہ جانے والے لوگوں کے لیے خصوصی رعایتی قیمت پر بلات حاصل کرے کے مواقع ہونگے۔ جو کہ لمیٹڈ تعداد میں پہلے او پہلے باوکی بنیاد پر دی جاءینگے۔</li>
                  <li>پروسیسنگ فیس مندرجہ زیل دیے گئے اکاونٹس میں جمع کرای جا سکتی ہے</li>
               </div>
               <!-- Urdu headlines end -->
               <!-- Form Will come Here -->
               <div class="form-output">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="output">
                           <h4>Bank Al-Habib A/c # </h4>
                           <h4>Jazz Cash A/c # </h4>
                           <h4>Easy Paisa A/c # </h4>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="output">
                           <p>00000</p>
                           <p>00000</p>
                           <p>00000</p>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="output Urdu">
                           <h4>بینک الحبیب اکاونٹ نمبر</h4>
                           <h4>جاز کیش اکاونٹ نمبر</h4>
                           <h4>ایزی پیسه اكاونت نمبر</h4>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Form will end here -->
               <!-- footer-logo-Start -->
               <div class="foologo">
                  <li><img src="../../images/img-1.jpg" alt=""></li>
                  <li><img src="../../images/img-2.jpg" alt=""></li>
                  <li><img src="../../images/img-3.jpg" alt=""></li>
                  <li><img src="../../images/img-4.jpg" alt=""></li>
               </div>
               <!-- footer-logo-Start -->
            </div>
         </div>
      </div>
      <!-- Second PDF Column -->
      <div class="grid-item">
         <h4 class="pdf-head poppins">OFFICAL COPY</h4>
         <div class="main-images">
            <div class="row">
               <div class="col-md-6">
                  <img src="../../images/img-3.jpg" alt="" class="logo">
               </div>
               <div class="col-md-6">
                  <h5>گھر سب کے لیے</h5>
               </div>
            </div>
            <h4 class="pdf-head poppins">AL-FAIZ RESIDENCY OWRANGI TOWN KARACHI<br>
               APPLICATION FORM FOR LUCKY DRAW 2022
            </h4>
            <div class="row">
               <div class="col-md-8">
               </div>
               <div class="col-md-4">
                  <div class="ref readfield">
                     <label for="country" style="margin-left: 17px;">REF#:</label>  
                     <input type="text" id="refno" name="refno" readonly class="nonreadable refno"><br><br>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-8">
               </div>
               <div class="col-md-4">
                  <div class="ref readfield">
                     <label for="country" style="margin-left: 17px;">Date:</label>  
                     <input type="text" id="date" name="date" readonly class="nonreadable date"><br><br>
                  </div>
               </div>
            </div>
            <!-- Main form fields -->
            <div class="mainforms">
               <!-- fields1 -->
               <table>
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess name"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;CNIC/NICOP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess cnic"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row 2 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Father's Name:</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess fname"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Mobile &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="mobile" readonly class="nonreadablemess mobile"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row3 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Email ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess email"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Whatsapp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess wapp"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row 4 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Nominee &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" value="" readonly class="nonreadablemess nom"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;CNIC(Nominee) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess nomcnic"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row5 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Relation &nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" value="" readonly class="nonreadablemess rel"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Mobile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess mobile"><br><br>
                        </div>
                     </td>
                  </tr>
               </table>
               <!-- Row5 -->
               <div class="ref readfield">
                  <label for="country">Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                  <input type="text" id="address" name="address" readonly class="add"><br><br>
               </div>
               <!-- Urdu headlines Starts-->
               <div class="urdu-content">
                  <h3>ضروری ہدایات</h3>
                  <li>قرعه اندازی میں دیا جانے والا ہلات بالکل مفت ہے </li>
                  <li>تعمیراتی کام، کاغزی کاروای، اور دیگر اخراجات کی قیمت خود ادا کرنی ہوگی</li>
                  <li>قرعه اندازی میں رہ جانے والے لوگوں کے لیے خصوصی رعایتی قیمت پر بلات حاصل کرے کے مواقع ہونگے۔ جو کہ لمیٹڈ تعداد میں پہلے او پہلے باوکی بنیاد پر دی جاءینگے۔</li>
                  <li>پروسیسنگ فیس مندرجہ زیل دیے گئے اکاونٹس میں جمع کرای جا سکتی ہے</li>
               </div>
               <!-- Urdu headlines end -->
               <!-- Form Will come Here -->
               <div class="form-output">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="output">
                           <h4>Bank Al-Habib A/c # </h4>
                           <h4>Jazz Cash A/c # </h4>
                           <h4>Easy Paisa A/c # </h4>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="output">
                           <p>00000</p>
                           <p>00000</p>
                           <p>00000</p>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="output Urdu">
                           <h4>بینک الحبیب اکاونٹ نمبر</h4>
                           <h4>جاز کیش اکاونٹ نمبر</h4>
                           <h4>ایزی پیسه اكاونت نمبر</h4>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Form will end here -->
               <!-- footer-logo-Start -->
               <div class="foologo">
                  <li><img src="../../images/img-1.jpg" alt=""></li>
                  <li><img src="../../images/img-2.jpg" alt=""></li>
                  <li><img src="../../images/img-3.jpg" alt=""></li>
                  <li><img src="../../images/img-4.jpg" alt=""></li>
               </div>
               <!-- footer-logo-Start -->
            </div>
         </div>
      </div>
      <!-- Third PDF Column -->
      <div class="grid-item">
         <h4 class="pdf-head poppins">CUSTOMER COPY</h4>
         <div class="main-images">
            <div class="row">
               <div class="col-md-6">
                  <img src="../../images/img-3.jpg" alt="" class="logo">
               </div>
               <div class="col-md-6">
                  <h5>گھر سب کے لیے</h5>
               </div>
            </div>
            <h4 class="pdf-head poppins">AL-FAIZ RESIDENCY OWRANGI TOWN KARACHI<br>
               APPLICATION FORM FOR LUCKY DRAW 2022
            </h4>
            <div class="row">
               <div class="col-md-8">
               </div>
               <div class="col-md-4">
                  <div class="ref readfield">
                     <label for="country" style="margin-left: 17px;">REF#:</label>  
                     <input type="text" id="refno" name="refno" readonly class="nonreadable refno"><br><br>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-8">
               </div>
               <div class="col-md-4">
                  <div class="ref readfield">
                     <label for="country" style="margin-left: 17px;">Date:</label>  
                     <input type="text" id="date" name="date" readonly class="nonreadable date"><br><br>
                  </div>
               </div>
            </div>
            <!-- Main form fields -->
            <div class="mainforms">
               <!-- fields1 -->
               <table>
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess name"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;CNIC/NICOP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess cnic"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row 2 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Father's Name:</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess fname"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Mobile &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess mobile"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row3 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Email ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" readonly class="nonreadablemess email"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Whatsapp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess wapp"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row 4 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Nominee &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" value="" readonly class="nonreadablemess nom"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;CNIC(Nominee) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess nomcnic"><br><br>
                        </div>
                     </td>
                  </tr>
                  <!-- Row5 -->
                  <tr>
                     <td>
                        <div class="ref readfield">
                           <label for="country">Relation &nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="name" name="name" value="" readonly class="nonreadablemess rel"><br><br>
                        </div>
                     </td>
                     <td>
                        <div class="ref readfield">
                           <label for="country">&nbsp;&nbsp;Mobile &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                           <input type="text" id="date" name="date" readonly class="nonreadablemess mobile"><br><br>
                        </div>
                     </td>
                  </tr>
               </table>
               <!-- Row5 -->
               <div class="ref readfield">
                  <label for="country">Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>  
                  <input type="text" id="address" name="address" readonly class="add"><br><br>
               </div>
               <!-- Urdu headlines Starts-->
               <div class="urdu-content">
                  <h3>ضروری ہدایات</h3>
                  <li>قرعه اندازی میں دیا جانے والا ہلات بالکل مفت ہے </li>
                  <li>تعمیراتی کام، کاغزی کاروای، اور دیگر اخراجات کی قیمت خود ادا کرنی ہوگی</li>
                  <li>قرعه اندازی میں رہ جانے والے لوگوں کے لیے خصوصی رعایتی قیمت پر بلات حاصل کرے کے مواقع ہونگے۔ جو کہ لمیٹڈ تعداد میں پہلے او پہلے باوکی بنیاد پر دی جاءینگے۔</li>
                  <li>پروسیسنگ فیس مندرجہ زیل دیے گئے اکاونٹس میں جمع کرای جا سکتی ہے</li>
               </div>
               <!-- Urdu headlines end -->
               <!-- Form Will come Here -->
               <div class="form-output">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="output">
                           <h4>Bank Al-Habib A/c # </h4>
                           <h4>Jazz Cash A/c # </h4>
                           <h4>Easy Paisa A/c # </h4>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="output">
                           <p>00000</p>
                           <p>00000</p>
                           <p>00000</p>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="output Urdu">
                           <h4>بینک الحبیب اکاونٹ نمبر</h4>
                           <h4>جاز کیش اکاونٹ نمبر</h4>
                           <h4>ایزی پیسه اكاونت نمبر</h4>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Form will end here -->
               <!-- footer-logo-Start -->
               <div class="foologo">
                  <li><img src="../../images/img-1.jpg" alt=""></li>
                  <li><img src="../../images/img-2.jpg" alt=""></li>
                  <li><img src="../../images/img-3.jpg" alt=""></li>
                  <li><img src="../../images/img-4.jpg" alt=""></li>
               </div>
               <!-- footer-logo-Start -->
            </div>
         </div>
      </div>
   </div>
   </div>
</page>
</div>
</body>
</html>
<script>
   $(document).ready(function(){
     var refno = '<?php echo $thisregno ?>';
     var date = '<?php echo $thisdate ?>';
     var name = '<?php echo $thisname ?>';
     var fname = '<?php echo $thisfname ?>';
     var cnic = '<?php echo $thiscnic ?>';
     var email = '<?php echo $thisemail ?>';
     var phone = '<?php echo $thisphone ?>';
     var whatsapp = '<?php echo $thiswhats ?>';  
     var add = '<?php echo $thisresadd ?>';
     var nom = '<?php echo $thisnom ?>';
     var nomcnic = '<?php echo $thisnomcnic ?>';
     var relation = '<?php echo $thisrelation ?>'; 
   
    $('.refno').val(refno);
    $('.date').val(date);
    $('.name').val(name);
    $('.fname').val(fname);
    $('.cnic').val(cnic);
    $('.email').val(email);
    $('.mobile').val(phone);
    $('.wapp').val(whatsapp);
    $('.add').val(add);
    $('.nom').val(nom);
    $('.nomcnic').val(nomcnic);
    $('.rel').val(relation);
    window.print();

   });
   
</script>