<html>
    pwrngpaerngpen
</html>
<?php
include_once 'assets/class/sql_file.php';
$object = new tables();
if (isset($_GET['action']) && $_GET['action'] == 'save') {
    if (!empty($_POST)) {
        $id = $_POST['n_id'];
        $data['id'] = isset($_POST['n_id']) ? $_POST['n_id'] : '';
        $data['name'] = isset($_POST['n_name']) ? $_POST['n_name'] : '';
        $data['num'] = isset($_POST['n_num']) ? $_POST['n_num'] : '';
        $data['gen'] = isset($_POST['n_radio']) ? $_POST['n_radio'] : '';
        $data['city'] = isset($_POST['n_city']) ? $_POST['n_city'] : '';
        $data['state'] = isset($_POST['n_state']) ? $_POST['n_state'] : '';
        $data['cou'] = isset($_POST['n_country']) ? $_POST['n_country'] : '';
        if (!isset($_FILES['n_img']['temp_name'])) {
            $img = $_FILES['n_img']['name'];
            $target_dir = "upload/";
            $target_file = $target_dir . basename($_FILES['n_img']['name']);
            $uploadOk = 1;
            if (move_uploaded_file($_FILES['n_img']['tmp_name'], $target_file)) {
                
            } else {
                echo "Image Uploading Failed";
                exit;
            }
        }
        $data['img'] = isset($img) ? $img : '';
        if (empty($_POST['id'])) {
            $object->insert($data);
        } else {
            $object->update($data, $id);
        }
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_POST['id'];
    $data = $object->delete($id);
    $result["status"] = 1;
    $result["content"] = $data;
    echo json_encode($result);
    exit;
} elseif (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_POST['id'];
    $data = $object->databyid($id);
    $result['status'] = 1;
    $result['content'] = $data;
    echo json_encode($result);
    exit;
} else {
    if (!empty($_POST['abc'])) {
        $abc = $_POST['abc'];
        $user_data = $object->table($abc);
    } else {
        $recode_page = 5;
        $page = '';
        $output = '';
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
        } else {
            $page = 1;
        }
        $start_from = ($page - 1) * $recode_page;
        $user_data = $object->pagein($start_from, $recode_page);
        $data2 = $object->pageins();
        $total_record = mysqli_num_rows($data2);
        $total_page = ceil($total_record / $recode_page);
    }
    $data_table = "";
    $data_table .= "<table>";
    $data_table .= "<tr><th>Image</th><th>Name</th><th>Number</th><th>Gender</th><th>City</th><th>State</th><th>Country</th><th>Delete</th><th>Edit</th></tr>";
    if (!empty($user_data)) {
        foreach ($user_data as $user) {
            $data_table .= "<tr>
                                        <td><img width='35px' height='35px' src='upload/" . $user['s_img'] . "'></td>
                                        <td>" . $user['s_name'] . "</td>
                                        <td>" . $user['s_mobile'] . "</td>
                                        <td>" . $user['s_gender'] . "</td>
                                        <td>" . $user['s_city'] . "</td>
                                        <td>" . $user['s_state'] . "</td>
                                        <td>" . $user['s_country'] . "</td>
                                        <td><button name='n_edit' class='c_delete' data-id=" . $user['s_id'] . ">Delete</button></td>
                                        <td><button name='n_delete' class='c_edit' data-id=" . $user['s_id'] . ">Edit</button></td>
                                    </tr>";
        }
    }
    $data_table .= "</table><br><br>";
    if (empty($_POST['abc'])) {
        for ($i = 1; $i <= $total_page; $i++) {
            $data_table .= "<span class = 'c_tables' style = 'cursor:pointer; padding:6px; border:1px solid #ccc;' id ='" . $i . "'>" . $i . "</span>";
        }
    }
    $result["status"] = 1;
    $result["content"] = $data_table;
    echo json_encode($result);
    exit;
}
?>