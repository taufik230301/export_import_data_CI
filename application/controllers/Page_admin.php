<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Page_admin extends CI_Controller
{
    const TABLE = 'user';
    public $table;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_models');
    }

    public function view_user()
    {
        $data_user = $this->session->all_userdata();
        if (!is_null($data_user['user'])) {
            // Parameter CONST Page_admin::TABLE
            // Parameter variable $this->table
            // Parameter Construct $this->table
            $data['users'] = $this->User_models->get_user(Page_admin::TABLE);
            $this->load->view('view_user_page', $data);
        } else {
            redirect('login_page');
        }
    }

    public function view_pembayaran()
    {
        $this->load->view('view_pembayaran_page');
    }

    public function tambah_user()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $alamat = $this->input->post('alamat');
        $id_user_level = $this->input->post('id_user_level');

        // echo $username;
        // echo "<br>";
        // echo $password;
        // echo "<br>";
        // echo $tanggal_lahir;
        // echo "<br>";
        // echo $email;
        // echo "<br>";
        // echo $no_hp;
        // echo "<br>";
        // echo $alamat;
        // echo "<br>";
        // echo $id_user_level;
        // echo "<br>";
        // die();

        $data = array(
            'username' => $username,
            'password' => $password,
            'tanggal_lahir' => $tanggal_lahir,
            'email' => $email,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
            'id_user_level' => $id_user_level,
        );

        $this->User_models->tambah($data);
        redirect('user_page');
    }

    public function edit_user()
    {
        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $alamat = $this->input->post('alamat');
        $id_user_level = $this->input->post('id_user_level');

        // echo $username;
        // echo "<br>";
        // echo $password;
        // echo "<br>";
        // echo $tanggal_lahir;
        // echo "<br>";
        // echo $email;
        // echo "<br>";
        // echo $no_hp;
        // echo "<br>";
        // echo $alamat;
        // echo "<br>";
        // echo $id_user_level;
        // echo "<br>";
        // die();
        $data = array(
            'username' => $username,
            'password' => $password,
            'tanggal_lahir' => $tanggal_lahir,
            'email' => $email,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
            'id_user_level' => $id_user_level,
        );

        $this->User_models->update($data, $id);
        redirect('user_page');
    }

    public function delete_user($id)
    {
        $this->User_models->delete($id);
        redirect('user_page');
    }

    public function cetak_laporan_pdf()
    {
        $data['users'] = $this->User_models->get_user('user');

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan-user.pdf";
        $this->pdf->load_view('laporan_pdf.php', $data);
    }

    public function upload_file()
    {
        $upload_file = $_FILES['upload_file']['name'];
        $extension = pathinfo($upload_file, PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else if ($extension == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            echo "Anda Memasukan File Yang salah";
            die();
        }
        $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata = $spreadsheet->getActiveSheet()->toArray();
        $sheetcount = count($sheetdata);

        if ($sheetcount > 1) {
            for ($row = 1; $row < $sheetcount; $row++) {
                $username = $sheetdata[$row][0];
                $password = $sheetdata[$row][1];
                $tanggal_lahir = $sheetdata[$row][2];
                $email = $sheetdata[$row][3];
                $no_hp = $sheetdata[$row][4];
                $alamat = $sheetdata[$row][5];
                $id_user_level = $sheetdata[$row][6];

                $data[] = array(
                    'username' => $username,
                    'password' => $password,
                    'tanggal_lahir' => $tanggal_lahir,
                    'email' => $email,
                    'no_hp' => $no_hp,
                    'alamat' => $alamat,
                    'id_user_level' => $id_user_level,
                );
            }
            $count = count($data);

            for ($i = 0; $i < $count; $i++) {
                $insert_excel = $this->User_models->insert_excel($data[$i]);
            }
            if ($insert_excel) {
                redirect('user_page');
            } else {
                echo "Gagal";
            }

        }

    }

    public function cetak_laporan_excel()
    {
        // Fetch the data
        $data = $this->User_models->get_user(Page_admin::TABLE);
       
        

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="user.csv"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Username');
        $sheet->setCellValue('B1', 'Password');
        $sheet->setCellValue('C1', 'Tanggal Lahir');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'No HP');
        $sheet->setCellValue('F1', 'Alamat');
        $sheet->setCellValue('G1', 'Id User Level');

        $sn = 2;
        foreach ($data as $user) {
            $sheet->setCellValue('A'.$sn, $user['username']);
            $sheet->setCellValue('B'.$sn, $user['password']);
            $sheet->setCellValue('C'.$sn, $user['tanggal_lahir']);
            $sheet->setCellValue('D'.$sn, $user['email']);
            $sheet->setCellValue('E'.$sn, $user['no_hp']);
            $sheet->setCellValue('F'.$sn, $user['alamat']);
            $sheet->setCellValue('G'.$sn, $user['id_user_level']);
            $sn++;
        }

        $writer = new Xlsx($spreadsheet);
        
        $writer->save("php://output");
        
    }
}
