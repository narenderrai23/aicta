<?php
require_once 'connection.php';
require_once 'common.php';
require 'Mail.php';


class Student extends Common
{
    protected $db;

    function __construct()
    {
        $this->db = new Connection();
    }

    function insertStudent()
    {
        try {
            $conn = $this->db->getConnection();
            $post = $_POST;

            // Set default values
            $post['student_status'] = 'running';
            $status = 'active';
            $admin = $_SESSION['login'];

            if ($_SESSION['role'] === 'branch') {
                $post['branch_id'] = $_SESSION['loggedin'];
            }
            // Validate student data
            $validationResult = $this->validateStudentData($post, true);
            if ($validationResult['status'] === false) {
                return $validationResult;
            }

            // Fetch branch and city information
            $branch_id = $post['branch_id'];
            $tblbranch = $this->fetch('tblbranch', 'city_id', $branch_id);

            if (!$tblbranch || !isset($tblbranch['city_id'])) {
                return (['status' => false, 'message' => "Please fill in all required fields. The field 'Branch' is required."]);
            }

            $city_id = $tblbranch['city_id'];
            $cityCode = $this->fetch('cities', 'city_code', $city_id);

            if (!$cityCode || !isset($cityCode['city_code'])) {
                return (['status' => false, 'message' => 'fail to update']);
            }

            $code = $cityCode['city_code'];

            // Generate enrollment code
            $lastId = $this->getLastIDQuery('students');
            $enrollment = 'New-' . $code . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);


            // Move uploaded file
            $profileImage = $_FILES['profile_image'];
            $uploadDirectoryProfile = '../../assets/upload/';
            $profile_image = $this->moveUploadedFile($profileImage, $uploadDirectoryProfile, $enrollment);

            $courses = $this->fetch('courses', '*', $post['course_name']);
            $todayPlusDuration = date('Y-m-d', strtotime($post['date_admission'] . ' +' . $courses['course_duration'] . ' ' . $courses['duration_time']));

            if ($profile_image !== false) {
                // Define the SQL query with named placeholders
                $sql = "INSERT INTO students (date_admission,  course, branch_id, enrollment, student_name, father_name, father_occupation, student_dob, gender, address1, address2, 
                student_state, student_district, student_phone, w_phone, student_email, qualification, pqualification, student_status, admin, till_date, profile_image, status)
                VALUES (:date_admission,  :course_name, :branch_id, :enrollment, :student_name, :father_name, :father_occupation, :student_dob, :gender, :address1, :address2, 
                :student_state, :student_district, :student_phone, :w_phone, :student_email, :qualification, :pqualification, :student_status, :admin,
                :till_date, :profile_image, :status)";
                $stmt = $conn->prepare($sql);

                // Bind parameters to named placeholders
                $stmt->bindParam(':date_admission', $post['date_admission']);
                $stmt->bindParam(':course_name', $post['course_name']);
                $stmt->bindParam(':branch_id', $branch_id);
                $stmt->bindParam(':enrollment', $enrollment);
                $stmt->bindParam(':student_name', $post['student_name']);
                $stmt->bindParam(':father_name', $post['father_name']);
                $stmt->bindParam(':father_occupation', $post['father_occupation']);
                $stmt->bindParam(':student_dob', $post['student_dob']);
                $stmt->bindParam(':gender', $post['gender']);
                $stmt->bindParam(':student_state', $post['student_state']);
                $stmt->bindParam(':student_district', $post['student_district']);
                $stmt->bindParam(':student_phone', $post['student_phone']);
                $stmt->bindParam(':w_phone', $post['w_phone']);
                $stmt->bindParam(':student_email', $post['student_email']);
                $stmt->bindParam(':qualification', $post['qualification']);
                $stmt->bindParam(':pqualification', $post['pqualification']);
                $stmt->bindParam(':student_status', $post['student_status']);
                $stmt->bindParam(':address1', $post['address1']);
                $stmt->bindParam(':address2', $post['address2']);
                $stmt->bindParam(':admin', $admin);
                $stmt->bindParam(':profile_image', $profile_image);
                $stmt->bindParam(':till_date', $todayPlusDuration, PDO::PARAM_STR);
                $stmt->bindParam(':status', $status);

                if ($stmt->execute()) {
                    $lastInsertedId = $conn->lastInsertId();

                    // Insert student qualifications
                    $qualificationResult = $this->students_qualification($post, $lastInsertedId);

                    if ($qualificationResult['status'] === 'success') {
                        if (!empty($profile_image)) {
                            $branch = $this->mailData($post['branch_id'], $post['course_name']);
                            $subject = "You Are Registered successfully";
                            $imageFilePath = '../../assets/upload/' . $profile_image;
                            $mailer = new MyMailer();
                            $message = $mailer->mail($post, $branch, $subject, $profile_image);
                            $mailer->sendMail($post['student_email'], $subject, $message, $imageFilePath);
                        }
                        return ['status' => 'success', 'message' => 'Student record, qualifications, and registration email sent successfully'];
                    } else {
                        return ['status' => false, 'message' => 'Error: Failed to add student qualifications'];
                    }
                } else {
                    return ['status' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
                }
            } else {
                return ['status' => false, 'message' => 'Error: File could not be uploaded.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Database Error: ' . $e->getMessage()];
        }
    }


    function updateStudent()
    {
        try {
            $conn = $this->db->getConnection();
            $post = $_POST;
            $id = $_POST['id'];

            $validationResult = $this->validateStudentData($post);
            if ($validationResult['status'] === false) {
                return $validationResult;
            }
            $courses = $this->fetch('courses', '*', $post['course_name']);
            $todayPlusDuration = date('Y-m-d', strtotime($post['date_admission'] . ' +' . $courses['course_duration'] . ' ' . $courses['duration_time']));

            // Modify the SQL query to perform an update
            $sql = "UPDATE students SET 
                date_admission = :date_admission,
                course = :course_name,
                till_date = :till_date,
                branch_id = :branch_id,
                student_name = :student_name,
                father_name = :father_name,
                father_occupation = :father_occupation,
                student_dob = :student_dob,
                gender = :gender,
                student_state = :student_state,
                student_district = :student_district,
                student_phone = :student_phone,
                w_phone = :w_phone,
                student_email = :student_email,
                qualification = :qualification,
                pqualification = :pqualification,
                student_status = :student_status,
                address1 = :address1,
                address2 = :address2";


            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                $sql .= ", profile_image = :profile_image";
            }

            $sql .= " WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':date_admission', $post['date_admission']);
            $stmt->bindParam(':course_name', $post['course_name']);
            $stmt->bindParam(':branch_id', $post['branch_id']);
            $stmt->bindParam(':student_name', $post['student_name']);
            $stmt->bindParam(':father_name', $post['father_name']);
            $stmt->bindParam(':father_occupation', $post['father_occupation']);
            $stmt->bindParam(':student_dob', $post['student_dob']);
            $stmt->bindParam(':gender', $post['gender']);
            $stmt->bindParam(':student_state', $post['student_state']);
            $stmt->bindParam(':student_district', $post['student_district']);
            $stmt->bindParam(':student_phone', $post['student_phone']);
            $stmt->bindParam(':w_phone', $post['w_phone']);
            $stmt->bindParam(':student_email', $post['student_email']);
            $stmt->bindParam(':qualification', $post['qualification']);
            $stmt->bindParam(':pqualification', $post['pqualification']);
            $stmt->bindParam(':student_status', $post['student_status']);
            $stmt->bindParam(':till_date', $todayPlusDuration, PDO::PARAM_STR);
            $stmt->bindParam(':address1', $post['address1']);
            $stmt->bindParam(':address2', $post['address2']);

            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                $image_name = 'New-' . str_pad($id, 4, '0', STR_PAD_LEFT);
                $image = $this->fetch('students', 'profile_image', $id);

                if ($image['profile_image']) {
                    $this->deleteImage($image['profile_image']);
                }

                $profileImage = $_FILES['profile_image'];
                $uploadDirectoryProfile = '../../assets/upload/';
                $profile_image = $this->moveUploadedFile($profileImage, $uploadDirectoryProfile, $image_name);
                $stmt->bindParam(':profile_image', $profile_image, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $qualificationResult = $this->updateStudentQualifications($post, $id);

                if ($qualificationResult['status'] === 'success') {
                    return ['status' => 'success', 'message' => 'Student record updated successfully'];
                } else {
                    return ['status' => false, 'message' => 'Error: Failed to update student qualifications'];
                }
            } else {
                return ['status' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Database Error: ' . $e->getMessage()];
        }
    }

    function oldUpdateStudent()
    {
        try {
            $conn = $this->db->getConnection();
            $post = $_POST;
            $id = $_POST['id'];

            $validationResult = $this->validateStudentData($post);
            if ($validationResult['status'] === false) {
                return $validationResult;
            }
            $courses = $this->fetch('courses', '*', $post['course_name']);
            $todayPlusDuration = date('Y-m-d', strtotime($post['date_admission'] . ' +' . $courses['course_duration'] . ' ' . $courses['duration_time']));
            // Modify the SQL query to perform an update
            $sql = "UPDATE student_mst SET 
                date_admission = :date_admission,
                course_id = :course_name,
                till_date = :till_date,
                branch_id = :branch_id,
                student_name = :student_name,
                father_name = :father_name,
                father_occupation = :father_occupation,
                student_dob = :student_dob,
                gender = :gender,
                student_state = :student_state,
                student_district = :student_district,
                student_phone = :student_phone,
                w_phone = :w_phone,
                student_email = :student_email,
                student_status = :student_status,
                address1 = :address1,
                address2 = :address2";


            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                $sql .= ", profile_image = :profile_image";
            }

            $sql .= " WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':date_admission', $post['date_admission']);
            $stmt->bindParam(':course_name', $post['course_name']);
            $stmt->bindParam(':branch_id', $post['branch_id']);
            $stmt->bindParam(':student_name', $post['student_name']);
            $stmt->bindParam(':father_name', $post['father_name']);
            $stmt->bindParam(':father_occupation', $post['father_occupation']);
            $stmt->bindParam(':student_dob', $post['student_dob']);
            $stmt->bindParam(':gender', $post['gender']);
            $stmt->bindParam(':student_state', $post['student_state']);
            $stmt->bindParam(':student_district', $post['student_district']);
            $stmt->bindParam(':student_phone', $post['student_phone']);
            $stmt->bindParam(':w_phone', $post['w_phone']);
            $stmt->bindParam(':student_email', $post['student_email']);
            $stmt->bindParam(':student_status', $post['student_status']);
            $stmt->bindParam(':till_date', $todayPlusDuration, PDO::PARAM_STR);
            $stmt->bindParam(':address1', $post['address1']);
            $stmt->bindParam(':address2', $post['address2']);

            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                $image_name = 'New-' . str_pad($id, 4, '0', STR_PAD_LEFT);
                $image = $this->fetch('students', 'profile_image', $id);

                $profileImage = $_FILES['profile_image'];
                $uploadDirectoryProfile = '../../assets/upload/';
                $profile_image = $this->moveUploadedFile($profileImage, $uploadDirectoryProfile, $image_name);
                $stmt->bindParam(':profile_image', $profile_image, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $qualificationResult = $this->updateStudentQualifications($post, $id);

                if ($qualificationResult['status'] === 'success') {
                    return ['status' => 'success', 'message' => 'Student record updated successfully'];
                } else {
                    return ['status' => false, 'message' => 'Error: Failed to update student qualifications'];
                }
            } else {
                return ['status' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Database Error: ' . $e->getMessage()];
        }
    }




    function mailData($id, $course)
    {
        $conn = $this->db->getConnection();
        $selectSql = "SELECT 
        tblbranch.*, 
        courses.*, 
        states.state_name, 
        cities.city_name FROM tblbranch 
        JOIN states ON tblbranch.state_id = states.id 
        JOIN courses ON courses.id = $course 
        JOIN cities ON cities.id = cities.id 
        WHERE tblbranch.id = :id";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $selectStmt->execute();
        return $selectStmt->fetch(PDO::FETCH_OBJ);
    }

    function generateEnrollmentNumber($CityCode, $date_admission, $lastId)
    {
        $date_admission = $date_admission = date("Ymd");
        $lastId = str_pad($lastId, 4, '0', STR_PAD_LEFT);
        $enrollment = $CityCode . str_replace('-', '', $date_admission) . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        return $enrollment;
    }

    function validateStudentData($post, $checkForDuplicates = false)
    {
        $requiredFields = [
            'student_name',
            'course_name',
            'branch_id',
            'student_dob',
            'student_phone',
            'student_state',
            'student_district',
            'w_phone',
            'date_admission',
            'father_name',
            'gender',
            'address1',
            'student_status'
        ];

        $missingFields = $this->checkRequiredFields($post, $requiredFields);
        if (!empty($missingFields)) {
            return ['status' => false, 'message' => "Error: The following fields are required: " . implode(', ', $missingFields)];
        }

        if (isset($post['student_phone']) && $checkForDuplicates) {
            $student_phone = $post['student_phone'];
            $cleaned_phone = preg_replace('/[^0-9]/', '', $student_phone);
            if (strlen($cleaned_phone) !== 10) {
                return [
                    'status' => false,
                    'message' => 'Student phone number must contain exactly 10 digits.',
                ];
            }

            // $phoneExists = $this->isValueExists("students", "student_phone", $student_phone);
            // if ($phoneExists) {
            //     return ['status' => false, 'message' => "Error: A student with this phone number already exists."];
            // }
        }
        // Validate student_email
        if (isset($post['student_email']) && !empty($student_email)) {
            $student_email = $post['student_email'];
            if (!filter_var($student_email, FILTER_VALIDATE_EMAIL)) {
                $validationResult = [
                    'status' => false,
                    'message' => 'Invalid email format for student_email.',
                ];
                return $validationResult;
            }

            $emailExists = $this->isValueExists("students", "student_email", $student_email);
            if (isset($student_email) && $emailExists) {
                return ['status' => false, 'message' => "Error: A student with this email address already exists."];
            }
        }



        return ['status' => 'success'];
    }

    function students_qualification($post, $lastInsertedId)
    {
        $qualification = $post['qualification'] ?? null;
        $board_university = $post['board_university'] ?? null;
        $year_of_passing = $post['year_of_passing'] ?? null;
        $percentage = $post['percentage'] ?? null;

        $conn = $this->db->getConnection();
        $sql = "INSERT INTO students_qualification (student_id, qualification, board_university, year_of_passing, percentage)
            VALUES (:student_id, :qualification, :board_university, :year_of_passing, :percentage)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':qualification', $qualification);
        $stmt->bindParam(':student_id', $lastInsertedId);
        $stmt->bindParam(':board_university', $board_university);
        $stmt->bindParam(':year_of_passing', $year_of_passing);
        $stmt->bindParam(':percentage', $percentage);
        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Educational qualification record added successfully'];
        } else {
            return ['status' => false, 'message' => 'Error: Failed to add educational qualification record'];
        }
    }

    function updateStudentQualifications($post, $studentId)
    {
        try {
            $conn = $this->db->getConnection();
            $existingQualifications = $this->getStudentQualifications($studentId);

            $qualification = $post['qualification'] ?? null;
            $board_university = $post['board_university'] ?? null;
            $year_of_passing = $post['year_of_passing'] ?? null;
            $percentage = $post['percentage'] ?? null;

            if (empty($existingQualifications)) {
                $sql = "INSERT INTO students_qualification (student_id, qualification, board_university, year_of_passing, percentage)
                VALUES (:student_id, :qualification, :board_university, :year_of_passing, :percentage)";
            } else {
                $sql = "UPDATE students_qualification SET qualification = :qualification, board_university = :board_university,
                year_of_passing = :year_of_passing, percentage = :percentage WHERE student_id = :student_id";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':qualification', $qualification);
            $stmt->bindParam(':student_id', $studentId);
            $stmt->bindParam(':board_university', $board_university);
            $stmt->bindParam(':year_of_passing', $year_of_passing);
            $stmt->bindParam(':percentage', $percentage);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Educational qualification record updated successfully'];
            } else {
                return ['status' => false, 'message' => 'Error: Failed to update educational qualification record'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'message' => 'Database Error: ' . $e->getMessage()];
        }
    }

    function getStudentQualifications($studentId)
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM students_qualification WHERE student_id = :student_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function approveStatusUpdate($id, $table, $mail = true)
    {
        $conn = $this->db->getConnection();
        $post = $this->fetch($table, '*', $id);
        $status = $post['approve'] === 'yes' ? 'no' : 'yes';

        if ($post['approve'] === 'yes') {
            return ['status' => false, 'message' => 'Already approved'];
        }

        $tblbranch = $this->fetch('tblbranch', 'city_id', $post['branch_id']);
        if (!$tblbranch) {
            return ['status' => false, 'message' => 'Select Correct Branch.'];
        }

        $cityCode = $tblbranch ? $this->fetch('cities', 'city_code', $tblbranch['city_id']) : null;
        if (!$cityCode) {
            return ['status' => false, 'message' => 'Select Correct City'];
        }

        $enrollment = $this->generateEnrollmentNumber($cityCode['city_code'], $post['date_admission'], $id);


        $sql = "UPDATE $table SET approve=:approve, enrollment= :enrollment WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':approve', $status, PDO::PARAM_STR);
        $stmt->bindParam(':enrollment', $enrollment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {
                if ($mail) {
                    $branch = $this->mailData($post['branch_id'], $post['course']);
                    $this->sendConfirmationEmail($id, $enrollment, $post, $branch);
                }
                return (['status' => 'success', 'enrollment' => $enrollment, 'message' => 'Status updated!']);
            } else {
                return (['status' => false, false => 'Error updating data in the database: ' . $stmt->errorInfo()]);
            }
        } catch (PDOException $e) {
            return (['status' => false, false => 'Database error: ' . $e->getMessage()]);
        }
    }

    function sendConfirmationEmail($id, $enrollment, $post, $branch)
    {
        $subject = "Your Admission is Confirm!";
        $mailer = new MyMailer();
        $message = $mailer->mail($post, $branch, $subject, $post['profile_image'], $enrollment);
        $mailer->sendMail($post['student_email'], $subject, $message);
    }

    function updateStudentStatus($id, $status, $table)
    {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("UPDATE $table SET student_status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return (['status' => true, 'color' => $status, 'message' => 'Status Updated WHERE Id =' . $id]);
        } catch (PDOException $e) {
            return (['status' => false, 'message' => 'Status update failed']);
        }
    }

    function fetchStudent($id)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT 
        students.*,
        tblbranch.name AS branch_name, 
        tblbranch.code AS branch_code,
        district.district,
        education_level.level,
        courses.*, 
        s_q.*
        FROM students 
        LEFT JOIN tblbranch ON tblbranch.id = students.branch_id
        LEFT JOIN district ON district.id = students.student_district
        LEFT JOIN education_level ON education_level.id = students.qualification
        LEFT JOIN courses ON courses.id = students.course
        LEFT JOIN students_qualification AS s_q ON s_q.student_id = students.id";

        $whereClause = [];
        $params = [];
        $whereClause[] = "students.id = :id";
        $params[':id'] = ['value' => $id, 'type' => PDO::PARAM_INT];
        if ($_SESSION['role'] === 'branch') {
            $whereClause[] = "branch_id = :branch_id";
            $params[':branch_id'] = ['value' => $_SESSION['loggedin'], 'type' => PDO::PARAM_INT];
        }

        if (!empty($whereClause)) {
            $query .= " WHERE " . implode(' AND ', $whereClause);
        }

        $stmt = $conn->prepare($query);
        foreach ($params as $paramName => &$paramData) {
            $stmt->bindParam($paramName, $paramData['value'], $paramData['type']);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function fetchStudentOld($id)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT 
        student_mst.*,
        tblbranch.name AS branch_name,
        tblbranch.code AS branch_code,
        courses.*
        FROM student_mst 
        LEFT JOIN tblbranch ON tblbranch.id = student_mst.branch_id
        LEFT JOIN courses ON courses.id = student_mst.course_id";

        $whereClause = [];
        $params = [];
        $whereClause[] = "student_mst.id = :id";
        $params[':id'] = ['value' => $id, 'type' => PDO::PARAM_INT];

        if ($_SESSION['role'] === 'branch') {
            $whereClause[] = "branch_id = :branch_id";
            $params[':branch_id'] = ['value' => $_SESSION['loggedin'], 'type' => PDO::PARAM_INT];
        }

        if (!empty($whereClause)) {
            $query .= " WHERE " . implode(' AND ', $whereClause);
        }

        $stmt = $conn->prepare($query);
        foreach ($params as $paramName => &$paramData) {
            $stmt->bindParam($paramName, $paramData['value'], $paramData['type']);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
