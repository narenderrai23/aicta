<table width="98%" cellspacing="0" cellpadding="0" class="table table-bordered">
    <tr>
        <td valign="top">
            <table>
                <tr>
                    <td colspan="2">
                        <h4>1. Branch/Course Details</h4>
                    </td>
                </tr>
                <tr>
                    <td>Admission Date :
                        <?= $admissiondate; ?>
                    </td>
                </tr>
                <tr>
                    <td>Serial Number :
                        <?= $serialno; ?>
                    </td>
                </tr>
                <tr>
                    <td>Enrollment Number :
                        <?= $enroll; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td align="center">
            <?php
            if ($image != "") {
                ?>
                <img src="../galcontent/<?= $finalstr; ?>" width="100" height="100">
                <?php
            }
            ?>
        </td>
    </tr>

    <tr>
        <td>Branch Code:
            <?= $branchcode ?>
        </td>
        <td>Branch Name :
            <?= $branchnm; ?>
        </td>
    </tr>

    <tr>
        <td>Course Code:
            <?= $cousecode; ?>
        </td>
        <td>Course Short Name:
            <?= $courseshortnm ?>
        </td>
    </tr>

    <tr>
        <td>Course Name :
            <?= $coursesnm; ?>
        </td>
        <td>Course Duration:
            <?= $duration . " " . $strduration1; ?>
        </td>
    </tr>

    <tr>
        <td>Course Category :
            <?= $catnm; ?>
        </td>
        <td>Course Type:
            <?= $ctype; ?>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <h4>2. Basic Information</h4>
        </td>
    </tr>

    <tr>
        <td>Name:
            <?= $name; ?>
        </td>
        <td>Date of Birth:
            <?= $dob; ?>
        </td>
    </tr>

    <tr>
        <td>Father Name:
            <?= $fname; ?>
        </td>
        <td>Father Occupation:
            <?= $foccupation; ?>
        </td>
    </tr>

    <tr>
        <td>Gender:
            <?= $gendernm; ?>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <h4>3. Contact Information</h4>
        </td>
    </tr>

    <tr>
        <td>Mobile:
            <?= $mobile; ?>
        </td>
        <td>Email:
            <?= $email; ?>
        </td>
    </tr>

    <tr>
        <td>Address (Line1):
            <?= $add1; ?>
        </td>
        <td>Address (Line2):
            <?= $add2; ?>
        </td>
    </tr>

    <tr>
        <td>State:
            <?= $statenm; ?>
        </td>
        <td>District:
            <?= $citynm; ?>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <h4>4. Educational Qualification</h4>
        </td>
    </tr>

    <tr>
        <td colspan="2">

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="frmlabel">
                            S.No.
                        </th>
                        <th class="frmlabel">
                            Education
                        </th>
                        <th class="frmlabel">
                            Board/University
                        </th>
                        <th class="frmlabel">
                            Year of Passing
                        </th>

                        <th class="frmlabel">
                            Percentage
                        </th>
                    </tr>


                    <tr>
                        <td>
                            1.
                        </td>
                        <td>
                            10th
                        </td>
                        <td>
                            <?= $a1; ?>
                        </td>
                        <td>
                            <?= $b1; ?>
                        </td>

                        <td>
                            <?= $d1; ?>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            2.
                        </td>
                        <td>
                            10+2
                        </td>
                        <td>
                            <?= $a2; ?>
                        </td>
                        <td>
                            <?= $b2; ?>
                        </td>

                        <td>
                            <?= $d2; ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            3.
                        </td>
                        <td>
                            Graduation
                        </td>
                        <td>
                            <?= $a3; ?>
                        </td>
                        <td>
                            <?= $b3; ?>
                        </td>

                        <td>
                            <?= $d3; ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            4.
                        </td>
                        <td>
                            Others
                        </td>
                        <td>
                            <?= $a4; ?>
                        </td>
                        <td>
                            <?= $b4; ?>
                        </td>

                        <td>
                            <?= $d4; ?>
                        </td>
                    </tr>

                </tbody>
            </table>

        </td>
    </tr>

    <tr>
        <td colspan="2">
            <h4>5. Professional Qualification</h4>
        </td>
    </tr>

    <tr>
        <td colspan="2">Qualification :
            <?= $qulification; ?>
        </td>

    </tr>

    <tr>
        <td colspan="2">
            <h4>6. Others</h4>
        </td>
    </tr>

    <tr>
        <td>Status :
            <?= $status; ?>
        </td>
        <td>Bag Required :
            <?= $breq; ?>
        </td>
    </tr>

</table>