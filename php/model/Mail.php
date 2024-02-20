<?php
if (!empty($_POST)) {
    require_once('../../vendor/autoload.php');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Mpdf\Mpdf;

class MyMailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function sendMail($email, $subject, $message, $imageFilePath = false)
    {
        try {
            // $this->mail->SMTPDebug = true;
            $this->configureMailer();

            $this->mail->setFrom('narender.neet@gmail.com', 'Akhil Bhartiya Computer Trainer Association');
            $this->mail->addAddress($email);
            $this->mail->addCC('narender.neet@gmail.com');

            $this->mail->IsHTML(true);
            $this->mail->Subject = $subject;

            // Attach PDF
            if ($imageFilePath) {
                $mpdf = new Mpdf();
                $mpdf->WriteHTML($message);
                $pdfContent = $mpdf->Output('', 'S');
                $pdfFileName = 'student_id_card.pdf';
                $this->mail->addStringAttachment($pdfContent, $pdfFileName, 'base64', 'application/pdf');
            }

            $this->mail->Body = $message;
            $this->mail->AltBody = $message;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function configureMailer()
    {
        $this->mail->isSMTP();
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "narender.neet@gmail.com";
        $this->mail->Password = "iwff oqva vkan ueem";
        // $this->mail->Password = "wmeo nxop hagi hizs";
        // iwff oqva vkan ueem

        // $this->mail->Username = "narenderrai687@gmail.com";
        // $this->mail->Password = "zeub rhgm dmek ojux";
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;
    }

    public function mail($post, $branch, $subject, $profile_image, $enrollment = null)
    {
        $base = "https://aicta.iactajmer.in/";  
        $head = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Information Email</title>
        <style>
            body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            color: #333;
            }

        

            header {
            background-color: #fff;
            color: #fff;
            text-align: center;
            padding: 10px;
            }

            table {
            width: 100%;
            border-collapse: collapse;
            }

            table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            }

            table td strong {
            display: block;
            }
            .fw-bold{
            font-weight: bold;
            }

            td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            }
            
        </style>
        </head>

        <body>';

        $profileImagePath = $base . '/assets/upload/' . $profile_image;

        $header = '<div class="container">
            <table style="width: 100%; text-align: center;">
                <tr>
                    <td>
                        <img src="' . $base . '/assets/image/logo.gif" alt="Logo" style="max-width: 100%; width: 100px;height: 100px;" />
                    </td>
                    <td>
                        <h2 style="color: turquoise; font-size: 18px;">All India Computer Trainers Association</h2>
                    </td>
                </tr>
            </table>

            <div style="text-align: center;margin-top:20px;margin-bottom:10px">
                <img src="' . $profileImagePath . '" alt="Logo" style="width: 100px;height: 100px;">
            </div>';

        $main = '<h4 style="margin: 0px;line-height: 160%;text-align: center;word-wrap: break-word;">Hi ' . (isset($post['student_name']) ? $post['student_name'] : '') .  ',</h4>
            <h1 class="v-font-size" style="margin: 0px;text-align: center; word-wrap: break-word;font-size: 33px;">
                <span>' . $subject . '</span>
            </h1>
            <div style="text-align: center; padding: 10px 0;">
                <img src="' . $base . '/assets/image/check.png" alt="Logo" style="max-height: 50px;">
            </div>
            <div>';

        $studentTable = '<h2 style="color: #333;">Student Information</h2><table>';

        $studentTable .= <<<HTML
            <tr>
                <td class="fw-bold">Name:</td>
                <td>{$post['student_name']}</td>
            </tr>
            
            <tr>
                <td class="fw-bold">Father Name:</td>
                <td>{$post['father_name']}</td>
            </tr>
        
            <tr>
                <td class="fw-bold">Course:</td>
                <td>{$branch->course_name}</td>
            </tr>
        
            <tr>
                <td class="fw-bold">Student Phone:</td>
                <td>{$post['student_phone']}</td>
            </tr>
        HTML;


        if (isset($enrollment) && $enrollment != null) {
            $studentTable .= '<tr>
                                <td class="fw-bold">Enrollment:</td>
                                <td>' . ($enrollment) . '</td>
                            </tr>';
        }

        $studentTable .= <<<HTML
            <tr>
                <td class="fw-bold">WhatsApp Phone:</td>
                <td>{$post['student_whatsapp_phone']}</td>
            </tr>
            <tr>
                <td class="fw-bold">Date Admission:</td>
                <td>{$post['date_admission']}</td>
            </tr>
            <tr>
                <td class="fw-bold">Date of Birth:</td>
                <td>{$post['student_dob']}</td>
            </table>
        HTML;

        $branchTable = <<<HTML
                <h2 style="color: #333;">Branch Information</h2>
                <table>
                    <tr>
                        <td class="fw-bold">Branch Name:</td>
                        <td>{$branch->name}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Branch Code:</td>
                        <td>{$branch->code}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Branch Head:</td>
                        <td>{$branch->head}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Branch Email:</td>
                        <td>{$branch->email}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Branch Address:</td>
                        <td>{$branch->address},<br> {$branch->city_name}, {$branch->state_name}</td>
                    </tr>
                </table>
             
                </body>
                </html>
            HTML;
        $message = $head . $header . $main . $studentTable . $branchTable;
        return $message;
    }
}
