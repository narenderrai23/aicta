<?php include 'layouts/session.php'; ?>

<?php
include('../php/model/students.php');

if (!isset($_GET['id'])) {
    header('Location: manage-students.php');
    exit;
}

if (empty($_SESSION['loggedin'])) {
    header('Location: logout.php');
    exit;
}

$Student = new Student();
$id = $_GET['id'];
$data = $Student->fetchStudent($id);

if (empty($data->id)) {
    header('Location: manage-students.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Form Preview</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Libre Barcode 39' rel='stylesheet'>

    <style type="text/css">
        body {
            background: rgb(204, 204, 204);
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
            padding: 20px;
        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: 0;
            }
        }

        table {
            border-collapse: collapse;
            width: 100%;

        }

        .tdtitle {
            border: 2px solid black;
        }

        .tdtitle2 {
            border: 2px solid black;
            width: 170px;
        }

        .tddesc1 {
            border: 2px solid black;
            width: 30%;

        }

        .tddesc2 {
            border: 2px solid black;
            width: 40%;

        }

        .boxlabel {
            margin-left: 5px;
            font-size: 14px;
            font-family: Source Sans Pro;
        }

        .fldentry {
            margin: 0 0 0 5px;
            font-size: 15px;
            font-family: Source Sans Pro;
            font-weight: bold;
        }

        .labelhnd {
            font-size: 13px;
        }

        .barcode {
            color: red;
        }
    </style>
</head>

<body>
    <page size="A4">
        <table>
            <tr style=" background: #034DA2; border: 2px solid black;">
                <td colspan="1" style="padding: 10px;text-align: center;">
                    <img src="../assets/image/iact-logo.png" width="150px">
                </td>
                <td colspan="4" style="font-weight: bold; text-align: center; padding: 10px; color: #fff; border-right: 2px solid black;">
                    <h2 style="margin: 0; margin-block-end: 10px;">Institute for Advanced Computer Technology</h2>
                    <h4 style="margin: 0;font-family: Verdana;">(A Unit of <?=$_SESSION['site_name']?> Education Pvt. Ltd.)</h4>
                </td>
            </tr>

            <tr>
                <td colspan="6" style="border: 2px solid black; font-weight: bold;text-align: center; height: 30px;font-family: Arial;">
                    Enrollment Acknowledgment Slip</td>
            </tr>

            <tr>
                <td rowspan="2" style="border: 2px solid black; text-align: center; padding: 20px; width: 30%">

                    <div style="width: 90px; height: 120px; border: 2px solid black; margin: auto;text-align: center;
         vertical-align: middle;">
                        <img src="../assets/upload/<?= $data->profile_image ?>" style="max-width: 90px; max-height: 120px;">

                </td>


                <td colspan="4" style="border: 2px solid black; text-align: center;">
                    <img class="barcode" alt="hello" src="../barcode/barcode.php?text=VND20230708156039&codetype=code128&orientation=horizontal&size=30&print=true" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border: 2px solid black; text-align: center; vertical-align: top;
             padding-top: 10px;padding-bottom: 10px;font-size: 16px;font-family: Source Sans Pro;">
                    <label> Student's Name <span class="labelhnd"> / छात्र/छात्रा का नाम</span></label>
                    <p class="fldentry" style="padding-top: 10px;"><?= $data->student_name ?></p>
                </td>
                <td colspan="2" style="border: 2px solid black; text-align: center;vertical-align: top; 
          padding-top: 10px;padding-bottom: 10px; font-size: 16px;font-family: Source Sans Pro;">
                    <label> Branch Name<span class="labelhnd"> / शाखा का नाम</span></label>
                    <p class="fldentry" style="padding-top: 10px;"><?= $data->branch_name ?></p>
                </td>

            </tr>

            <tr style="height: 30px;">
                <td class="tdtitle">
                    <label class="boxlabel"> Date of Admission<span class="labelhnd"> / प्रवेश की तिथि</span></label>
                </td>
                <td class="tddesc1">
                    <p class="fldentry"><?= $data->date_admission ?></p>
                </td>

                <td class="tdtitle2">
                    <label class="boxlabel"> Father's Name<span class="labelhnd"> / पिता का नाम</span></label>
                </td>
                <td class="tddesc2">
                    <p class="fldentry"><?= $data->father_name ?> </p>
                </td>
            </tr>
            <tr style="height: 30px;">
                <td class="tdtitle">
                    <label class="boxlabel"> Course Name<span class="labelhnd"> / कोर्स का नाम</span></label>
                </td>
                <td class="tddesc1">
                    <p class="fldentry"><?= $data->course_code ?></p>
                </td>
                <td class="tdtitle2">
                    <label class="boxlabel"> Date of Birth<span class="labelhnd"> / जन्म तिथि</span></label>
                </td>
                <td class="tddesc2">
                    <p class="fldentry"><?= $data->student_dob ?></p>
                </td>
            </tr>
            <tr style="height: 30px;">
                <td class="tdtitle">
                    <label class="boxlabel"> Course Duration<span class="labelhnd"> / कोर्स की अवधि</span></label>
                </td>
                <td class="tddesc1">
                    <p class="fldentry"><?= $data->course_duration . ' ' . $data->duration_time ?></p>
                </td>
                <td class="tdtitle2">
                    <label class="boxlabel"> Mobile No.<span class="labelhnd"> / मोबाइल न.</span></label>
                </td>
                <td class="tddesc2">
                    <p class="fldentry"><?= $data->student_phone ?></p>
                </td>
            </tr>
            <tr style="height: 30px;">
                <td class="tdtitle">
                    <label class="boxlabel"> Course Category<span class="labelhnd"> / कोर्स की श्रेणी</span></label>
                </td>
                <td class="tddesc1">
                    <p class="fldentry"><?= $data->date_admission ?> </p>
                </td>
                <td rowspan="2" class="tdtitle2">
                    <label class="boxlabel"> Student's Address /<br><span class="labelhnd" style="margin-left: 5px;"> छात्र/छात्रा का पता </span></label>
                </td>
                <td rowspan="2" class="tddesc2">
                    <p class="fldentry"><?= $data->address1 ?></p>
                </td>
            </tr>
            <tr style="height: 30px;">
                <td class="tdtitle">
                    <label class="boxlabel"> Course type<span class="labelhnd"> / कोर्स का प्रकार</span></label>
                </td>
                <td class="tddesc1">
                    <p class="fldentry"><?= $data->course_type ?></p>
                </td>

            </tr>

            <tr>
                <td colspan="6" style="border: 2px solid black;">
                    <h4 style="margin: 5px;font-family: Source Sans Pro;"> Declaration<span style="font-size: 14px;"> / घोषणा </span></h4>
                    <p style="margin: 0px 5px; font-size: 14px;  font-family: Source Sans Pro;"> I declare that all the information given by me in this form is correct to the best of my knowledge and belief. I also assure that if any of the above statements are found to be false, then I am liable to be disqualified and my admission can be canceled.<br><br>
                        <span style="font-size: 13px;font-family: Source Sans Pro;"> मैं इस बात की घोषणा करता/करती हूँ कि मेरे द्वारा इस फॉर्म में दी गई सभी जानकारी मेरे ज्ञान और विश्वास के अनुसार सही है। मैं
                            यह भी आश्वस्त कराता हूँ कि यदि उपरोक्त कथनों में से कोई भी कथन गलत पाया जाता है तो मैं अयोग्य घोषित होने के लिए उत्तरदायी हूँ और मेरा प्रवेश रद्द किया जा सकता है।</span>
                    </p><br>
                    <p style="float: right;margin-right: 5px;font-family: Source Sans Pro;"><b> (Student's Signature / <span style="font-size: 14px;"> छात्र/छात्रा के हस्ताक्षर)</span></b></p>
                </td>
            </tr>


            <tr>
                <td colspan="6" style="border: 2px solid black;">
                    <h4 style="margin: 5px;font-family: Source Sans Pro;"> Important Instructions</h4>


                    <ol style="margin-right: 5px;padding-left: 20px; font-size: 14px;font-family: Source Sans Pro;">
                        <li>In case of any discrepancy found in the above details please inform us immediately at <a href="mailto: info@iacteducation.com" style="color: black;"> info@iacteducation.com</a>.</li>
                        <li>Please visit <a href="iacteducation.com" style="color: black;">www.iacteducation.com</a> regarding Admissions & Certification verification.</li>
                        <li> For study and training material please contact your branch or you may call or whatsapp at <b>9910039064</b>.
                        </li>
                        <li>Minimum 80% attendance is required to appear in exam. Please maintain punctuality.</li>
                        <li>Admission transfer facility is available at <?=$_SESSION['site_name']?>. In case if you required transfer at any of our branches, Please send a request
                            along with your branch head permission at <a href="mailto: admin@iacteducation.com" style="color: black;">admin@iacteducation.com</a>.</li>
                    </ol>
                    <h4 style="margin: 5px;font-family: Source Sans Pro;font-size: 14px;"> महत्वपूर्ण निर्देश:</h4>

                    <ol style="margin-right: 5px;padding-left: 20px; font-size: 14px; font-family: Source Sans Pro; line-height: 1.7;">
                        <li> <span style="font-size: 13px">उपरोक्त विवरण में पाई गई किसी भी विसंगति के मामले मे </span><a href="mailto: info@iacteducation.com" style="color: black;">info@iacteducation.com </a> <span style="font-size: 13px">
                                पर हमें तुरंत सूचित करें ।</span></li>
                        <li> <span style="font-size: 13px">कृपया नामांकन और प्रमाणन सत्यापन के संबंध में</span> <a href="iacteducation.com" style="color: black;"> www.iacteducation.com </a><span style="font-size: 13px">
                                पर जाएं।</span></li>
                        <li> <span style="font-size: 13px">अध्ययन और प्रशिक्षण सामग्री (किताब) के लिए कृपया अपनी शाखा से संपर्क करें या आप </span> <b>9910039064</b><span style="font-size: 13px">
                                पर कॉल या व्हाट्सएप कर सकते हैं। </span>
                        </li>
                        <li><span style="font-size: 13px">परीक्षा में उपस्थित होने के लिए कम से कम </span>80%<span style="font-size: 13px"> उपस्थिति आवश्यक है। कृपया समय की पाबंदी बनाए रखें|</span></li>
                        <li><span style="font-size: 13px"><?=$_SESSION['site_name']?> में एडमिशन ट्रांसफर की सुविधा उपलब्ध है। यदि आपको हमारी किसी भी शाखा में ट्रांसफर की आवश्यकता है, तो कृपया </span>
                            <a href="mailto: admin@iacteducation.com" style="color: black;">admin@iacteducation.com</a>
                            <span style="font-size: 13px">पर अपनी शाखा प्रमुख की अनुमति के साथ एक अनुरोध भेजें। </span>
                        </li>
                    </ol>

                    </p><br>
                    <p style="float: right;margin-right: 5px;font-family: Source Sans Pro;"> <b>(Center's Signature & Seal /<span style="font-size: 14px;"> केंद्र के हस्ताक्षर और मुहर) </span><b></p>
                </td>
            </tr>

        </table>
    </page>

</body>

</html>